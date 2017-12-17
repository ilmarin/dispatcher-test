<?php
namespace cls;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Queue class
 *
 * Either sends message to a queue or run worker
 */
class Queue
{

    /**
     * Connection instance
     *
     * @var PhpAmqpLib\Connection\AMQPStreamConnection
     */
    private $conn;

    /**
     * Channel instance
     *
     * @var PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;

    public function __construct()
    {
        $this->conn = new AMQPStreamConnection(RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USER, RABBITMQ_PASSWORD);

        $this->channel = $this->conn->channel();

        // Declare queue
        $this->channel->queue_declare(RABBITMQ_QUEUE, false, true, false, false);
    }

    /**
     * Sends message to a queue
     *
     * @param string $message
     * @return boolean
     */
    public function send($message)
    {
        $msg = new AMQPMessage($message, array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));

        $this->channel->basic_publish($msg, '', RABBITMQ_QUEUE);

        echo ' [x] Sent ', $message, "\n";

        return true;
    }

    /**
     * Run queue worker
     *
     * @return boolean
     */
    public function run()
    {

        $callback = function($msg) {
            $tokens = explode(';', $msg->body);

            echo " [x] Received ", $msg->body, "\n";

            $groupId = $tokens[0];

            $fullName = $tokens[1] . ' ' . $tokens[2] . ' ' . $tokens[3];

            $email = $tokens[4];

            echo 'Recepient: ' . $fullName . ', e-mail: ' . $email . "\n";

            echo 'Message text:' . "\n";

            switch ($groupId) {
                case Dispatcher::GROUP_A:
                    echo sprintf('Здравствуйте, %s, Вы давно не появлялись на сервисе, узнайте последние новости по ссылке: https://google.ru', $fullName) . "\n";
                    break;
                case Dispatcher::GROUP_B:
                    echo sprintf('Здравствуйте, %s, у нас для вас акция, подробности можно узнать по ссылке: https://google.ru', $fullName) . "\n";
                    break;
                case Dispatcher::GROUP_C:
                    echo sprintf('Здравствуйте, %s, Вы выбраны для участия в акции %s. Успейте до %s принять участие.', $fullName, $tokens[5], date('d.m.Y', strtotime($tokens[6]))) . "\n";
            }

            // Emulates e-mail sending
            usleep(100000);

            echo 'Message sent' . "\n\n";
        };

        $this->channel->basic_consume(RABBITMQ_QUEUE, '', false, true, false, false, $callback);

        // Turn off blocking for test purposes
        try {
            while (count($this->channel->callbacks)) {
                $this->channel->wait(null, true, 1);
            }
        } catch (\Exception $ex) {
            echo 'Queue is empty.';
        }

        return true;
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->conn->close();
    }
}

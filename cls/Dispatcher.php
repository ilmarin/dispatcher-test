<?php
namespace cls;

class Dispatcher
{

    const GROUP_A = 'a_group';
    const GROUP_B = 'b_group';
    const GROUP_C = 'c_group';

    /**
     * Queue instance
     *
     * @var Queue
     */
    private $queue;

    /**
     * Db instance
     *
     * @var Db
     */
    private $db;

    public function __construct()
    {
        $this->queue = new Queue();
        $this->db = new Db();
    }

    /**
     * Users that logged in one or more times
     *
     * @return array
     */
    public function groupA()
    {
        $sql = 'SELECT
                    u.second_name,
                    u.first_name,
                    u.middle_name,
                    u.email
                FROM
                    users u,
                    login_source ls
                WHERE
                    ls.user_id = u.id
                GROUP BY u.id';

        return $this->db->query($sql);
    }

    /**
     * At least two signins for november
     *
     * @return array
     */
    public function groupB()
    {
        $sql = 'SELECT
                    u.second_name,
                    u.first_name,
                    u.middle_name,
                    u.email
                FROM
                    users u,
                    login_source ls
                WHERE
                    ls.user_id = u.id
                        AND ls.tms BETWEEN "2017-11-01 00:00:00" AND "2017-11-30 23:59:59"
                GROUP BY u.id
                HAVING COUNT(ls.id) > 2';

        return $this->db->query($sql);
    }

    /**
     * At least one signin in november and no
     * singins in period of first sale
     *
     * @return array
     */
    public function groupC()
    {
        $sql = 'SELECT
                    u.second_name,
                    u.first_name,
                    u.middle_name,
                    u.email,
                    a.title,
                    a.date_end
                FROM
                    users u,
                    login_source ls,
                    actions a,
                    user_actions ua
                WHERE
                    ls.user_id = u.id
                    and u.id = ua.user_id
                    and ua.action_id = a.id
                    and a.id = 2
                        AND ls.tms BETWEEN "2017-11-01 00:00:00" AND "2017-11-30 23:59:59"
                        AND u.id NOT IN(SELECT user_id FROM login_source WHERE tms BETWEEN "2017-08-28 00:00:00" AND "2017-09-05 23:59:59")
                GROUP BY u.id, a.id';

        return $this->db->query($sql);
    }

    /**
     * Return prepared data for sending to queue
     * Adds group identifier for message and glues elements into string
     *
     * @param array $rows
     * @param string $groupId
     * @return array Prepared data
     */
    public function getPreparedData(array $rows, $groupId)
    {
        $result = [];

        foreach ($rows as $row) {
            $values = array_values($row);
            array_unshift($values, $groupId);
            $result[] = implode(';', $values);
        }

        return $result;
    }

    /**
     * Sends prepared messages to queue
     *
     * @param array $messages
     * @return boolean
     */
    public function sendMessages(array $messages)
    {
        foreach ($messages as $message) {
            $this->queue->send($message);
        }

        return true;
    }
}

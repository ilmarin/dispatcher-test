<?php

use cls\Dispatcher;
use cls\Queue;

include 'etc/bootstrap.php';

$dispatcher = new Dispatcher();

$a = $dispatcher->groupA();
$dispatcher->sendMessages(
    $dispatcher->getPreparedData($a, Dispatcher::GROUP_A)
);

$b = $dispatcher->groupB();
$dispatcher->sendMessages(
    $dispatcher->getPreparedData($b, Dispatcher::GROUP_B)
);

$c = $dispatcher->groupC();
$dispatcher->sendMessages(
    $dispatcher->getPreparedData($c, Dispatcher::GROUP_C)
);

(new Queue)->run();







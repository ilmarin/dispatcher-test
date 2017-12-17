<?php
require_once __DIR__ . '/etc/bootstrap.php';

(new \cls\Queue())->run();
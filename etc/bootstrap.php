<?php

require_once 'config.php';

require_once __DIR__ . '/../vendor/autoload.php';

spl_autoload_register(function ($class_name) {
    require_once __DIR__ . '/../' . str_replace('\\', '/', $class_name) . '.php';
});
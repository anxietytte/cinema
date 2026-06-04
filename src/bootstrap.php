<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_DIR', dirname(__DIR__));

require_once ROOT_DIR . '/src/config/database.php';
require_once ROOT_DIR . '/src/helpers/helpers.php';
require_once ROOT_DIR . '/src/helpers/response.php';
require_once ROOT_DIR . '/src/helpers/auth.php';

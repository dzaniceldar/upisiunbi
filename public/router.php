<?php

/**
 * Router for PHP built-in server: serve static files from public/, else Laravel.
 * Run: php -d max_execution_time=0 -S 127.0.0.1:8000 -t public public/router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && $uri !== '' && is_file(__DIR__ . $uri)) {
    return false;
}

require_once __DIR__ . '/index.php';

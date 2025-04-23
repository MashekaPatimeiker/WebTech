<?php
declare(strict_types=1);

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Admin Area"');
    header('HTTP/1.0 401 Unauthorized');
    exit('Доступ запрещен');
}

$htpasswd_file = __DIR__ . '/../../config/.htpasswd';

if (!file_exists($htpasswd_file)) {
    header('HTTP/1.0 500 Internal Server Error');
    exit('Файл .htpasswd не найден.');
}

$valid = false;
$lines = file($htpasswd_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    if (strpos($line, ':') !== false) {
        list($user, $hash) = explode(':', $line, 2);

        if ($_SERVER['PHP_AUTH_USER'] === $user) {
            // Проверка bcrypt (password_hash) или crypt
            if (password_verify($_SERVER['PHP_AUTH_PW'], $hash) || hash_equals($hash, crypt($_SERVER['PHP_AUTH_PW'], $hash))) {
                $valid = true;
                break;
            }
        }
    }
}

if (!$valid) {
    header('HTTP/1.0 401 Unauthorized');
    exit('Неверные учетные данные');
}

require_once __DIR__ . '/filemanager/filemanager.php';

use FileManager\FileManager;

$manager = new FileManager();
$manager->handleRequest();


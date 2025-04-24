<?php
declare(strict_types=1);

namespace Controller;

use FileManager\FileManager;

class AdminController
{
    public function index(): void
    {
        $valid = false;

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="Admin Area"');
            header('HTTP/1.0 401 Unauthorized');
            exit('Доступ запрещен');
        }

        $htpasswd = __DIR__ . '/../../config/.htpasswd';
        error_log("Trying to auth with file: " . $htpasswd);
        error_log("User: " . $_SERVER['PHP_AUTH_USER']);
        error_log("Password length: " . strlen($_SERVER['PHP_AUTH_PW']));

        $lines = file($htpasswd, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                list($user, $hash) = explode(':', $line, 2);

                error_log("Stored hash: " . $hash);
                error_log("Input password: " . $_SERVER['PHP_AUTH_PW']);

                if ($_SERVER['PHP_AUTH_USER'] === $user &&
                    crypt($_SERVER['PHP_AUTH_PW'], $hash) === $hash) {
                    $valid = true;
                    break;
                }
            }
        }

        if (!$valid) {
            error_log("Authentication failed for user: " . $_SERVER['PHP_AUTH_USER']);
            header('HTTP/1.0 401 Unauthorized');
            exit('Неверные учетные данные');
        }

        require __DIR__ . '/../public/views/admin.php';
    }

    public function handleAction(): void
    {
        require_once __DIR__ . '/../public/admin/filemanager/filemanager.php';
        $manager = new FileManager();
        $manager->handleRequest();
    }
}

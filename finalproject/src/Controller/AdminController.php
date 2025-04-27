<?php
declare(strict_types=1);

namespace MyGameSite\Controller;

use FileManager\FileManager;
use RuntimeException;

class AdminController
{
    public function index(): void
    {
        try {
            // 1. Проверка аутентификации
            $this->validateAuthentication();

            // 2. Инициализация FileManager
            $manager = $this->initializeFileManager();
            $fileManagerOutput = $this->captureManagerOutput($manager);

            // 3. Отображение админ-панели
            $this->renderDashboard($fileManagerOutput);

        } catch (RuntimeException $e) {
            $this->handleError($e);
        }
    }

    private function validateAuthentication(): void
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            $this->sendAuthHeaders();
            exit('Доступ запрещен: требуется аутентификация');
        }

        if (!$this->checkCredentials()) {
            $this->sendAuthHeaders();
            exit('Неверные учетные данные');
        }
    }

    private function checkCredentials(): bool
    {
        $htpasswd = '/var/www/.htpasswd';

        if (!file_exists($htpasswd)) {
            error_log("Файл .htpasswd не найден: " . $htpasswd);
            return false;
        }

        $lines = file($htpasswd, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            error_log("Не удалось прочитать файл: " . $htpasswd);
            return false;
        }

        foreach ($lines as $line) {
            if (strpos($line, ':') === false) continue;

            [$user, $hash] = explode(':', $line, 2);

            if ($_SERVER['PHP_AUTH_USER'] === $user) {
                if (str_starts_with($hash, '$apr1$')) {
                    return $this->validateAPR1Hash($_SERVER['PHP_AUTH_PW'], $hash);
                }
                return password_verify($_SERVER['PHP_AUTH_PW'], $hash);
            }
        }

        return false;
    }

    private function initializeFileManager(): FileManager
    {
        $fileManagerPath = __DIR__ . '/../FileManager/FileManager.php';
        if (!file_exists($fileManagerPath)) {
            throw new RuntimeException("FileManager не найден: " . $fileManagerPath);
        }

        require_once $fileManagerPath;
        return new FileManager();
    }

    private function captureManagerOutput(FileManager $manager): string
    {
        ob_start();
        $manager->handleRequest();
        return ob_get_clean();
    }

    private function renderDashboard(string $fileManagerOutput): void
    {
        $dashboardPath = __DIR__ . '/../../public/views/admin/dashboard.php';

        if (!file_exists($dashboardPath)) {
            throw new RuntimeException("Файл dashboard не найден: " . $dashboardPath);
        }

        require $dashboardPath;
    }

    private function validateAPR1Hash(string $password, string $hash): bool
    {
        if (!str_starts_with($hash, '$apr1$')) return false;

        $salt = substr($hash, 6, 8);
        $generatedHash = $this->generateAPR1Hash($password, $salt);
        return hash_equals($hash, $generatedHash);
    }

    private function generateAPR1Hash(string $password, string $salt): string
    {
        $len = strlen($password);
        $text = $password . '$apr1$' . $salt;
        $bin = pack("H32", md5($password . $salt . $password));

        for ($i = $len; $i > 0; $i -= 16) {
            $text .= substr($bin, 0, min(16, $i));
        }
        for ($i = $len; $i > 0; $i >>= 1) {
            $text .= ($i & 1) ? chr(0) : $password[0];
        }

        $bin = pack("H32", md5($text));
        for ($i = 0; $i < 1000; $i++) {
            $new = ($i & 1) ? $password : $bin;
            $new .= ($i % 3) ? $salt : '';
            $new .= ($i % 7) ? $password : '';
            $bin = pack("H32", md5($new));
        }

        $tmp = '';
        for ($i = 0; $i < 5; $i++) {
            $k = $i + 6;
            $j = $i + 12;
            $tmp = $bin[$i] . $bin[$k] . $bin[$j] . $tmp;
        }

        $tmp = chr(0) . chr(0) . $bin[11] . $tmp;
        return '$apr1$' . $salt . '$' . strtr(
                strrev(substr(base64_encode($tmp), 2)),
                'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/',
                './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
            );
    }

    private function sendAuthHeaders(): void
    {
        header('WWW-Authenticate: Basic realm="Admin Area"');
        header('HTTP/1.0 401 Unauthorized');
    }

    private function handleError(RuntimeException $e): void
    {
        error_log("AdminController error: " . $e->getMessage());
        header('HTTP/1.0 500 Internal Server Error');
        exit('Ошибка сервера: ' . htmlspecialchars($e->getMessage()));
    }

    public function handleAction(): void
    {
        try {
            $manager = $this->initializeFileManager();
            $manager->handleRequest();
        } catch (RuntimeException $e) {
            $this->handleError($e);
        }
    }
}
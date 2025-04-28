<?php
declare(strict_types=1);
namespace MyGameSite\Services;

class BasicAuthenticator
{
    private string $htpasswdFile;

    public function __construct(string $htpasswdFile)
    {
        $this->htpasswdFile = $htpasswdFile;
    }

    public function authenticate(): bool
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            header('WWW-Authenticate: Basic realm="Admin Area"');
            header('HTTP/1.0 401 Unauthorized');
            return false;
        }

        $validUsers = $this->parseHtpasswd();
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        if (!isset($validUsers[$username])) {
            return false;
        }

        return password_verify($password, $validUsers[$username]);
    }

    private function parseHtpasswd(): array
    {
        $users = [];
        if (file_exists($this->htpasswdFile)) {
            $lines = file($this->htpasswdFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                list($user, $hash) = explode(':', $line, 2);
                $users[$user] = $hash;
            }
        }
        return $users;
    }
}
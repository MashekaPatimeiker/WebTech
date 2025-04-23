<?php
declare(strict_types=1);

namespace FileManager;

class FileManager
{
    private string $baseDir;
    private array $allowedDirs;

    public function __construct()
    {
        $this->baseDir = realpath(__DIR__ . '/../../') ?: '';
        $this->allowedDirs = [
            $this->baseDir . '/css',
            $this->baseDir . '/js',
            $this->baseDir . '/html',
            $this->baseDir . '/img',
            $this->baseDir . '/.'
        ];

        error_log("Allowed directories: " . print_r($this->allowedDirs, true));
    }

    public function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest();
            return;
        }

        $this->handleGetRequest();
    }

    private function handleGetRequest(): void
    {
        $requestedPath = $_GET['path'] ?? '';
        $fullPath = $this->resolveRequestedPath($requestedPath);

        if (!$this->isAllowed($fullPath)) {
            http_response_code(403);
            echo "Access denied.";
            exit;
        }

        if (isset($_GET['delete'])) {
            $this->handleDelete($fullPath, $requestedPath);
            return;
        }

        $this->displayDirectoryContents($fullPath, $requestedPath);
    }

    private function handlePostRequest(): void
    {
        $requestedPath = $_GET['path'] ?? '';
        $fullPath = $this->resolveRequestedPath($requestedPath);

        if (!$this->isAllowed($fullPath)) {
            http_response_code(403);
            echo "Access denied.";
            exit;
        }

        $this->handlePost($fullPath, $requestedPath);
    }

    private function handleDelete(string $fullPath, string $requestedPath): void
    {
        $deletePath = $fullPath . '/' . basename($_GET['delete']);

        if (!$this->isAllowed($deletePath)) {
            http_response_code(403);
            echo "Access denied.";
            exit;
        }

        if (is_file($deletePath)) {
            unlink($deletePath);
        } elseif (is_dir($deletePath)) {
            rmdir($deletePath);
        }

        header("Location: ?path=" . urlencode($requestedPath));
        exit;
    }

    private function displayDirectoryContents(string $fullPath, string $requestedPath): void
    {
        $editContent = null;
        $editName = null;

        if (isset($_GET['edit'])) {
            $editFile = $fullPath . '/' . basename($_GET['edit']);

            if (!$this->isAllowed($editFile)) {
                http_response_code(403);
                echo "Access denied.";
                exit;
            }

            if (is_file($editFile)) {
                $editContent = file_get_contents($editFile);
                $editName = $_GET['edit'];
            }
        }

        $items = $this->listDirectory($fullPath);
        require __DIR__ . '/view.php';
    }

    private function handlePost(string $fullPath, string $requestedPath): void
    {
        if (isset($_FILES['upload'])) {
            $target = $fullPath . '/' . basename($_FILES['upload']['name']);

            if (!$this->isAllowed($target)) {
                http_response_code(403);
                echo "Access denied.";
                exit;
            }

            move_uploaded_file($_FILES['upload']['tmp_name'], $target);
        }

        if (isset($_POST['filename'], $_POST['content'])) {
            $editFile = $fullPath . '/' . basename($_POST['filename']);

            if (!$this->isAllowed($editFile)) {
                http_response_code(403);
                echo "Access denied.";
                exit;
            }

            file_put_contents($editFile, $_POST['content']);
        }

        header("Location: ?path=" . urlencode($requestedPath));
        exit;
    }

    private function listDirectory(string $dir): array
    {
        return array_diff(scandir($dir), ['.', '..']);
    }

    private function resolveRequestedPath(string $requestedPath): ?string
    {
        $fullPath = realpath($this->baseDir . '/' . ltrim($requestedPath, '/'));

        if (!$fullPath || strpos($fullPath, $this->baseDir) !== 0) {
            error_log("Attempt to access invalid path: $requestedPath");
            return null;
        }

        return $fullPath;
    }

    private function isAllowed(?string $path): bool
    {
        if (!$path) {
            error_log("Path is empty or invalid");
            return false;
        }

        foreach ($this->allowedDirs as $allowed) {
            $allowed = realpath($allowed) ?: '';
            if ($allowed && strpos($path . '/', $allowed . '/') === 0) {
                return true;
            }
        }

        error_log("Path $path not allowed. Allowed dirs: " . implode(', ', $this->allowedDirs));
        return false;
    }
}

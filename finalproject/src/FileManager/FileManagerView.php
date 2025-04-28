<?php
declare(strict_types=1);
namespace FileManager;

class FileManagerView
{
    public static function render(array $data): void
    {
        extract($data);
        include __DIR__ . '/FileManagerTemplate.php';
    }
}
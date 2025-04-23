<?php
spl_autoload_register(function (string $class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';

    if ($class === 'FileManager\FileManager') {
        $file = __DIR__ . '/src/public/admin/filemanager/filemanager.php';
    }

    if (file_exists($file)) {
        require $file;
    } else {
        error_log("Autoload failed for {$class} at: {$file}");
    }
});
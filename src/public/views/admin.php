<?php
use FileManager\FileManager;

$manager = new FileManager();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Менеджер файлов</title>
    <link rel="stylesheet" href="/src/public/css/admin.css">
</head>
<body>
<div class="admin-container">
    <h1>Менеджер файлов</h1>
    <div class="file-manager">
        <?php $manager->handleRequest(); ?>
    </div>
</div>
<script src="/src/public/js/script.js"></script>
</body>
</html>
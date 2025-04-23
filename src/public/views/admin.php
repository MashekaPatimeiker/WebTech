<?php
use FileManager\FileManager;

$manager = new FileManager();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/src/public/admin/assets/admin.css">
</head>
<body>
<div class="admin-container">
    <h1>Административная панель</h1>
    <div class="file-manager">
        <?php $manager->handleRequest(); ?>
    </div>
</div>
<script src="/src/public/admin/assets/script.js"></script>
</body>
</html>
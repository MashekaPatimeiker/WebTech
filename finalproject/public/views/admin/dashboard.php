<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Менеджер файлов</title>
    <link rel="stylesheet" href="/finalproject/public/assets/css/admin.css">
</head>
<body>
<div class="admin-container">
    <h1>Менеджер файлов</h1>
    <div class="file-manager">
        <?php
        // Добавлена проверка существования переменной
        if (isset($fileManagerOutput)) {
            echo $fileManagerOutput;
        } else {
            echo '<div class="error">Ошибка: менеджер файлов не загружен</div>';
        }
        ?>
    </div>
</div>
<script src="/finalproject/public/assets/js/admin.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'GameZone - Лучшие игры', ENT_QUOTES, 'UTF-8') ?></title>

    <!-- Подключение шрифтов -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Основные стили -->
    <link rel="stylesheet" href="/finalproject/public/assets/css/games.css">

    <!-- Дополнительные стили для текущей страницы -->
    <?php if (isset($css)): ?>
        <link rel="stylesheet" href="/finalproject/public/assets/css/games.css<?= $css ?>.css">
    <?php endif; ?>

    <!-- Иконки -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" href="/finalproject/public/assets/images/favicon.ico" type="image/x-icon">
</head>
<body class="dark-theme">
<!-- Анимированный фон -->
<div class="particles-background"></div>

<!-- Главный контейнер -->
<div class="main-container">
    <!-- Хедер с навигацией -->
    <header class="game-header">
        <div class="logo">
            <i class="fas fa-gamepad"></i>
            <span>GameZone</span>
        </div>
        <div class="header-actions">
            <button id="themeToggle" class="icon-button">
                <i class="fas fa-moon"></i>
            </button>
            <button id="searchToggle" class="icon-button">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <!-- Поиск -->
        <div class="search-bar">
            <label>
                <input type="text" placeholder="Поиск игр...">
            </label>
            <button><i class="fas fa-search"></i></button>
        </div>
    </header>

    <!-- Основное содержимое -->
    <main class="content-wrapper">
        <?= $content ?? '' ?>
    </main>

    <!-- Футер -->
    <footer class="game-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>О нас</h3>
                <p>GameZone - лучший портал для настоящих геймеров с 2023 года</p>
            </div>

            <div class="footer-section">
                <h3>Соцсети</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-vk"></i></a>
                    <a href="#"><i class="fab fa-telegram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-discord"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Контакты</h3>
                <p>Email: info@gamezone.ru</p>
                <p>Телефон: +7 (123) 456-78-90</p>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; <?= date('Y') ?> GameZone. Все права защищены.</p>
        </div>
    </footer>
</div>

<!-- Кнопка "Наверх" -->
<button id="backToTop" class="back-to-top">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Подключение скриптов -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
<script src="/finalproject/public/assets/js/games.js"></script>

<?php if (isset($js)): ?>
    <script src="/finalproject/public/assets/js/<?= $js ?>.js"></script>
<?php endif; ?>
</body>
</html>
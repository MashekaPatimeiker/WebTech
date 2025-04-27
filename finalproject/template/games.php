<section class="games-list">
    <h2 class="games-list__title"><?= htmlspecialchars($title ?? 'Топ игр', ENT_QUOTES, 'UTF-8') ?></h2>
    <div class="games-container">
        <?php if (!empty($games)): ?>
            <?php foreach ($games as $game): ?>
                <article class="game-card">
                    <div class="game-card__image-container">
                        <img src="<?= htmlspecialchars($game['image'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($game['name'], ENT_QUOTES, 'UTF-8') ?>" class="game-card__image">
                    </div>
                    <h3 class="game-card__title"><?= htmlspecialchars($game['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p class="game-card__description"><?= htmlspecialchars($game['description'], ENT_QUOTES, 'UTF-8') ?></p>
                    <div class="game-card__meta">
                        <span class="game-card__rating"><?= htmlspecialchars($game['rating'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <button type="button"
                            class="game-card__details-btn"
                            data-game="<?= htmlspecialchars($game['name'], ENT_QUOTES, 'UTF-8') ?>"
                            aria-label="Подробнее об игре <?= htmlspecialchars($game['name'], ENT_QUOTES, 'UTF-8') ?>">
                        Подробнее
                    </button>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="games-list__empty">Игры не найдены</p>
        <?php endif; ?>
    </div>
</section>

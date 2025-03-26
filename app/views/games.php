<ul id="game-list">
    <?php if (!empty($games)): ?>
        <?php foreach ($games as $game): ?>
            <li><?php echo htmlspecialchars($game); ?></li>
        <?php endforeach; ?>
    <?php else: ?>
        <li>Список игр пуст.</li>
    <?php endif; ?>
</ul>

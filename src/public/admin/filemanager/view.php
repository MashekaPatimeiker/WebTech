<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менеджер файлов</title>
    <link rel="stylesheet" href="/src/public/css/admin.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<div id="file-manager-container">
    <header class="header">
        <h1>📁Менеджер файлов</h1>
        <p class="current-path"><?= htmlspecialchars($requestedPath ?? '/') ?></p>
    </header>

    <div class="table-wrapper">
        <table>
            <thead>
            <tr>
                <th>Имя</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($requestedPath) && $requestedPath !== '/'): ?>
                <tr>
                    <td>
                        <a class="folder btn" href="?path=<?= urlencode(dirname($requestedPath)) ?>">
                            <i data-lucide="folder-up"></i>
                            Назад
                        </a>
                    </td>
                    <td></td>
                </tr>
            <?php endif; ?>

            <?php
            // Initialize variables if they're not set
            $fullPath = $fullPath ?? '';
            $requestedPath = $requestedPath ?? '';
            $items = $items ?? [];

            foreach ($items as $item): ?>
                <?php $itemPath = $fullPath . '/' . $item; ?>
                <?php $relativePath = ($requestedPath ? $requestedPath . '/' : '') . $item; ?>
                <tr>
                    <td>
                        <?php if (is_dir($itemPath)): ?>
                            <a class="folder" href="?path=<?= urlencode($relativePath) ?>">
                                <i data-lucide="folder"></i>
                                <?= htmlspecialchars($item) ?>
                            </a>
                        <?php else: ?>
                            <a class="file" href="<?= htmlspecialchars($relativePath) ?>" target="_blank">
                                <i data-lucide="file-text"></i>
                                <?= htmlspecialchars($item) ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <a class="btn btn-danger"
                           href="?path=<?= urlencode($requestedPath) ?>&delete=<?= urlencode($item) ?>"
                           onclick="return confirm('Удалить <?= htmlspecialchars($item) ?>?')">
                            <i data-lucide="trash-2"></i>
                        </a>
                        <?php if (is_file($itemPath)): ?>
                            <a class="btn btn-edit"
                               href="?path=<?= urlencode($requestedPath) ?>&edit=<?= urlencode($item) ?>">
                                <i data-lucide="edit-3"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="upload-section">
        <h3><i data-lucide="upload-cloud"></i> Загрузить файл</h3>
        <form method="post" enctype="multipart/form-data" class="upload-form">
            <input type="hidden" name="path" value="<?= htmlspecialchars($requestedPath ?? '') ?>">
            <input type="file" name="upload" required class="file-input">
            <button type="submit" class="btn btn-upload">
                <i data-lucide="upload"></i> Загрузить
            </button>
        </form>
    </div>

    <?php if (isset($editContent) && isset($editName)): ?>
        <div class="editor-modal">
            <form method="post" class="editor-form">
                <input type="hidden" name="path" value="<?= htmlspecialchars($requestedPath ?? '') ?>">
                <h3>
                    <i data-lucide="file-edit"></i>
                    Редактирование: <?= htmlspecialchars($editName) ?>
                </h3>
                <input type="hidden" name="filename" value="<?= htmlspecialchars($editName) ?>">
                <label>
                    <textarea name="content" class="code-editor"><?= htmlspecialchars($editContent) ?></textarea>
                </label>
                <div class="form-actions">
                    <button type="submit" class="btn btn-save">
                        <i data-lucide="save"></i> Сохранить
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
    // Инициализация иконок после загрузки DOM
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
</body>
</html>
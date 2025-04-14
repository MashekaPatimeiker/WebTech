<?php
// Проверяем авторизацию (раскомментировать если нужно)
// if (!isset($_SESSION['admin_logged_in'])) {
//     header('Location: /admin/login');
//     exit;
// }

// Обработка текущего пути
$currentDir = $_GET['path'] ?? '';
$basePath = '/admin/files'; // Базовый путь для маршрутов
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a76a8;
            --danger-color: #e74c3c;
            --success-color: #2ecc71;
            --text-color: #333;
            --bg-color: #f9f9f9;
            --border-color: #ddd;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--bg-color);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: var(--primary-color);
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .path-navigation {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 4px;
        }

        .path-navigation a {
            color: var(--primary-color);
            text-decoration: none;
            padding: 5px 8px;
            border-radius: 3px;
            transition: background 0.2s;
        }

        .path-navigation a:hover {
            background: rgba(74, 118, 168, 0.1);
        }

        .current-path {
            font-family: monospace;
            padding: 5px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 3px;
        }

        .actions-panel {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .upload-form, .create-dir-form {
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
        }

        .upload-form h3, .create-dir-form h3 {
            margin-top: 0;
            color: var(--primary-color);
        }

        input[type="file"], input[type="text"] {
            padding: 8px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            width: 100%;
            margin-bottom: 10px;
        }

        .btn-danger {
            background-color: var(--danger-color);
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-success {
            background-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .file-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .file-table th, .file-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .file-table th {
            background-color: #f2f2f2;
            font-weight: 600;
        }

        .file-table tr:hover {
            background-color: #f9f9f9;
        }

        .file-icon {
            margin-right: 8px;
            color: #666;
            width: 20px;
            text-align: center;
        }

        .file-name {
            display: flex;
            align-items: center;
        }

        .file-actions {
            display: flex;
            gap: 10px;
        }

        footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            text-align: center;
            color: #777;
            font-size: 0.9em;
        }

        @media (max-width: 768px) {
            .actions-panel {
                flex-direction: column;
            }

            .file-actions {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1><i class="fas fa-folder-open"></i> File Manager</h1>

    <!-- Навигация по пути -->
    <div class="path-navigation">
        <a href="<?= $basePath ?>" title="Root directory"><i class="fas fa-home"></i></a>
        <i class="fas fa-chevron-right"></i>

        <?php
        // Генерация хлебных крошек
        $pathParts = explode('/', trim($currentDir, '/'));
        $accumulatedPath = '';

        foreach ($pathParts as $index => $part) {
            $accumulatedPath .= '/' . $part;
            $isLast = ($index === count($pathParts) - 1);

            if ($isLast) {
                echo '<span class="current-path">' . htmlspecialchars($part) . '</span>';
            } else {
                echo '<a href="' . $basePath . '?path=' . urlencode(trim($accumulatedPath, '/')) . '">'
                    . htmlspecialchars($part) . '</a><i class="fas fa-chevron-right"></i>';
            }
        }
        ?>
    </div>

    <!-- Панель действий -->
    <div class="actions-panel">
        <div class="upload-form">
            <h3><i class="fas fa-upload"></i> Upload File</h3>
            <form method="post" action="<?= $basePath ?>/upload?path=<?= urlencode($currentDir) ?>" enctype="multipart/form-data">
                <input type="file" name="file" required>
                <button type="submit" class="btn-success"><i class="fas fa-upload"></i> Upload</button>
            </form>
        </div>

        <div class="create-dir-form">
            <h3><i class="fas fa-folder-plus"></i> Create Directory</h3>
            <form method="post" action="<?= $basePath ?>/directory?path=<?= urlencode($currentDir) ?>">
                <label>
                    <input type="text" name="directory" placeholder="Directory name" required>
                </label>
                <button type="submit" class="btn-success"><i class="fas fa-plus"></i> Create</button>
            </form>
        </div>
    </div>

    <!-- Таблица файлов -->
    <table class="file-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Size</th>
            <th>Modified</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // В реальном приложении здесь будет код для получения списка файлов
        // Это примерная реализация
        $files = [
            [
                'name' => 'Documents',
                'isDir' => true,
                'size' => '-',
                'modified' => '2023-05-15 14:30',
                'path' => $currentDir ? $currentDir . '/Documents' : 'Documents'
            ],
            [
                'name' => 'image.jpg',
                'isDir' => false,
                'size' => '2.4 MB',
                'modified' => '2023-05-10 09:15',
                'path' => $currentDir ? $currentDir . '/image.jpg' : 'image.jpg'
            ],
            [
                'name' => 'report.pdf',
                'isDir' => false,
                'size' => '1.1 MB',
                'modified' => '2023-05-12 16:45',
                'path' => $currentDir ? $currentDir . '/report.pdf' : 'report.pdf'
            ]
        ];

        foreach ($files as $file) {
            echo '<tr>';

            // Имя файла/папки
            echo '<td class="file-name">';
            echo '<span class="file-icon">';
            echo $file['isDir'] ? '<i class="fas fa-folder"></i>' : '<i class="fas fa-file"></i>';
            echo '</span>';

            if ($file['isDir']) {
                echo '<a href="' . $basePath . '?path=' . urlencode($file['path']) . '">';
                echo htmlspecialchars($file['name']);
                echo '</a>';
            } else {
                echo '<a href="' . $basePath . '/view?file=' . urlencode($file['path']) . '">';
                echo htmlspecialchars($file['name']);
                echo '</a>';
            }
            echo '</td>';

            // Тип
            echo '<td>' . ($file['isDir'] ? 'Directory' : 'File') . '</td>';

            // Размер
            echo '<td>' . htmlspecialchars($file['size']) . '</td>';

            // Дата изменения
            echo '<td>' . htmlspecialchars($file['modified']) . '</td>';

            // Действия
            echo '<td class="file-actions">';
            if (!$file['isDir']) {
                echo '<a href="' . $basePath . '/download?file=' . urlencode($file['path']) . '" class="btn" title="Download">';
                echo '<i class="fas fa-download"></i>';
                echo '</a>';
            }

            echo '<form method="post" action="' . $basePath . '/delete" style="display:inline;">';
            echo '<input type="hidden" name="file" value="' . htmlspecialchars($file['path']) . '">';
            echo '<button type="submit" class="btn-danger" title="Delete" onclick="return confirm(\'Are you sure?\')">';
            echo '<i class="fas fa-trash-alt"></i>';
            echo '</button>';
            echo '</form>';
            echo '</td>';

            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<footer>
    <div class="developer-info">
        <p>File Manager &copy; 2023 | Developer: Your Name</p>
    </div>
</footer>
</body>
</html>
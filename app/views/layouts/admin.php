<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Panel' ?></title>
</head>
<body>
    <div style="display: flex; min-height: 100vh;">
        <!-- Sidebar -->
        <aside style="width: 250px; background: #f5f5f5; padding: 20px; border-right: 1px solid #ddd;">
            <h2>Panel Admin</h2>
            <nav>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 10px;">
                        <a href="/app/views/platform/list.php">📋 Plataformas</a>
                    </li>
                    <li style="margin-bottom: 10px;">
                        <a href="/app/views/actor/list.php">🎭 Actores</a>
                    </li>
                    <li style="margin-bottom: 10px;">
                        <a href="/app/views/director/list.php">🎬 Directores</a>
                    </li>
                    <li style="margin-bottom: 10px;">
                        <a href="/app/views/idioma/list.php">🌐 Idiomas</a>
                    </li>
                    <li style="margin-bottom: 10px;">
                        <a href="/app/views/serie/list.php">📺 Series</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main style="flex: 1; padding: 20px;">
            <?= $content ?>
        </main>
    </div>
</body>
</html>

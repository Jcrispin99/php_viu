<?php
$pageTitle = 'Inicio';
ob_start();
?>
<h1>Bienvenido al Panel de Administración</h1>
<p>Seleccione una opción del menú lateral para gestionar los datos.</p>

<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
    <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; width: 200px;">
        <h3>📋 Plataformas</h3>
        <p>Gestionar plataformas de streaming.</p>
        <a href="/app/views/platform/list.php">Ir a Plataformas</a>
    </div>
    <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; width: 200px;">
        <h3>🎭 Actores</h3>
        <p>Gestionar registro de actores.</p>
        <a href="/app/views/actor/list.php">Ir a Actores</a>
    </div>
    <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; width: 200px;">
        <h3>🎬 Directores</h3>
        <p>Gestionar registro de directores.</p>
        <a href="/app/views/director/list.php">Ir a Directores</a>
    </div>
    <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; width: 200px;">
        <h3>🌐 Idiomas</h3>
        <p>Gestionar idiomas disponibles.</p>
        <a href="/app/views/idioma/list.php">Ir a Idiomas</a>
    </div>
    <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; width: 200px;">
        <h3>📺 Series</h3>
        <p>Gestionar catálogo de series.</p>
        <a href="/app/views/serie/list.php">Ir a Series</a>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/app/views/layouts/admin.php';

<?php
require_once __DIR__ . "/../../controllers/PlatformController.php";

$controller = new PlatformController();
$platforms = $controller->listPlatforms();
$pageTitle = 'Plataformas - Listado';

// Capturar contenido
ob_start();
?>
<h1>Listado de plataformas</h1>

<p><a href="create.php">➕ Crear nueva plataforma</a></p>

<?php if (count($platforms) === 0): ?>
    <p>No existe todavía ninguna plataforma.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($platforms as $p): ?>
            <tr>
                <td><?= htmlspecialchars((string)$p->getId()) ?></td>
                <td><?= htmlspecialchars($p->getName()) ?></td>
                <td>
                    <a href="edit.php?id=<?= urlencode((string)$p->getId()) ?>">✏️ Editar</a>
                    
                    <form action="delete.php" method="post" style="display:inline; margin-left: 10px;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string)$p->getId()) ?>">
                        <button type="submit" onclick="return confirm('¿Seguro que deseas borrar esta plataforma?')">
                            🗑️ Borrar
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
<?php
require_once __DIR__ . "/../../controllers/IdiomaController.php";

$controller = new IdiomaController();
$idiomas = $controller->listIdiomas();
$pageTitle = 'Idiomas - Listado';

// Capturar contenido
ob_start();
?>
<h1>Listado de Idiomas</h1>

<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'deleted'): ?>
        <div class="alert alert-success">✅ Idioma eliminado correctamente.</div>
    <?php elseif ($_GET['status'] === 'error'): ?>
        <div class="alert alert-danger">❌ Error al eliminar el idioma.</div>
    <?php endif; ?>
<?php endif; ?>

<p><a href="create.php">➕ Crear nuevo idioma</a></p>

<?php if (count($idiomas) === 0): ?>
    <p>No hay idiomas registrados.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th>ID</th>
                <th>Nombre</th>
                <th>Código ISO</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($idiomas as $i): ?>
            <tr>
                <td><?= htmlspecialchars((string)$i->getId()) ?></td>
                <td><?= htmlspecialchars($i->getNombre()) ?></td>
                <td><code><?= htmlspecialchars($i->getIsoCode()) ?></code></td>
                <td>
                    <a href="edit.php?id=<?= urlencode((string)$i->getId()) ?>">✏️ Editar</a>
                    <a href="delete.php?id=<?= urlencode((string)$i->getId()) ?>" style="margin-left: 10px; color: #dc3545;">🗑️ Borrar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';

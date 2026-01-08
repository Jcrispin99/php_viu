<?php
require_once __DIR__ . "/../../controllers/SerieController.php";

$controller = new SerieController();
$series = $controller->listSeries();
$pageTitle = 'Series - Listado';

// Capturar contenido
ob_start();
?>
<h1>Listado de Series</h1>

<p><a href="create.php">➕ Crear nueva serie</a></p>

<?php if (count($series) === 0): ?>
    <p>No hay series registradas.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th>ID</th>
                <th>Título</th>
                <th>Plataforma ID</th>
                <th>Director ID</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($series as $s): ?>
            <tr>
                <td><?= htmlspecialchars((string)$s->getId()) ?></td>
                <td><?= htmlspecialchars($s->getTitulo()) ?></td>
                <td><?= htmlspecialchars((string)$s->getPlataformaId()) ?></td>
                <td><?= htmlspecialchars((string)$s->getDirectorId()) ?></td>
                <td>
                    <a href="edit.php?id=<?= urlencode((string)$s->getId()) ?>">✏️ Editar</a>
                    
                    <form action="delete.php" method="post" style="display:inline; margin-left: 10px;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string)$s->getId()) ?>">
                        <button type="submit" onclick="return confirm('¿Seguro que deseas borrar esta serie?')">
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

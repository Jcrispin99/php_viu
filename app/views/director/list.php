<?php
require_once __DIR__ . "/../../controllers/DirectorController.php";

$controller = new DirectorController();
$directores = $controller->listDirectores();
$pageTitle = 'Directores - Listado';

// Capturar contenido
ob_start();
?>
<h1>Listado de Directores</h1>

<p><a href="create.php">➕ Crear nuevo director</a></p>

<?php if (count($directores) === 0): ?>
    <p>No hay directores registrados.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f0f0f0;">
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Fecha Nacimiento</th>
                <th>Nacionalidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($directores as $a): ?>
            <tr>
                <td><?= htmlspecialchars((string)$a->getId()) ?></td>
                <td><?= htmlspecialchars($a->getNombre()) ?></td>
                <td><?= htmlspecialchars($a->getApellidos()) ?></td>
                <td><?= htmlspecialchars($a->getFechaNacimiento()) ?></td>
                <td><?= htmlspecialchars($a->getNacionalidad()) ?></td>
                <td>
                    <a href="edit.php?id=<?= urlencode((string)$a->getId()) ?>">✏️ Editar</a>
                    
                    <form action="delete.php" method="post" style="display:inline; margin-left: 10px;">
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string)$a->getId()) ?>">
                        <button type="submit" onclick="return confirm('¿Seguro que deseas borrar este director?')">
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

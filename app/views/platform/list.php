<?php
require_once __DIR__ . "/../../controllers/PlatformController.php";
$controller = new PlatformController();
$platforms = $controller->listPlatforms();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Plataformas - Listado</title></head>
<body>
  <h1>Listado de plataformas</h1>

  <p><a href="create.php">Crear nueva plataforma</a></p>

  <?php if (count($platforms) === 0): ?>
    <p>No existe todavía ninguna plataforma.</p>
  <?php else: ?>
    <table border="1" cellpadding="6">
      <thead>
        <tr>
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
            <!-- Editar por GET -->
            <a href="edit.php?id=<?= urlencode((string)$p->getId()) ?>">Editar</a>

            <!-- Borrar por POST -->
            <form action="delete.php" method="post" style="display:inline">
              <input type="hidden" name="id" value="<?= htmlspecialchars((string)$p->getId()) ?>">
              <button type="submit" onclick="return confirm('¿Seguro que deseas borrar esta plataforma?')">
                Borrar
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>
</html>
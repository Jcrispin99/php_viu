<?php
require_once __DIR__ . "/../../controllers/PlatformController.php";
$controller = new PlatformController();

$message = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["platformName"])) {
    $ok = $controller->createPlatform($_POST["platformName"]);
    $message = $ok ? "OK: Plataforma creada correctamente." : "ERROR: No se pudo crear (nombre inválido o fallo BBDD).";
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Crear plataforma</title></head>
<body>
  <h1>Crear plataforma</h1>

  <?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>

  <form action="" method="post">
    <label>Nombre:</label>
    <input type="text" name="platformName" required minlength="2">
    <button type="submit">Crear</button>
  </form>

  <p><a href="list.php">Volver al listado</a></p>
</body>
</html>
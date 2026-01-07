<?php
require_once __DIR__ . "/../../controllers/PlatformController.php";
$controller = new PlatformController();

$message = null;

// 1) Cargar plataforma (por GET)
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
$platform = $controller->getPlatform($id);

if (!$platform) {
    die("Plataforma no encontrada.");
}

// 2) Procesar update (por POST)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["platformId"], $_POST["platformName"])) {
    $pid = (int)$_POST["platformId"];
    $ok = $controller->updatePlatform($pid, $_POST["platformName"]);
    $message = $ok ? "OK: Plataforma modificada correctamente." : "ERROR: No se pudo modificar.";
    // refrescar nombre en pantalla
    $platform = $controller->getPlatform($pid);
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Editar plataforma</title></head>
<body>
  <h1>Editar plataforma</h1>

  <?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>

  <form action="" method="post">
    <input type="hidden" name="platformId" value="<?= htmlspecialchars((string)$platform->getId()) ?>">
    <label>Nombre:</label>
    <input type="text" name="platformName" required minlength="2"
           value="<?= htmlspecialchars($platform->getName()) ?>">
    <button type="submit">Guardar</button>
  </form>

  <p><a href="list.php">Volver al listado</a></p>
</body>
</html>
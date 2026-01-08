<?php
require_once __DIR__ . "/../../controllers/PlatformController.php";
$controller = new PlatformController();

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["id"])) {
    die("Acceso inválido.");
}

$id = (int)$_POST["id"];
$ok = $controller->deletePlatform($id);

?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Borrar plataforma</title></head>
<body>
  <h1>Borrado</h1>
  <p><?= $ok ? "OK: Plataforma borrada correctamente." : "ERROR: No se pudo borrar (no existe o relación con otras tablas)." ?></p>
  <p><a href="list.php">Volver al listado</a></p>
</body>
</html>

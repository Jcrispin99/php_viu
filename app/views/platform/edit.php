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

$pageTitle = 'Editar Plataforma';

// Capturar contenido
ob_start();
?>
<h1>Editar plataforma</h1>

<?php if ($message): ?>
    <p style="padding: 10px; background: <?= strpos($message, 'ERROR') !== false ? '#ffcccc' : '#ccffcc' ?>; border: 1px solid <?= strpos($message, 'ERROR') !== false ? '#cc0000' : '#00cc00' ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form action="" method="post">
    <input type="hidden" name="platformId" value="<?= htmlspecialchars((string)$platform->getId()) ?>">
    
    <div style="margin-bottom: 15px;">
        <label for="platformName">Nombre:</label><br>
        <input type="text" id="platformName" name="platformName" required minlength="2" 
               value="<?= htmlspecialchars($platform->getName()) ?>" 
               style="width: 300px; padding: 5px;">
    </div>
    
    <button type="submit" style="padding: 8px 15px;">💾 Guardar</button>
    <a href="list.php" style="margin-left: 10px;">❌ Cancelar</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
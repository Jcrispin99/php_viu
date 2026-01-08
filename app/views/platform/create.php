<?php
require_once __DIR__ . "/../../controllers/PlatformController.php";

$controller = new PlatformController();
$message = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["platformName"])) {
    $ok = $controller->createPlatform($_POST["platformName"]);
    $message = $ok ? "OK: Plataforma creada correctamente." : "ERROR: No se pudo crear (nombre inválido o fallo BBDD).";
}

$pageTitle = 'Crear Plataforma';

// Capturar contenido
ob_start();
?>
<h1>Crear plataforma</h1>

<?php if ($message): ?>
    <p style="padding: 10px; background: <?= strpos($message, 'ERROR') !== false ? '#ffcccc' : '#ccffcc' ?>; border: 1px solid <?= strpos($message, 'ERROR') !== false ? '#cc0000' : '#00cc00' ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form action="" method="post">
    <div style="margin-bottom: 15px;">
        <label for="platformName">Nombre:</label><br>
        <input type="text" id="platformName" name="platformName" required minlength="2" style="width: 300px; padding: 5px;">
    </div>
    <button type="submit" style="padding: 8px 15px;">✅ Crear</button>
    <a href="list.php" style="margin-left: 10px;">❌ Cancelar</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
<?php
require_once __DIR__ . "/../../controllers/IdiomaController.php";

$controller = new IdiomaController();
$message = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nombre"], $_POST["isoCode"])) {
    $ok = $controller->createIdioma($_POST["nombre"], $_POST["isoCode"]);
    $message = $ok ? "OK: Idioma creado correctamente." : "ERROR: No se pudo crear (código ISO ya existe o datos inválidos).";
}

$pageTitle = 'Crear Idioma';

// Capturar contenido
ob_start();
?>
<h1>Crear Idioma</h1>

<?php if ($message): ?>
    <p style="padding: 10px; background: <?= strpos($message, 'ERROR') !== false ? '#ffcccc' : '#ccffcc' ?>; border: 1px solid <?= strpos($message, 'ERROR') !== false ? '#cc0000' : '#00cc00' ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form action="" method="post">
    <div style="margin-bottom: 15px;">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required minlength="2" style="width: 300px; padding: 5px;" placeholder="Ej: Español">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="isoCode">Código ISO:</label><br>
        <input type="text" id="isoCode" name="isoCode" required minlength="2" maxlength="10" style="width: 300px; padding: 5px;" placeholder="Ej: es, en, fr">
        <br><small>Código único del idioma (2-10 caracteres)</small>
    </div>
    
    <button type="submit" style="padding: 8px 15px;">✅ Crear</button>
    <a href="list.php" style="margin-left: 10px;">❌ Cancelar</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';

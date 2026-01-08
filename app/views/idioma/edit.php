<?php
require_once __DIR__ . "/../../controllers/IdiomaController.php";

$controller = new IdiomaController();
$message = null;

// 1) Cargar idioma (por GET)
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
$idioma = $controller->getIdioma($id);

if (!$idioma) {
    die("Idioma no encontrado.");
}

// 2) Procesar update (por POST)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["nombre"], $_POST["isoCode"])) {
    $idiomaId = (int)$_POST["id"];
    $ok = $controller->updateIdioma($idiomaId, $_POST["nombre"], $_POST["isoCode"]);
    $message = $ok ? "OK: Idioma modificado correctamente." : "ERROR: No se pudo modificar (código ISO ya existe).";
    // refrescar datos en pantalla
    $idioma = $controller->getIdioma($idiomaId);
}

$pageTitle = 'Editar Idioma';

// Capturar contenido
ob_start();
?>
<h1>Editar Idioma</h1>

<?php if ($message): ?>
    <p style="padding: 10px; background: <?= strpos($message, 'ERROR') !== false ? '#ffcccc' : '#ccffcc' ?>; border: 1px solid <?= strpos($message, 'ERROR') !== false ? '#cc0000' : '#00cc00' ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form action="" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$idioma->getId()) ?>">
    
    <div style="margin-bottom: 15px;">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required minlength="2" 
               value="<?= htmlspecialchars($idioma->getNombre()) ?>" 
               style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="isoCode">Código ISO:</label><br>
        <input type="text" id="isoCode" name="isoCode" required minlength="2" maxlength="10" 
               value="<?= htmlspecialchars($idioma->getIsoCode()) ?>" 
               style="width: 300px; padding: 5px;">
        <br><small>Código único del idioma (2-10 caracteres)</small>
    </div>
    
    <button type="submit" style="padding: 8px 15px;">💾 Guardar</button>
    <a href="list.php" style="margin-left: 10px;">❌ Cancelar</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';

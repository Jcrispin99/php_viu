<?php
require_once __DIR__ . "/../../controllers/SerieController.php";
require_once __DIR__ . "/../../models/Platform.php";
require_once __DIR__ . "/../../models/Director.php";

$controller = new SerieController();
$message = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["titulo"], $_POST["plataformaId"], $_POST["directorId"])) {
    $ok = $controller->createSerie($_POST["titulo"], (int)$_POST["plataformaId"], (int)$_POST["directorId"]);
    $message = $ok ? "OK: Serie creada correctamente." : "ERROR: No se pudo crear (datos inválidos o plataforma/director no existe).";
}

// Cargar listas para los selects
$plataformas = Platform::getAll();
$directores = Director::getAll();

$pageTitle = 'Crear Serie';

// Capturar contenido
ob_start();
?>
<h1>Crear Serie</h1>

<?php if ($message): ?>
    <p style="padding: 10px; background: <?= strpos($message, 'ERROR') !== false ? '#ffcccc' : '#ccffcc' ?>; border: 1px solid <?= strpos($message, 'ERROR') !== false ? '#cc0000' : '#00cc00' ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form action="" method="post">
    <div style="margin-bottom: 15px;">
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required minlength="2" style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="plataformaId">Plataforma:</label><br>
        <select id="plataformaId" name="plataformaId" required style="width: 312px; padding: 5px;">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($plataformas as $p): ?>
                <option value="<?= $p->getId() ?>"><?= htmlspecialchars($p->getName()) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="directorId">Director:</label><br>
        <select id="directorId" name="directorId" required style="width: 312px; padding: 5px;">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($directores as $d): ?>
                <option value="<?= $d->getId() ?>"><?= htmlspecialchars($d->getNombre() . ' ' . $d->getApellidos()) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" style="padding: 8px 15px;">✅ Crear</button>
    <a href="list.php" style="margin-left: 10px;">❌ Cancelar</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';

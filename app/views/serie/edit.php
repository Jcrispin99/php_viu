<?php
require_once __DIR__ . "/../../controllers/SerieController.php";
require_once __DIR__ . "/../../models/Platform.php";
require_once __DIR__ . "/../../models/Director.php";

$controller = new SerieController();
$message = null;

// 1) Cargar serie (por GET)
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
$serie = $controller->getSerie($id);

if (!$serie) {
    die("Serie no encontrada.");
}

// 2) Procesar update (por POST)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["titulo"], $_POST["plataformaId"], $_POST["directorId"])) {
    $serieId = (int)$_POST["id"];
    $ok = $controller->updateSerie($serieId, $_POST["titulo"], (int)$_POST["plataformaId"], (int)$_POST["directorId"]);
    $message = $ok ? "OK: Serie modificada correctamente." : "ERROR: No se pudo modificar.";
    // refrescar datos en pantalla
    $serie = $controller->getSerie($serieId);
}

// Cargar listas para los selects
$plataformas = Platform::getAll();
$directores = Director::getAll();

$pageTitle = 'Editar Serie';

// Capturar contenido
ob_start();
?>
<h1>Editar Serie</h1>

<?php if ($message): ?>
    <p style="padding: 10px; background: <?= strpos($message, 'ERROR') !== false ? '#ffcccc' : '#ccffcc' ?>; border: 1px solid <?= strpos($message, 'ERROR') !== false ? '#cc0000' : '#00cc00' ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form action="" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$serie->getId()) ?>">
    
    <div style="margin-bottom: 15px;">
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required minlength="2" 
               value="<?= htmlspecialchars($serie->getTitulo()) ?>" 
               style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="plataformaId">Plataforma:</label><br>
        <select id="plataformaId" name="plataformaId" required style="width: 312px; padding: 5px;">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($plataformas as $p): ?>
                <option value="<?= $p->getId() ?>" <?= $p->getId() == $serie->getPlataformaId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p->getName()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="directorId">Director:</label><br>
        <select id="directorId" name="directorId" required style="width: 312px; padding: 5px;">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($directores as $d): ?>
                <option value="<?= $d->getId() ?>" <?= $d->getId() == $serie->getDirectorId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d->getNombre() . ' ' . $d->getApellidos()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" style="padding: 8px 15px;">💾 Guardar</button>
    <a href="list.php" style="margin-left: 10px;">❌ Cancelar</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';

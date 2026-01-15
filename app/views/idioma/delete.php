<?php
require_once __DIR__ . "/../../controllers/IdiomaController.php";
$controller = new IdiomaController();

// Validar que venga el ID
if (!isset($_REQUEST["id"])) {
    header("Location: list.php");
    exit;
}

$id = (int)$_REQUEST["id"];
$idioma = $controller->getIdioma($id);

if (!$idioma) {
    die("Idioma no encontrado.");
}

// Si viene confirmación por POST, ejecutar eliminación
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirmed"])) {
    $ok = $controller->deleteIdioma($id);
    $status = $ok ? "deleted" : "error";
    header("Location: list.php?status=" . $status);
    exit;
}

// Si no hay confirmación, mostrar página de confirmación
$relatedInfo = $controller->getRelatedSeriesInfo($id);
$seriesCount = $relatedInfo['count'];
$seriesList = $relatedInfo['series'];

$nombreIdioma = htmlspecialchars($idioma->getNombre() . ' (' . $idioma->getIsoCode() . ')');
$pageTitle = "Confirmar eliminación - " . $nombreIdioma;
ob_start();
?>

<div class="container mt-4">
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Confirmar eliminación
            </h4>
        </div>
        <div class="card-body">
            <h5>¿Estás seguro de eliminar el idioma <strong>"<?= $nombreIdioma ?>"</strong>?</h5>
            
            <?php if ($seriesCount > 0): ?>
                <div class="alert alert-warning mt-3">
                    <h6><i class="bi bi-exclamation-circle me-2"></i>¡Atención!</h6>
                    <p class="mb-2">
                        Este idioma se usa en <strong><?= $seriesCount ?></strong> serie(s). Se eliminará de:
                    </p>
                    <ul class="mb-0">
                        <?php foreach ($seriesList as $serie): ?>
                            <li>
                                <?= htmlspecialchars($serie['titulo']) ?>
                                <small class="text-muted">
                                    (<?php
                                        $usos = [];
                                        if (!empty($serie['en_audio'])) $usos[] = 'Audio';
                                        if (!empty($serie['en_subtitulos'])) $usos[] = 'Subtítulos';
                                        echo implode(', ', $usos);
                                    ?>)
                                </small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle me-2"></i>
                    Este idioma no está asociado a ninguna serie.
                </div>
            <?php endif; ?>

            <form method="POST" class="mt-4">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="confirmed" value="1">
                
                <div class="d-flex gap-2">
                    <a href="list.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> 
                        Sí, eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . "/../layouts/admin.php";
?>

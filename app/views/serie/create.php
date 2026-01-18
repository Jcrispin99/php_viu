<?php
require_once __DIR__ . "/../../controllers/SerieController.php";
require_once __DIR__ . "/../../models/Platform.php";
require_once __DIR__ . "/../../models/Director.php";

$controller = new SerieController();
$message = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["titulo"], $_POST["plataformaId"], $_POST["directorId"])) {
    $newId = $controller->createSerie($_POST["titulo"], (int)$_POST["plataformaId"], (int)$_POST["directorId"]);
    if ($newId > 0) {
        // Redirigir a editar para añadir actores e idiomas
        header("Location: edit.php?id=" . $newId);
        exit;
    } else {
        $message = "ERROR: No se pudo crear (datos inválidos o plataforma/director no existe).";
    }
}

// Cargar listas para los selects
$plataformas = Platform::getAll();
$directores = Director::getAll();

$pageTitle = 'Crear Serie';

// Capturar contenido
ob_start();
?>
<h1>Crear Serie</h1>

<p><a href="list.php">⬅ Volver al listado</a></p>

<?php if ($message): ?>
    <p style="padding: 10px; background: #ffcccc; border: 1px solid #cc0000;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<div style="display: flex; gap: 40px; flex-wrap: wrap;">

    <!-- Columna Izq: Datos Principales -->
    <div style="flex: 1; min-width: 300px;">
        <h3>Datos Principales</h3>
        <form action="" method="post" style="background: #f9f9f9; padding: 20px; border-radius: 8px;">

            <div style="margin-bottom: 15px;">
                <label for="titulo">Título:</label><br>
                <input type="text" id="titulo" name="titulo" required minlength="2"
                    style="width: 100%; padding: 5px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="plataformaId">Plataforma:</label><br>
                <select id="plataformaId" name="plataformaId" required style="width: 100%; padding: 5px;">
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($plataformas as $p): ?>
                        <option value="<?= $p->getId() ?>">
                            <?= htmlspecialchars($p->getName()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="directorId">Director:</label><br>
                <select id="directorId" name="directorId" required style="width: 100%; padding: 5px;">
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($directores as $d): ?>
                        <option value="<?= $d->getId() ?>">
                            <?= htmlspecialchars($d->getNombre() . ' ' . $d->getApellidos()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" style="padding: 8px 15px; width: 100%;">✅ Crear Serie</button>
        </form>
    </div>

    <!-- Columna Der: Relaciones (Placeholder) -->
    <div style="flex: 1; min-width: 300px; opacity: 0.6;">

        <!-- ACTORES -->
        <div style="margin-bottom: 30px;">
            <h3>🎭 Actores</h3>
            <div style="border: 1px solid #ddd; padding: 20px; border-radius: 5px; background: #eee; text-align: center;">
                <p>Guarda la serie primero para añadir actores.</p>
            </div>
        </div>

        <!-- IDIOMAS -->
        <div>
            <h3>🌐 Idiomas (Audio)</h3>
            <div style="border: 1px solid #ddd; padding: 20px; border-radius: 5px; background: #eee; text-align: center;">
                <p>Guarda la serie primero para añadir idiomas.</p>
            </div>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';

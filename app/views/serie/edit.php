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
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $serieId = (int)$_POST["id"];

    // 3) Procesar acciones de relaciones (POST)
    $tipo = $_POST["tipo"] ?? null;

    if ($tipo === "remove_actor") {
        $actorId = (int)$_POST["actor_id"];
        $controller->removerActorDeSerie($serieId, $actorId);
        $message = "Actor eliminado correctamente.";
    } elseif ($tipo === "add_actor") {
        $actorId = (int)$_POST["actor_id"];
        if ($actorId > 0) {
            $controller->agregarActorASerie($serieId, $actorId);
            $message = "Actor agregado correctamente.";
        }
    } elseif ($tipo === "remove_idioma") {
        $idiomaId = (int)$_POST["idioma_id"];
        $controller->removerIdiomaAudioDeSerie($serieId, $idiomaId);
        $message = "Idioma eliminado correctamente.";
    } elseif ($tipo === "add_idioma") {
        $idiomaId = (int)$_POST["idioma_id"];
        if ($idiomaId > 0) {
            $controller->agregarIdiomaAudioASerie($serieId, $idiomaId);
            $message = "Idioma agregado correctamente.";
        }
    } else {
        // Update normal
        if (isset($_POST["titulo"], $_POST["plataformaId"], $_POST["directorId"])) {
            $ok = $controller->updateSerie($serieId, $_POST["titulo"], (int)$_POST["plataformaId"], (int)$_POST["directorId"]);
            $message = $ok ? "OK: Serie modificada correctamente." : "ERROR: No se pudo modificar.";
        }
    }

    // refrescar datos en pantalla
    $serie = $controller->getSerie($serieId);
}

// Cargar listas para los selects
$plataformas = Platform::getAll();
$directores = Director::getAll();

require_once __DIR__ . "/../../models/Actor.php";
require_once __DIR__ . "/../../models/Idioma.php";
$allActores = Actor::getAll();
$allIdiomas = Idioma::getAll();

// Obtener relaciones actuales
$actoresSeries = $controller->getActoresDeSerie($serie->getId());
$idiomasSeries = $controller->getIdiomasAudioDeSerie($serie->getId());

$pageTitle = 'Editar Serie';

// Capturar contenido
ob_start();
?>
<h1>Editar Serie</h1>

<p><a href="list.php">⬅ Volver al listado</a></p>

<?php if ($message): ?>
    <p style="padding: 10px; background: <?= strpos($message, 'ERROR') !== false ? '#ffcccc' : '#ccffcc' ?>; border: 1px solid <?= strpos($message, 'ERROR') !== false ? '#cc0000' : '#00cc00' ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<div style="display: flex; gap: 40px; flex-wrap: wrap;">

    <!-- Columna Izq: Datos Principales -->
    <div style="flex: 1; min-width: 300px;">
        <h3>Datos Principales</h3>
        <form action="" method="post" style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
            <input type="hidden" name="id" value="<?= htmlspecialchars((string)$serie->getId()) ?>">

            <div style="margin-bottom: 15px;">
                <label for="titulo">Título:</label><br>
                <input type="text" id="titulo" name="titulo" required minlength="2"
                    value="<?= htmlspecialchars($serie->getTitulo()) ?>"
                    style="width: 100%; padding: 5px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="plataformaId">Plataforma:</label><br>
                <select id="plataformaId" name="plataformaId" required style="width: 100%; padding: 5px;">
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
                <select id="directorId" name="directorId" required style="width: 100%; padding: 5px;">
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($directores as $d): ?>
                        <option value="<?= $d->getId() ?>" <?= $d->getId() == $serie->getDirectorId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d->getNombre() . ' ' . $d->getApellidos()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" style="padding: 8px 15px; width: 100%;">💾 Actualizar Datos Principales</button>
        </form>
    </div>

    <!-- Columna Der: Relaciones -->
    <div style="flex: 1; min-width: 300px;">

        <!-- ACTORES -->
        <div style="margin-bottom: 30px;">
            <h3>🎭 Actores</h3>
            <ul style="border: 1px solid #ddd; padding: 10px; border-radius: 5px; background: white;">
                <?php if (count($actoresSeries) === 0): ?>
                    <li>No hay actores asignados.</li>
                <?php else: ?>
                    <?php foreach ($actoresSeries as $a): ?>
                        <li style="margin-bottom: 5px; display: flex; justify-content: space-between; align-items: center;">
                            <?= htmlspecialchars($a->getNombre() . ' ' . $a->getApellidos()) ?>
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $serie->getId() ?>">
                                <input type="hidden" name="tipo" value="remove_actor">
                                <input type="hidden" name="actor_id" value="<?= $a->getId() ?>">
                                <button type="submit" style="font-size: 0.8em; color: red;">Quitar</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <form action="" method="post" style="margin-top: 10px; display: flex; gap: 5px;">
                <input type="hidden" name="id" value="<?= $serie->getId() ?>">
                <input type="hidden" name="tipo" value="add_actor">
                <select name="actor_id" required style="flex: 1;">
                    <option value="">Añadir Actor...</option>
                    <?php foreach ($allActores as $a):
                        // Filtrar los que ya están (opcional, pero mejora UX, por ahora simple)
                    ?>
                        <option value="<?= $a->getId() ?>"><?= htmlspecialchars($a->getNombre() . ' ' . $a->getApellidos()) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">➕</button>
            </form>
        </div>

        <!-- IDIOMAS -->
        <div>
            <h3>🌐 Idiomas (Audio)</h3>
            <ul style="border: 1px solid #ddd; padding: 10px; border-radius: 5px; background: white;">
                <?php if (count($idiomasSeries) === 0): ?>
                    <li>No hay idiomas asignados.</li>
                <?php else: ?>
                    <?php foreach ($idiomasSeries as $i): ?>
                        <li style="margin-bottom: 5px; display: flex; justify-content: space-between; align-items: center;">
                            <?= htmlspecialchars($i->getNombre()) ?>
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $serie->getId() ?>">
                                <input type="hidden" name="tipo" value="remove_idioma">
                                <input type="hidden" name="idioma_id" value="<?= $i->getId() ?>">
                                <button type="submit" style="font-size: 0.8em; color: red;">Quitar</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <form action="" method="post" style="margin-top: 10px; display: flex; gap: 5px;">
                <input type="hidden" name="id" value="<?= $serie->getId() ?>">
                <input type="hidden" name="tipo" value="add_idioma">
                <select name="idioma_id" required style="flex: 1;">
                    <option value="">Añadir Idioma...</option>
                    <?php foreach ($allIdiomas as $i): ?>
                        <option value="<?= $i->getId() ?>"><?= htmlspecialchars($i->getNombre()) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">➕</button>
            </form>
        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';

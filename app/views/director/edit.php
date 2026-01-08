<?php
require_once __DIR__ . "/../../controllers/DirectorController.php";

$controller = new DirectorController();
$message = null;

// 1) Cargar director (por GET)
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
$director = $controller->getDirector($id);

if (!$director) {
    die("Director no encontrado.");
}

// 2) Procesar update (por POST)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["nombre"], $_POST["apellidos"], $_POST["fechaNacimiento"], $_POST["nacionalidad"])) {
    $directorId = (int)$_POST["id"];
    $ok = $controller->updateDirector($directorId, $_POST["nombre"], $_POST["apellidos"], $_POST["fechaNacimiento"], $_POST["nacionalidad"]);
    $message = $ok ? "OK: Director modificado correctamente." : "ERROR: No se pudo modificar.";
    // refrescar datos en pantalla
    $director = $controller->getDirector($directorId);
}

$pageTitle = 'Editar Director';

// Capturar contenido
ob_start();
?>
<h1>Editar Director</h1>

<?php if ($message): ?>
    <p style="padding: 10px; background: <?= strpos($message, 'ERROR') !== false ? '#ffcccc' : '#ccffcc' ?>; border: 1px solid <?= strpos($message, 'ERROR') !== false ? '#cc0000' : '#00cc00' ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form action="" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$director->getId()) ?>">
    
    <div style="margin-bottom: 15px;">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required minlength="2" 
               value="<?= htmlspecialchars($director->getNombre()) ?>" 
               style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos" required minlength="2" 
               value="<?= htmlspecialchars($director->getApellidos()) ?>" 
               style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="fechaNacimiento">Fecha de Nacimiento:</label><br>
        <input type="date" id="fechaNacimiento" name="fechaNacimiento" required 
               value="<?= htmlspecialchars($director->getFechaNacimiento()) ?>" 
               style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="nacionalidad">Nacionalidad:</label><br>
        <input type="text" id="nacionalidad" name="nacionalidad" required minlength="2" 
               value="<?= htmlspecialchars($director->getNacionalidad()) ?>" 
               style="width: 300px; padding: 5px;">
    </div>
    
    <button type="submit" style="padding: 8px 15px;">💾 Guardar</button>
    <a href="list.php" style="margin-left: 10px;">❌ Cancelar</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';

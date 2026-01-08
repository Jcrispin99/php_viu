<?php
require_once __DIR__ . "/../../controllers/DirectorController.php";

$controller = new DirectorController();
$message = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nombre"], $_POST["apellidos"], $_POST["fechaNacimiento"], $_POST["nacionalidad"])) {
    $ok = $controller->createDirector($_POST["nombre"], $_POST["apellidos"], $_POST["fechaNacimiento"], $_POST["nacionalidad"]);
    $message = $ok ? "OK: Director creado correctamente." : "ERROR: No se pudo crear (datos inválidos o fecha incorrecta).";
}

$pageTitle = 'Crear Director';

// Capturar contenido
ob_start();
?>
<h1>Crear Director</h1>

<?php if ($message): ?>
    <p style="padding: 10px; background: <?= strpos($message, 'ERROR') !== false ? '#ffcccc' : '#ccffcc' ?>; border: 1px solid <?= strpos($message, 'ERROR') !== false ? '#cc0000' : '#00cc00' ?>;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<form action="" method="post">
    <div style="margin-bottom: 15px;">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required minlength="2" style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos" required minlength="2" style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="fechaNacimiento">Fecha de Nacimiento:</label><br>
        <input type="date" id="fechaNacimiento" name="fechaNacimiento" required style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="nacionalidad">Nacionalidad:</label><br>
        <input type="text" id="nacionalidad" name="nacionalidad" required minlength="2" style="width: 300px; padding: 5px;">
    </div>
    
    <button type="submit" style="padding: 8px 15px;">✅ Crear</button>
    <a href="list.php" style="margin-left: 10px;">❌ Cancelar</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';

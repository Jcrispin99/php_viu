<?php
require_once __DIR__ . "/../../controllers/DirectorController.php";

$controller = new DirectorController();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = (int)$_POST["id"];
    $ok = $controller->deleteDirector($id);
    
    if ($ok) {
        header("Location: list.php");
        exit;
    } else {
        die("ERROR: No se pudo eliminar el director.");
    }
} else {
    die("Solicitud inválida.");
}

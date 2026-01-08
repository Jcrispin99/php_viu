<?php
require_once __DIR__ . "/../../controllers/IdiomaController.php";

$controller = new IdiomaController();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = (int)$_POST["id"];
    $ok = $controller->deleteIdioma($id);
    
    if ($ok) {
        header("Location: list.php");
        exit;
    } else {
        die("ERROR: No se pudo eliminar el idioma.");
    }
} else {
    die("Solicitud inválida.");
}

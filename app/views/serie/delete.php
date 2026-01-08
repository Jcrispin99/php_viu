<?php
require_once __DIR__ . "/../../controllers/SerieController.php";

$controller = new SerieController();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = (int)$_POST["id"];
    $ok = $controller->deleteSerie($id);
    
    if ($ok) {
        header("Location: list.php");
        exit;
    } else {
        die("ERROR: No se pudo eliminar la serie.");
    }
} else {
    die("Solicitud inválida.");
}

<?php
require_once __DIR__ . "/../../controllers/ActorController.php";

$controller = new ActorController();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = (int)$_POST["id"];
    $ok = $controller->deleteActor($id);
    
    if ($ok) {
        header("Location: list.php");
        exit;
    } else {
        die("ERROR: No se pudo eliminar el actor.");
    }
} else {
    die("Solicitud inválida.");
}

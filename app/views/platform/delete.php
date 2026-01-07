<?php
require_once __DIR__ . "/../../controllers/PlatformController.php";
$controller = new PlatformController();

// Solo procesar POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = (int)$_POST["id"];
    $ok = $controller->deletePlatform($id);
    
    if ($ok) {
        // Redirigir al listado con mensaje de éxito
        header("Location: list.php?msg=deleted");
        exit;
    } else {
        // Redirigir con error
        header("Location: list.php?error=delete");
        exit;
    }
}

// Si no es POST, redirigir al listado
header("Location: list.php");
exit;

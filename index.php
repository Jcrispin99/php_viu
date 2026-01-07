<?php

/**
 * Front Controller - Punto de entrada de la aplicación
 * Maneja todas las peticiones y enruta a los controladores correspondientes
 */

// Obtener parámetros de la URL
$controller = $_GET['controller'] ?? 'platform';  // Controlador por defecto
$action = $_GET['action'] ?? 'index';              // Acción por defecto

// Construir el nombre del archivo del controlador
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = __DIR__ . '/app/controllers/' . $controllerName . '.php';

// Verificar si el controlador existe
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Verificar si la clase existe
    if (class_exists($controllerName)) {
        $controllerInstance = new $controllerName();
        
        // Verificar si el método (acción) existe
        if (method_exists($controllerInstance, $action)) {
            // Ejecutar la acción
            $controllerInstance->$action();
        } else {
            // Si la acción no existe
            http_response_code(404);
            echo '<h1>404 - Acción no encontrada</h1>';
            echo '<p>La acción "' . htmlspecialchars($action) . '" no existe en el controlador "' . htmlspecialchars($controllerName) . '"</p>';
        }
    } else {
        // Si la clase no existe
        http_response_code(500);
        echo '<h1>500 - Error del servidor</h1>';
        echo '<p>La clase del controlador no fue encontrada</p>';
    }
} else {
    // Si el controlador no existe
    http_response_code(404);
    echo '<h1>404 - Controlador no encontrado</h1>';
    echo '<p>El controlador "' . htmlspecialchars($controllerName) . '" no existe</p>';
    echo '<p>Ruta esperada: ' . htmlspecialchars($controllerFile) . '</p>';
}

<?php

// Archivo para probar la conexión a la base de datos

require_once 'app/config.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Conexión BD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }
        .success {
            padding: 15px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 5px;
            margin: 10px 0;
        }
        .error {
            padding: 15px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            border-radius: 5px;
            margin: 10px 0;
        }
        .info {
            padding: 15px;
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            border-radius: 5px;
            margin: 10px 0;
        }
        h1 {
            color: #333;
        }
        code {
            background-color: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <h1>🔌 Test de Conexión a Base de Datos</h1>
    
    <?php
    // Intentar conectar
    $database = new Database();
    $conn = $database->connect();
    
    if ($conn) {
        echo '<div class="success">';
        echo '<strong>✅ ¡Conexión exitosa!</strong><br>';
        echo 'Conectado a la base de datos: <code>' . DB_NAME . '</code><br>';
        echo 'Servidor: <code>' . DB_SERVER . '</code>';
        echo '</div>';
        
        // Probar una consulta simple
        try {
            $query = "SELECT DATABASE() as db_name, NOW() as server_time";
            $stmt = $conn->query($query);
            $result = $stmt->fetch();
            
            echo '<div class="info">';
            echo '<strong>📊 Información de la conexión:</strong><br>';
            echo 'Base de datos activa: <code>' . $result['db_name'] . '</code><br>';
            echo 'Hora del servidor: <code>' . $result['server_time'] . '</code>';
            echo '</div>';
            
        } catch(PDOException $e) {
            echo '<div class="error">';
            echo '<strong>⚠️ Error en la consulta:</strong><br>';
            echo $e->getMessage();
            echo '</div>';
        }
        
    } else {
        echo '<div class="error">';
        echo '<strong>❌ Error de conexión</strong><br>';
        echo 'No se pudo conectar a la base de datos.';
        echo '</div>';
        
        echo '<div class="info">';
        echo '<strong>Verifica:</strong><br>';
        echo '1. Que MySQL/MariaDB esté corriendo<br>';
        echo '2. Que la base de datos <code>' . DB_NAME . '</code> exista<br>';
        echo '3. Las credenciales en <code>app/config.php</code>';
        echo '</div>';
    }
    ?>
    
    <hr style="margin: 30px 0;">
    
    <h2>📝 Siguiente paso:</h2>
    <div class="info">
        <p>Si no existe la base de datos, créala con:</p>
        <code style="display: block; padding: 10px; background: #f8f9fa;">
            CREATE DATABASE viu_php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        </code>
    </div>
    
</body>
</html>

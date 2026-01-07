<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataformas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 30px;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-align: center;
        }
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-edit {
            background: #ffc107;
            color: #333;
            padding: 8px 16px;
            font-size: 14px;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            font-size: 14px;
        }
        .btn-edit:hover, .btn-delete:hover {
            transform: translateY(-2px);
        }
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideIn 0.5s;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        tbody tr {
            border-bottom: 1px solid #eee;
            transition: all 0.3s;
        }
        tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state svg {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎬 Plataformas de Streaming</h1>
        
        <?php
        // Mostrar mensajes de éxito o error
        if (isset($_GET['msg'])) {
            $messages = [
                'created' => '✅ Plataforma creada exitosamente',
                'updated' => '✅ Plataforma actualizada exitosamente',
                'deleted' => '✅ Plataforma eliminada exitosamente'
            ];
            $msg = $_GET['msg'];
            if (isset($messages[$msg])) {
                echo '<div class="alert alert-success">' . $messages[$msg] . '</div>';
            }
        }
        
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-error">❌ Ocurrió un error. Intenta nuevamente.</div>';
        }
        ?>
        
        <div class="header-actions">
            <a href="index.php?controller=platform&action=create" class="btn btn-primary">
                ➕ Nueva Plataforma
            </a>
        </div>
        
        <?php if (empty($platforms)): ?>
            <div class="empty-state">
                <h2>No hay plataformas registradas</h2>
                <p>Comienza agregando una nueva plataforma</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($platforms as $platform): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($platform['id']); ?></td>
                        <td><?php echo htmlspecialchars($platform['nombre']); ?></td>
                        <td class="actions">
                            <a href="index.php?controller=platform&action=edit&id=<?php echo $platform['id']; ?>" 
                               class="btn btn-edit">
                                ✏️ Editar
                            </a>
                            <a href="index.php?controller=platform&action=destroy&id=<?php echo $platform['id']; ?>" 
                               class="btn btn-delete"
                               onclick="return confirm('¿Estás seguro de eliminar esta plataforma?')">
                                🗑️ Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>

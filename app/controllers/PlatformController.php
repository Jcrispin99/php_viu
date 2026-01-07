<?php

require_once __DIR__ . '/../models/Platform.php';

class PlatformController {
    private $platformModel;
    
    public function __construct() {
        $this->platformModel = new Platform();
    }
    
    // Mostrar lista de todas las plataformas
    public function index() {
        // 1. Llamar al modelo para obtener los datos
        $platforms = $this->platformModel->getAll();
        
        // 2. Pasar los datos a la vista
        require_once __DIR__ . '/../views/platform/index.php';
    }
    
    // Mostrar formulario para crear nueva plataforma
    public function create() {
        require_once __DIR__ . '/../views/platform/create.php';
    }
    
    // Guardar nueva plataforma en la BD
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            
            if (!empty($nombre)) {
                $result = $this->platformModel->create($nombre);
                
                if ($result) {
                    // Redirigir a la lista con mensaje de éxito
                    header('Location: index.php?controller=platform&action=index&msg=created');
                    exit;
                }
            }
        }
        
        // Si hay error, volver al formulario
        header('Location: index.php?controller=platform&action=create&error=1');
        exit;
    }
    
    // Mostrar formulario para editar
    public function edit() {
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $platform = $this->platformModel->getById($id);
            
            if ($platform) {
                require_once __DIR__ . '/../views/platform/edit.php';
                return;
            }
        }
        
        // Si no existe, redirigir al listado
        header('Location: index.php?controller=platform&action=index');
        exit;
    }
    
    // Actualizar plataforma en la BD
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            
            if ($id && !empty($nombre)) {
                $result = $this->platformModel->update($id, $nombre);
                
                if ($result) {
                    header('Location: index.php?controller=platform&action=index&msg=updated');
                    exit;
                }
            }
        }
        
        header('Location: index.php?controller=platform&action=index&error=1');
        exit;
    }
    
    // Eliminar plataforma
    public function destroy() {
        $id = $_GET['id'] ?? null;
        
        if ($id) {
            $result = $this->platformModel->delete($id);
            
            if ($result) {
                header('Location: index.php?controller=platform&action=index&msg=deleted');
                exit;
            }
        }
        
        header('Location: index.php?controller=platform&action=index&error=1');
        exit;
    }
}

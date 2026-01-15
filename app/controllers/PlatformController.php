<?php
require_once __DIR__ . "/../models/Platform.php";

class PlatformController {

    public function listPlatforms(): array {
        return Platform::getAll();
    }

    public function createPlatform(string $name): bool {
        $name = trim($name);
        if ($name === "" || strlen($name) < 2) return false;
        return Platform::create($name);
    }

    public function getPlatform(int $id): ?Platform {
        if ($id <= 0) return null;
        return Platform::getById($id);
    }

    public function updatePlatform(int $id, string $name): bool {
        $name = trim($name);
        if ($id <= 0 || $name === "" || strlen($name) < 2) return false;

        // Validación BBDD: que exista antes de actualizar
        $p = Platform::getById($id);
        if (!$p) return false;

        return Platform::update($id, $name);
    }

    public function deletePlatform(int $id): bool {
        if ($id <= 0) return false;

        // Validación BBDD: que exista antes de borrar
        $p = Platform::getById($id);
        if (!$p) return false;

        return Platform::delete($id);
    }

    /**
     * Obtiene información de las series que se eliminarán en cascada
     */
    public function getRelatedSeriesInfo(int $id): array {
        if ($id <= 0) return ['count' => 0, 'series' => []];
        
        return [
            'count' => Platform::getRelatedSeriesCount($id),
            'series' => Platform::getRelatedSeries($id)
        ];
    }
}
<?php
require_once __DIR__ . "/../models/Director.php";

class DirectorController {

    public function listDirectores(): array {
        return Director::getAll();
    }

    public function createDirector(string $nombre, string $apellidos, string $fechaNacimiento, string $nacionalidad): bool {
        $nombre = trim($nombre);
        $apellidos = trim($apellidos);
        $nacionalidad = trim($nacionalidad);
        
        if ($nombre === "" || strlen($nombre) < 2) return false;
        if ($apellidos === "" || strlen($apellidos) < 2) return false;
        if ($nacionalidad === "" || strlen($nacionalidad) < 2) return false;
        
        // Validar formato de fecha (YYYY-MM-DD)
        $date = \DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        if (!$date || $date->format('Y-m-d') !== $fechaNacimiento) return false;
        
        return Director::create($nombre, $apellidos, $fechaNacimiento, $nacionalidad);
    }

    public function getDirector(int $id): ?Director {
        if ($id <= 0) return null;
        return Director::getById($id);
    }

    public function updateDirector(int $id, string $nombre, string $apellidos, string $fechaNacimiento, string $nacionalidad): bool {
        $nombre = trim($nombre);
        $apellidos = trim($apellidos);
        $nacionalidad = trim($nacionalidad);
        
        if ($id <= 0) return false;
        if ($nombre === "" || strlen($nombre) < 2) return false;
        if ($apellidos === "" || strlen($apellidos) < 2) return false;
        if ($nacionalidad === "" || strlen($nacionalidad) < 2) return false;
        
        // Validar formato de fecha (YYYY-MM-DD)
        $date = \DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        if (!$date || $date->format('Y-m-d') !== $fechaNacimiento) return false;

        // Validación BBDD: que exista antes de actualizar
        $director = Director::getById($id);
        if (!$director) return false;

        return Director::update($id, $nombre, $apellidos, $fechaNacimiento, $nacionalidad);
    }

    public function deleteDirector(int $id): bool {
        if ($id <= 0) return false;

        // Validación BBDD: que exista antes de borrar
        $director = Director::getById($id);
        if (!$director) return false;

        return Director::delete($id);
    }

    /**
     * Obtiene información de las series que se eliminarán en cascada
     */
    public function getRelatedSeriesInfo(int $id): array {
        if ($id <= 0) return ['count' => 0, 'series' => []];
        
        return [
            'count' => Director::getRelatedSeriesCount($id),
            'series' => Director::getRelatedSeries($id)
        ];
    }
}

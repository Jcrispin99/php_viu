<?php
require_once __DIR__ . "/../models/Actor.php";

class ActorController {

    public function listActores(): array {
        return Actor::getAll();
    }

    public function createActor(string $nombre, string $apellidos, string $fechaNacimiento, string $nacionalidad): bool {
        $nombre = trim($nombre);
        $apellidos = trim($apellidos);
        $nacionalidad = trim($nacionalidad);
        
        if ($nombre === "" || strlen($nombre) < 2) return false;
        if ($apellidos === "" || strlen($apellidos) < 2) return false;
        if ($nacionalidad === "" || strlen($nacionalidad) < 2) return false;
        
        // Validar formato de fecha (YYYY-MM-DD)
        $date = \DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
        if (!$date || $date->format('Y-m-d') !== $fechaNacimiento) return false;
        
        return Actor::create($nombre, $apellidos, $fechaNacimiento, $nacionalidad);
    }

    public function getActor(int $id): ?Actor {
        if ($id <= 0) return null;
        return Actor::getById($id);
    }

    public function updateActor(int $id, string $nombre, string $apellidos, string $fechaNacimiento, string $nacionalidad): bool {
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
        $actor = Actor::getById($id);
        if (!$actor) return false;

        return Actor::update($id, $nombre, $apellidos, $fechaNacimiento, $nacionalidad);
    }

    public function deleteActor(int $id): bool {
        if ($id <= 0) return false;

        // Validación BBDD: que exista antes de borrar
        $actor = Actor::getById($id);
        if (!$actor) return false;

        return Actor::delete($id);
    }

    /**
     * Obtiene información de las series donde participa este actor
     */
    public function getRelatedSeriesInfo(int $id): array {
        if ($id <= 0) return ['count' => 0, 'series' => []];
        
        return [
            'count' => Actor::getRelatedSeriesCount($id),
            'series' => Actor::getRelatedSeries($id)
        ];
    }
}

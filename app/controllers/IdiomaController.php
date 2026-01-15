<?php
require_once __DIR__ . "/../models/Idioma.php";

class IdiomaController {

    public function listIdiomas(): array {
        return Idioma::getAll();
    }

    public function createIdioma(string $nombre, string $isoCode): bool {
        $nombre = trim($nombre);
        $isoCode = trim(strtolower($isoCode)); // Normalizar a minúsculas
        
        if ($nombre === "" || strlen($nombre) < 2) return false;
        if ($isoCode === "" || strlen($isoCode) < 2 || strlen($isoCode) > 10) return false;
        
        // Verificar que el iso_code no exista (es UNIQUE)
        $existing = Idioma::getByIsoCode($isoCode);
        if ($existing) return false;
        
        return Idioma::create($nombre, $isoCode);
    }

    public function getIdioma(int $id): ?Idioma {
        if ($id <= 0) return null;
        return Idioma::getById($id);
    }

    public function updateIdioma(int $id, string $nombre, string $isoCode): bool {
        $nombre = trim($nombre);
        $isoCode = trim(strtolower($isoCode)); // Normalizar a minúsculas
        
        if ($id <= 0) return false;
        if ($nombre === "" || strlen($nombre) < 2) return false;
        if ($isoCode === "" || strlen($isoCode) < 2 || strlen($isoCode) > 10) return false;

        // Validación BBDD: que exista antes de actualizar
        $idioma = Idioma::getById($id);
        if (!$idioma) return false;
        
        // Si el iso_code cambió, verificar que no exista otro con ese código
        if ($idioma->getIsoCode() !== $isoCode) {
            $existing = Idioma::getByIsoCode($isoCode);
            if ($existing) return false;
        }

        return Idioma::update($id, $nombre, $isoCode);
    }

    public function deleteIdioma(int $id): bool {
        if ($id <= 0) return false;

        // Validación BBDD: que exista antes de borrar
        $idioma = Idioma::getById($id);
        if (!$idioma) return false;

        return Idioma::delete($id);
    }

    /**
     * Obtiene información de las series que usan este idioma
     */
    public function getRelatedSeriesInfo(int $id): array {
        if ($id <= 0) return ['count' => 0, 'series' => []];
        
        return [
            'count' => Idioma::getRelatedSeriesCount($id),
            'series' => Idioma::getRelatedSeries($id)
        ];
    }
}

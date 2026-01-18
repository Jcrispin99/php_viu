<?php
require_once __DIR__ . "/../models/Serie.php";
require_once __DIR__ . "/../models/Platform.php";
require_once __DIR__ . "/../models/Director.php";

class SerieController
{

    public function listSeries(): array
    {
        return Serie::getAll();
    }

    public function createSerie(string $titulo, int $plataformaId, int $directorId): int
    {
        $titulo = trim($titulo);

        if ($titulo === "" || strlen($titulo) < 2) return 0;
        if ($plataformaId <= 0 || $directorId <= 0) return 0;

        // Validar que la plataforma exista
        $plataforma = Platform::getById($plataformaId);
        if (!$plataforma) return 0;

        // Validar que el director exista
        $director = Director::getById($directorId);
        if (!$director) return 0;

        $created = Serie::create($titulo, $plataformaId, $directorId);
        if ($created) {
            return Serie::getLastInsertId();
        }
        return 0;
    }

    public function getSerie(int $id): ?Serie
    {
        if ($id <= 0) return null;
        return Serie::getById($id);
    }

    public function updateSerie(int $id, string $titulo, int $plataformaId, int $directorId): bool
    {
        $titulo = trim($titulo);

        if ($id <= 0) return false;
        if ($titulo === "" || strlen($titulo) < 2) return false;
        if ($plataformaId <= 0 || $directorId <= 0) return false;

        // Validación BBDD: que exista antes de actualizar
        $serie = Serie::getById($id);
        if (!$serie) return false;

        // Validar que la plataforma exista
        $plataforma = Platform::getById($plataformaId);
        if (!$plataforma) return false;

        // Validar que el director exista
        $director = Director::getById($directorId);
        if (!$director) return false;

        return Serie::update($id, $titulo, $plataformaId, $directorId);
    }

    public function deleteSerie(int $id): bool
    {
        if ($id <= 0) return false;

        // Validación BBDD: que exista antes de borrar
        $serie = Serie::getById($id);
        if (!$serie) return false;

        return Serie::delete($id);
    }

    // ========== MÉTODOS DE RELACIONES ==========

    // ===== Actores =====

    public function getActoresDeSerie(int $serieId): array
    {
        if ($serieId <= 0) return [];

        $serie = Serie::getById($serieId);
        if (!$serie) return [];

        return Serie::getActores($serieId);
    }

    public function agregarActorASerie(int $serieId, int $actorId): bool
    {
        if ($serieId <= 0 || $actorId <= 0) return false;

        // Validar que la serie exista
        $serie = Serie::getById($serieId);
        if (!$serie) return false;

        // Validar que el actor exista
        require_once __DIR__ . "/../models/Actor.php";
        $actor = Actor::getById($actorId);
        if (!$actor) return false;

        return Serie::addActor($serieId, $actorId);
    }

    public function removerActorDeSerie(int $serieId, int $actorId): bool
    {
        if ($serieId <= 0 || $actorId <= 0) return false;
        return Serie::removeActor($serieId, $actorId);
    }

    // ===== Idiomas de Audio =====

    public function getIdiomasAudioDeSerie(int $serieId): array
    {
        if ($serieId <= 0) return [];

        $serie = Serie::getById($serieId);
        if (!$serie) return [];

        return Serie::getIdiomasAudio($serieId);
    }

    public function agregarIdiomaAudioASerie(int $serieId, int $idiomaId): bool
    {
        if ($serieId <= 0 || $idiomaId <= 0) return false;

        // Validar que la serie exista
        $serie = Serie::getById($serieId);
        if (!$serie) return false;

        // Validar que el idioma exista
        require_once __DIR__ . "/../models/Idioma.php";
        $idioma = Idioma::getById($idiomaId);
        if (!$idioma) return false;

        return Serie::addIdiomaAudio($serieId, $idiomaId);
    }

    public function removerIdiomaAudioDeSerie(int $serieId, int $idiomaId): bool
    {
        if ($serieId <= 0 || $idiomaId <= 0) return false;
        return Serie::removeIdiomaAudio($serieId, $idiomaId);
    }

    // ===== Idiomas de Subtítulos =====

    public function getIdiomasSubtitulosDeSerie(int $serieId): array
    {
        if ($serieId <= 0) return [];

        $serie = Serie::getById($serieId);
        if (!$serie) return [];

        return Serie::getIdiomasSubtitulos($serieId);
    }

    public function agregarIdiomaSubtituloASerie(int $serieId, int $idiomaId): bool
    {
        if ($serieId <= 0 || $idiomaId <= 0) return false;

        // Validar que la serie exista
        $serie = Serie::getById($serieId);
        if (!$serie) return false;

        // Validar que el idioma exista
        require_once __DIR__ . "/../models/Idioma.php";
        $idioma = Idioma::getById($idiomaId);
        if (!$idioma) return false;

        return Serie::addIdiomaSubtitulo($serieId, $idiomaId);
    }

    public function removerIdiomaSubtituloDeSerie(int $serieId, int $idiomaId): bool
    {
        if ($serieId <= 0 || $idiomaId <= 0) return false;
        return Serie::removeIdiomaSubtitulo($serieId, $idiomaId);
    }
}

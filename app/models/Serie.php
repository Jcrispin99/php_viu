<?php
require_once __DIR__ . '/../config.php';

class Serie {
    private $id;
    private $titulo;
    private $plataformaId;
    private $directorId;
    private $plataformaNombre;
    private $directorNombre;
    private $actoresNombres; // String separado por comas

    public function __construct($id, $titulo, $plataformaId, $directorId, $plataformaNombre = null, $directorNombre = null, $actoresNombres = null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->plataformaId = $plataformaId;
        $this->directorId = $directorId;
        $this->plataformaNombre = $plataformaNombre;
        $this->directorNombre = $directorNombre;
        $this->actoresNombres = $actoresNombres;
    }

    // Getters existing... adding new ones
    public function getPlataformaNombre() { return $this->plataformaNombre; }
    public function getDirectorNombre() { return $this->directorNombre; }
    public function getActoresNombres() { return $this->actoresNombres; }

    // ... existing getters for ids/titles ... (kept implicitly by not replacing them, but I need to be careful with the replacement range)

    // Re-declaring standard getters for context if needed, but I'll try to just act on the block efficiently.
    // Actually, to be safe and clean, I will replace the top part of the class including properties and constructor.
    
    // Getters
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getPlataformaId() { return $this->plataformaId; }
    public function getDirectorId() { return $this->directorId; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setTitulo($titulo) { $this->titulo = $titulo; }
    public function setPlataformaId($plataformaId) { $this->plataformaId = $plataformaId; }
    public function setDirectorId($directorId) { $this->directorId = $directorId; }
    
    public function setPlataformaNombre($nombre) { $this->plataformaNombre = $nombre; }
    public function setDirectorNombre($nombre) { $this->directorNombre = $nombre; }
    public function setActoresNombres($nombres) { $this->actoresNombres = $nombres; }

    // CRUD - Usando conexión centralizada de config.php
    public static function getAll(): array {
        $pdo = coneccion();
        // Query mejorada con JOINS
        $sql = "SELECT 
                    s.id, s.titulo, s.plataforma_id, s.director_id,
                    p.nombre AS plataforma_nombre,
                    CONCAT(d.nombre, ' ', d.apellidos) AS director_nombre,
                    GROUP_CONCAT(CONCAT(a.nombre, ' ', a.apellidos) SEPARATOR ', ') AS actores_nombres
                FROM series s
                LEFT JOIN plataformas p ON s.plataforma_id = p.id
                LEFT JOIN directores d ON s.director_id = d.id
                LEFT JOIN series_actores sa ON s.id = sa.serie_id
                LEFT JOIN actores a ON sa.actor_id = a.id
                GROUP BY s.id, s.titulo, s.plataforma_id, s.director_id, p.nombre, d.nombre, d.apellidos
                ORDER BY s.id DESC";
                
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $series = [];
        foreach ($rows as $row) {
            $series[] = new Serie(
                (int)$row["id"],
                $row["titulo"],
                (int)$row["plataforma_id"],
                (int)$row["director_id"],
                $row["plataforma_nombre"],
                $row["director_nombre"],
                $row["actores_nombres"]                 
            );
        }
        return $series;
    }

    public static function getById(int $id): ?Serie {
        $pdo = coneccion();
        $stmt = $pdo->prepare("SELECT id, titulo, plataforma_id, director_id FROM series WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;
        return new Serie(
            (int)$row["id"],
            $row["titulo"],
            (int)$row["plataforma_id"],
            (int)$row["director_id"]
        );
    }

    public static function create(string $titulo, int $plataformaId, int $directorId): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("INSERT INTO series (titulo, plataforma_id, director_id) VALUES (:titulo, :plataforma_id, :director_id)");
        return $stmt->execute([
            ":titulo" => $titulo,
            ":plataforma_id" => $plataformaId,
            ":director_id" => $directorId
        ]);
    }

    public static function update(int $id, string $titulo, int $plataformaId, int $directorId): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("UPDATE series SET titulo = :titulo, plataforma_id = :plataforma_id, director_id = :director_id WHERE id = :id");
        return $stmt->execute([
            ":id" => $id,
            ":titulo" => $titulo,
            ":plataforma_id" => $plataformaId,
            ":director_id" => $directorId
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("DELETE FROM series WHERE id = :id");
        return $stmt->execute([":id" => $id]);
    }

    // ========== MÉTODOS DE RELACIONES ==========

    // ===== Actores =====
    
    /**
     * Obtener todos los actores de una serie
     */
    public static function getActores(int $serieId): array {
        $pdo = coneccion();
        $stmt = $pdo->prepare("
            SELECT a.id, a.nombre, a.apellidos, a.fecha_nacimiento, a.nacionalidad 
            FROM actores a
            INNER JOIN series_actores sa ON a.id = sa.actor_id
            WHERE sa.serie_id = :serie_id
            ORDER BY a.nombre ASC
        ");
        $stmt->execute([":serie_id" => $serieId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/Actor.php';
        $actores = [];
        foreach ($rows as $row) {
            $actores[] = new Actor(
                (int)$row["id"],
                $row["nombre"],
                $row["apellidos"],
                $row["fecha_nacimiento"],
                $row["nacionalidad"]
            );
        }
        return $actores;
    }

    /**
     * Agregar un actor a una serie
     */
    public static function addActor(int $serieId, int $actorId): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("INSERT IGNORE INTO series_actores (serie_id, actor_id) VALUES (:serie_id, :actor_id)");
        return $stmt->execute([
            ":serie_id" => $serieId,
            ":actor_id" => $actorId
        ]);
    }

    /**
     * Eliminar un actor de una serie
     */
    public static function removeActor(int $serieId, int $actorId): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("DELETE FROM series_actores WHERE serie_id = :serie_id AND actor_id = :actor_id");
        return $stmt->execute([
            ":serie_id" => $serieId,
            ":actor_id" => $actorId
        ]);
    }

    // ===== Idiomas de Audio =====
    
    /**
     * Obtener todos los idiomas de audio de una serie
     */
    public static function getIdiomasAudio(int $serieId): array {
        $pdo = coneccion();
        $stmt = $pdo->prepare("
            SELECT i.id, i.nombre, i.iso_code 
            FROM idiomas i
            INNER JOIN series_idiomas_audio sia ON i.id = sia.idioma_id
            WHERE sia.serie_id = :serie_id
            ORDER BY i.nombre ASC
        ");
        $stmt->execute([":serie_id" => $serieId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/Idioma.php';
        $idiomas = [];
        foreach ($rows as $row) {
            $idiomas[] = new Idioma(
                (int)$row["id"],
                $row["nombre"],
                $row["iso_code"]
            );
        }
        return $idiomas;
    }

    /**
     * Agregar un idioma de audio a una serie
     */
    public static function addIdiomaAudio(int $serieId, int $idiomaId): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("INSERT IGNORE INTO series_idiomas_audio (serie_id, idioma_id) VALUES (:serie_id, :idioma_id)");
        return $stmt->execute([
            ":serie_id" => $serieId,
            ":idioma_id" => $idiomaId
        ]);
    }

    /**
     * Eliminar un idioma de audio de una serie
     */
    public static function removeIdiomaAudio(int $serieId, int $idiomaId): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("DELETE FROM series_idiomas_audio WHERE serie_id = :serie_id AND idioma_id = :idioma_id");
        return $stmt->execute([
            ":serie_id" => $serieId,
            ":idioma_id" => $idiomaId
        ]);
    }

    // ===== Idiomas de Subtítulos =====
    
    /**
     * Obtener todos los idiomas de subtítulos de una serie
     */
    public static function getIdiomasSubtitulos(int $serieId): array {
        $pdo = coneccion();
        $stmt = $pdo->prepare("
            SELECT i.id, i.nombre, i.iso_code 
            FROM idiomas i
            INNER JOIN series_idiomas_subtitulos sis ON i.id = sis.idioma_id
            WHERE sis.serie_id = :serie_id
            ORDER BY i.nombre ASC
        ");
        $stmt->execute([":serie_id" => $serieId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/Idioma.php';
        $idiomas = [];
        foreach ($rows as $row) {
            $idiomas[] = new Idioma(
                (int)$row["id"],
                $row["nombre"],
                $row["iso_code"]
            );
        }
        return $idiomas;
    }

    /**
     * Agregar un idioma de subtítulos a una serie
     */
    public static function addIdiomaSubtitulo(int $serieId, int $idiomaId): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("INSERT IGNORE INTO series_idiomas_subtitulos (serie_id, idioma_id) VALUES (:serie_id, :idioma_id)");
        return $stmt->execute([
            ":serie_id" => $serieId,
            ":idioma_id" => $idiomaId
        ]);
    }

    /**
     * Eliminar un idioma de subtítulos de una serie
     */
    public static function removeIdiomaSubtitulo(int $serieId, int $idiomaId): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("DELETE FROM series_idiomas_subtitulos WHERE serie_id = :serie_id AND idioma_id = :idioma_id");
        return $stmt->execute([
            ":serie_id" => $serieId,
            ":idioma_id" => $idiomaId
        ]);
    }

    // ===== Obtener último ID insertado =====
    
    /**
     * Obtener el último ID insertado después de create()
     */
    public static function getLastInsertId(): int {
        $pdo = coneccion();
        return (int)$pdo->lastInsertId();
    }
}

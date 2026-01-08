<?php
require_once __DIR__ . '/../config.php';

class Idioma {
    private $id;
    private $nombre;
    private $isoCode;

    public function __construct($id, $nombre, $isoCode) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->isoCode = $isoCode;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getIsoCode() {
        return $this->isoCode;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setIsoCode($isoCode) {
        $this->isoCode = $isoCode;
    }

    // CRUD - Usando conexión centralizada de config.php
    public static function getAll(): array {
        $pdo = coneccion();
        $stmt = $pdo->query("SELECT id, nombre, iso_code FROM idiomas ORDER BY nombre ASC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public static function getById(int $id): ?Idioma {
        $pdo = coneccion();
        $stmt = $pdo->prepare("SELECT id, nombre, iso_code FROM idiomas WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;
        return new Idioma(
            (int)$row["id"],
            $row["nombre"],
            $row["iso_code"]
        );
    }

    public static function create(string $nombre, string $isoCode): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("INSERT INTO idiomas (nombre, iso_code) VALUES (:nombre, :iso_code)");
        return $stmt->execute([
            ":nombre" => $nombre,
            ":iso_code" => $isoCode
        ]);
    }

    public static function update(int $id, string $nombre, string $isoCode): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("UPDATE idiomas SET nombre = :nombre, iso_code = :iso_code WHERE id = :id");
        return $stmt->execute([
            ":id" => $id,
            ":nombre" => $nombre,
            ":iso_code" => $isoCode
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("DELETE FROM idiomas WHERE id = :id");
        return $stmt->execute([":id" => $id]);
    }

    // Método adicional para buscar por ISO code
    public static function getByIsoCode(string $isoCode): ?Idioma {
        $pdo = coneccion();
        $stmt = $pdo->prepare("SELECT id, nombre, iso_code FROM idiomas WHERE iso_code = :iso_code");
        $stmt->execute([":iso_code" => $isoCode]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;
        return new Idioma(
            (int)$row["id"],
            $row["nombre"],
            $row["iso_code"]
        );
    }
}

<?php
require_once __DIR__ . '/../config.php';

class Actor {
    private $id;
    private $nombre;
    private $apellidos;
    private $fechaNacimiento;
    private $nacionalidad;

    public function __construct($id, $nombre, $apellidos, $fechaNacimiento, $nacionalidad) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->nacionalidad = $nacionalidad;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    public function getNacionalidad() {
        return $this->nacionalidad;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setNacionalidad($nacionalidad) {
        $this->nacionalidad = $nacionalidad;
    }

    // CRUD - Usando conexión centralizada de config.php
    public static function getAll(): array {
        $pdo = coneccion();
        $stmt = $pdo->query("SELECT id, nombre, apellidos, fecha_nacimiento, nacionalidad FROM actores ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public static function getById(int $id): ?Actor {
        $pdo = coneccion();
        $stmt = $pdo->prepare("SELECT id, nombre, apellidos, fecha_nacimiento, nacionalidad FROM actores WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;
        return new Actor(
            (int)$row["id"],
            $row["nombre"],
            $row["apellidos"],
            $row["fecha_nacimiento"],
            $row["nacionalidad"]
        );
    }

    public static function create(string $nombre, string $apellidos, string $fechaNacimiento, string $nacionalidad): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("INSERT INTO actores (nombre, apellidos, fecha_nacimiento, nacionalidad) VALUES (:nombre, :apellidos, :fecha_nacimiento, :nacionalidad)");
        return $stmt->execute([
            ":nombre" => $nombre,
            ":apellidos" => $apellidos,
            ":fecha_nacimiento" => $fechaNacimiento,
            ":nacionalidad" => $nacionalidad
        ]);
    }

    public static function update(int $id, string $nombre, string $apellidos, string $fechaNacimiento, string $nacionalidad): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("UPDATE actores SET nombre = :nombre, apellidos = :apellidos, fecha_nacimiento = :fecha_nacimiento, nacionalidad = :nacionalidad WHERE id = :id");
        return $stmt->execute([
            ":id" => $id,
            ":nombre" => $nombre,
            ":apellidos" => $apellidos,
            ":fecha_nacimiento" => $fechaNacimiento,
            ":nacionalidad" => $nacionalidad
        ]);
    }

    public static function delete(int $id): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("DELETE FROM actores WHERE id = :id");
        return $stmt->execute([":id" => $id]);
    }
}

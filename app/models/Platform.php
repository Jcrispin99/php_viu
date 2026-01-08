<?php

require_once __DIR__ . '/../config.php';

class Platform {
    private $id;
    private $name;

    public function __construct($idPlatform, $namePlatform) {
        $this->id = $idPlatform;
        $this->name = $namePlatform;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public static function getAll(): array {
        $pdo = coneccion();
        $stmt = $pdo->query("SELECT id, name FROM platforms ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $platforms = [];
        foreach ($rows as $row) {
            $platforms[] = new Platform((int)$row["id"], $row["name"]);
        }
        return $platforms;
    }

    public static function getById(int $id): ?Platform {
        $pdo = coneccion();
        $stmt = $pdo->prepare("SELECT id, name FROM platforms WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;
        return new Platform((int)$row["id"], $row["name"]);
    }

    public static function create(string $name): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("INSERT INTO platforms (name) VALUES (:name)");
        return $stmt->execute([":name" => $name]);
    }

    public static function update(int $id, string $name): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("UPDATE platforms SET name = :name WHERE id = :id");
        return $stmt->execute([":id" => $id, ":name" => $name]);
    }

    public static function delete(int $id): bool {
        $pdo = coneccion();
        $stmt = $pdo->prepare("DELETE FROM platforms WHERE id = :id");
        return $stmt->execute([":id" => $id]);
    }
}
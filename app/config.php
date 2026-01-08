<?php

const DB_SERVER = "127.0.0.1";
const DB_NAME = "viu_php";
const DB_USER = "root";
const DB_PASS = "";

/**
 * Retorna una instancia singleton de PDO
 * Se conecta solo una vez y reutiliza la misma conexión
 */
function coneccion(): PDO {
    static $pdo = null;
    
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    
    return $pdo;
}

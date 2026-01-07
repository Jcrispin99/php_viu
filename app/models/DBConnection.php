<?php
    class DBConnection{

        private static $mysqli;
        private static $init = false;

        public static function initConnectionDb(){ //Conexión a la db
        $db_host = 'localhost';
        $db_user = 'root';
        $db_password = 'root';
        $db_db = 'backend_actividad1';

        $mysqli = @new mysqli(
            $db_host,
            $db_user,
            $db_password,
            $db_db
        );
        if($mysqli->connect_error){
            die('Errno: '.$mysqli->connect_errno
            .'<br>'.'Error: '
            .$mysqli->connect_error);
        }

        $mysqli->set_charset('');
        self::$mysqli = $mysqli;
        return $mysqli;
        }
    }
?>

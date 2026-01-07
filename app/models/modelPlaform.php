<?php

require_once('../../models/DBConnection.php');

class Platform 
{
    private $id;
    private $name;

// el =null permite definir que si no se pasa un parámetro, su valor será null, o que el valor pasado puede ser null

    public function __construct($idPlatform = null, $namePlatform = null)
    {
        // la siguiente comprobación se realiiza para verificar si es nulo, 
        // Si no es nulo se agrega, caso contrario se genera un modelo vacío
        if(is_null(value: $idPlatform)){
        $this->id = $idPlatform;
        }

        if(is_null(value:$namePlatform)){
        $this->name = $namePlatform;
        }

    }

    public function getId(): mixed {
        return $this->id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function getName(): mixed {
        return $this->name;
    }

    public function setName($name): void {
        $this->name = $name;
    }


    //Función para sacar los datos de la db
    public function getAll(){
        //Primero se genera la conección con la db
        //Se realiza la conexión a la db haciendo referencia a la clase estática
        //DBConnection :: initConnectionDb()
        //Una función o estática es un método que pertenece a la clase, no a los objetos creados
        //a partir de ella
        $mysqli = DBConnection :: initConnectionDb();
        $query = $mysqli -> query("SELECT * FROM platforms");
        $listData = [];

        foreach ($query as $item){
            $itemObject = new Platform($item['id'], $item['name']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();
        return $listData;
    }

    function store(){
        $platformCreated = false;
        $mysqli = DBConnection :: initConnectionDb();
        
        // TODO: Comprobar que no existe otra plataforma con el mismo nombre antes de crear
        if ($resultInsert = $mysqli->query("INSERT INTO platforms (name) VALUES ('$this->name')")){
            $platformCreated = true;
        }

        $mysqli->close();
        return $platformCreated;

    }

}
?>

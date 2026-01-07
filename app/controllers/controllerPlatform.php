<?php
    require_once('../../backendActividad1/models/Platform.php');
    
    function listPlatforms(): array {
        $model = new Platform();
        $platformList = $model->getAll();
        $platformObjectArray=[];

        foreach ($platformList as $plaformItem){
            $platformObject = new Platform(idPlatform: $$plaformItem->getID(), namePlatform: $plaformItem->getName());
            array_push(array: $platformObjectArray, values: $platformObject);
        }

        return $platformObjectArray;
    }

    function storePlatform($platformName):mixed{
        $newPlatform = new Platform(idPlatform: null, namePlatform:$platformName);
        $platformCreated = $newPlatform -> store();
        return $platformCreated;
    }

?>

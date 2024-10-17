<?php 

function data_submitted() {
    $_AAux = array();
    if (!empty($_POST)) {
        $_AAux = $_POST;
    } elseif (!empty($_GET)) {
        $_AAux = $_GET;
    }
    if (!empty($_FILES)) {
        $_AAux = array_merge($_AAux, $_FILES);
    }
    if (count($_AAux)) {
        foreach ($_AAux as $indice => $valor) {
            if ($valor === "") {
                $_AAux[$indice] = 'null';
            }
        }
    }
    return $_AAux;
}

function dismount($object) {
    $reflectionClass = new ReflectionClass(get_class($object));
    $array = array();
    foreach ($reflectionClass->getProperties() as $property) {
        $property->setAccessible(true);
        $array[$property->getName()] = $property->getValue($object);
        $property->setAccessible(false);
    }
    return $array;
}

function convert_array($param) {
    $_AAux = array();
    if(!empty($param)){
        if (count($param)) {
            foreach($param as $obj){
                    array_push($_AAux, dismount($obj));
                }
            }
        }
        return $_AAux;
    }


// auto load register para agregar los repositorios de forma dinamica.
spl_autoload_register(function ($class_name){
    //echo($class_name);
    //echo($_SESSION['ROOT']); 
    $directorys = array(
        $GLOBALS['ROOT'].'/Modelo/',
        $GLOBALS['ROOT'].'/Modelo/TP4/',
        $GLOBALS['ROOT'].'/Modelo/TP5/',
        $GLOBALS['ROOT'].'/Modelo/TP4/Conector/',
        $GLOBALS['ROOT'].'/Modelo/TP5/Conector/',
        $GLOBALS['ROOT'].'/Control/TP1/',
        $GLOBALS['ROOT'].'/Control/TP2/',
        $GLOBALS['ROOT'].'/Control/TP3/',
        $GLOBALS['ROOT'].'/Control/TP4/',
        $GLOBALS['ROOT'].'/Control/TP5/',
        $GLOBALS['ROOT'].'/Control/clasesUtiles/',
        $GLOBALS['ROOT'].'/Util/',);
    foreach($directorys as $directory){
       // echo "Buscando archivo: $class_name<br>";
       //echo $GLOBALS['ROOT'];
        if(file_exists($directory.$class_name .'.php')){
            //echo "se incluyo".$directory.$class_name . '.php';
            require_once($directory.$class_name .'.php');
            return;
        }
    }
});

?>

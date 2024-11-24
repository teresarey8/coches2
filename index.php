<?php
//Se encarga de enrutar las solicitudes y llamar al método adecuado del controlador (CocheController)

//1.Aquí se incluyen los archivos de clases necesarias

require("./model/Coche.php");
require("./controller/CocheController.php");

//2.Se crea una instancia del controlador CocheController, que manejará las solicitudes y dirigirá las acciones en función de la ruta.
$controller = new CocheController;

//3.$home define la URL base de la aplicación. Esto permite a la aplicación saber qué parte de la URL debe eliminarse para obtener la ruta solicitada.
$home = "/proyectos/coches2/index.php/";

//3.Se elimina $home de la URL actual ($_SERVER["REQUEST_URI"]) para obtener solo la parte de la URL relevante para la aplicación, guardándola en $ruta.
$ruta = str_replace($home, "", $_SERVER["REQUEST_URI"]);

//4.Aquí se convierte la ruta en un array, dividiéndola por cada / usando explode("/"). La función array_filter() elimina elementos vacíos del array,
// de modo que solo se incluyan los segmentos de la ruta que contienen texto.
$array_ruta = array_filter(explode("/", $ruta));

//5.Este bloque se encarga de determinar qué acción debe ejecutarse en función de los elementos en $array_ruta
//Condición ver: Si el primer elemento ($array_ruta[0]) es "ver" y el segundo ($array_ruta[1]) es un número 
//(representando el ID del coche), se llama al método ver del controlador con el ID proporcionado. 
//Esto corresponde a mostrar los detalles de un coche específico.

if (isset($array_ruta[0]) && $array_ruta[0] == "ver" && is_numeric($array_ruta[1])) {

    //Llamo al método ver pasándole la clave que me están pidiendo
    $controller->ver($array_ruta[1]);
} else if (isset($array_ruta[0]) && $array_ruta[0] == "borrar" && is_numeric($array_ruta[1])) {

    $controller->borrar($array_ruta[1]); // Llama al método borrar del controlador

} else if (isset($array_ruta[0]) && $array_ruta[0] == 'guardarCoche' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->guardarCoche();

} else if ($array_ruta[0] == "alta") {

    $controller->mostrarFormularioAlta();

} else if (isset($array_ruta[0]) && $array_ruta[0] == 'guardarCocheE' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->guardarCocheE();

} else if (isset($array_ruta[0]) && $array_ruta[0] == "editar" && is_numeric($array_ruta[1])) {

    //Llamo al método ver pasándole la clave que me están pidiendo
    $controller->editar($array_ruta[1]);

} else if (isset($array_ruta[0]) && $array_ruta[0] == "sancionar" && is_string($array_ruta[1])) {

    $controller->sancionar(trim($array_ruta[1]));

} else if (isset($array_ruta[0]) && $array_ruta[0] == "pintar" && isset($array_ruta[1]) && is_string($array_ruta[1]) && isset($array_ruta[2]) && is_string($array_ruta[2])) {
    $controller->pintar($array_ruta[1], $array_ruta[2]);
} else {
    $controller->index();
}


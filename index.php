<?php


header('Content-Type: application/json');

// Obtener la ruta de la URL solicitada
$ruta = $_SERVER['REQUEST_URI'];

// Dividir la ruta en partes
$partesRuta = explode('/', $ruta);

// Eliminar elementos vacíos o nulos
$partesRuta = array_filter($partesRuta);

// Obtener el controlador y la acción solicitados
$controlador = isset($partesRuta[2]) ? $partesRuta[2] : 'inicio';
$accion = isset($partesRuta[3]) ? $partesRuta[3] : 'index';
$id = isset($partesRuta[4]) ? $partesRuta[4] : -1;


// Incluir el archivo del controlador correspondiente
$archivoControlador = 'Controllers/' . ucfirst($controlador) . 'Controller.php';


if (file_exists($archivoControlador)) {

    require_once $archivoControlador;
} else {
    // Controlador no encontrado, mostrar un error o redireccionar a una página de error
    die('Controlador no encontrado');
}

// Crear una instancia del controlador
$nombreClase ='Controller\\'. ucfirst($controlador) . 'Controller';

$controladorInstancia = new $nombreClase();

// Llamar a la acción correspondiente en el controlador
if (method_exists($controladorInstancia, $accion)) {
    $controladorInstancia->$accion($id);
} else {
    // Acción no encontrada, mostrar un error o redireccionar a una página de error
    die('Acción no encontrada');
}

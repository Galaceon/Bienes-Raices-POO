<?php

define('TEMPLATES_URL', __DIR__ . '/templates'); //nombre de la constante y su ruta absoluta, gracias a __DIR__
define('FUNCIONES_URL', __DIR__ . 'funciones.php'); // __DIR__ : Da la ruta absoluta de este archivo, C:\users\anton\Escritorio\bienesraices\includes\funciones.php

function incluirTemplate( string $nombre, bool $inicio = false) {
    include  TEMPLATES_URL . "/$nombre.php";
}

function estaAutenticado() : bool {
    session_start();

    $auth = $_SESSION['login'];
    if($auth) {
        return true;
    }

    return false;
}
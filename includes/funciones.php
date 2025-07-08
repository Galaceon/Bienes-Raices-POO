<?php

define('TEMPLATES_URL', __DIR__ . '/templates'); //nombre de la constante y su ruta absoluta, gracias a __DIR__
define('FUNCIONES_URL', __DIR__ . 'funciones.php'); // __DIR__ : Da la ruta absoluta de este archivo, C:\users\anton\Escritorio\bienesraices\includes\funciones.php
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');
define('CARPETA_FOTOS', __DIR__ . '/../fotos/');

function incluirTemplate( string $nombre, bool $inicio = false) {
    include  TEMPLATES_URL . "/$nombre.php";
}

function estaAutenticado() : bool {
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /');
    }

    return false;
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo de contenido
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);
}

// Muestra los mensajes
function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch($codigo) {
        case 1:
            $mensaje = 'Creado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }

    return $mensaje;
}
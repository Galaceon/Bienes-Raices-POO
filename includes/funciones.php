<?php

define('TEMPLATES_URL', __DIR__ . '/templates'); //nombre de la constante y su ruta absoluta, gracias a __DIR__
define('FUNCIONES_URL', __DIR__ . 'funciones.php'); // __DIR__ : Da la ruta absoluta de este archivo, C:\users\anton\Escritorio\bienesraices\includes\funciones.php
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

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
<?php 
// Archivo contenedor de rutas, para usarlas posteriormente 

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la DB
$db = conectarDB();

use App\Propiedad;

Propiedad::setDB($db);
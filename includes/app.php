<?php // Archivo contenedor de rutas, para usarlas posteriormente 

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

use App\Propiedad;

$propiedad = new Propiedad;

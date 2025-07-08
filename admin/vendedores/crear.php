<?php
require '../../includes/app.php';
use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;
estaAutenticado();

$vendedor = new Vendedor();

// Array con mensajes de errores
$errores = Vendedor::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear una nueva instancia
    $vendedor = new Vendedor($_POST['vendedor']);

    //Generar un nombre único para imagen
    $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";

    //Setear la imagen
    // Realiza un resize a la imagen con intervention
    if($_FILES['vendedor']['tmp_name']['imagen']) {
        $manager = new Image(Driver::class);
        $imagen = $manager->read($_FILES['vendedor']['tmp_name']['imagen'])->cover(800, 600);
        $vendedor->setImagen($nombreImagen);
    }

    // Validar que no haya campos vacios
    $errores = $vendedor->validar();

    //No hay errores
    if(empty($errores)) {
        /** SUBIDA DE ARCHIVOS */
        if(!is_dir(CARPETA_FOTOS)){
            mkdir(CARPETA_FOTOS);
        }

        // Guardar la imagen en el Servidor
        $imagen->save(CARPETA_FOTOS . $nombreImagen);

        $vendedor->guardar();
    }
}

// Header
incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Registrar vendedor</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!-- Creacion en el DOM mensajes de error por cada elm en el array de $error-->
        <?php foreach($errores as $error) { ?>
            <div class="alerta error"> <?php echo $error ?> </div>
        <?php } ?>

        <form class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">

            <?php include '../../includes/templates/formulario_vendedores.php' ?>

            <input type="submit" value="Registrar Vendedor" class="boton boton-verde">

        </form>
    </main>

<!-- Footer -->
<?php incluirTemplate('footer'); ?>
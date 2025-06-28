<?php

use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

    require '../../includes/app.php';
    $auth = estaAutenticado();


    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /admin');
    }

    // Base de datos
    $db = conectarDB();

    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    // Consulta para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    // Array con mensajes de errores
    $errores = Propiedad::getErrores();

    //Ejecutar el código despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Asignar los atributos
        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);

        // Asignar files hacia una variable
        $imagen = $_FILES['propiedad']['tmp_name']['imagen'];

        // Validacion
        $errores = $propiedad->validar();
        debuguear($propiedad);
    
        // SUBIDA DE ARCHIVOS
        // Genera un nombre único
        $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";

        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $manager = new Image(Driver::class);
            $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
            $propiedad->setImagen($nombreImagen);
        }



        // Revisar que el arreglo de errores este vacio para enviar la info a la db
        if(empty($errores)) {
            // Almacenar la imagen
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }

            $propiedad->guardar();
        }
    }



?>


<?php
    // Header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!-- Creacion en el DOM mensajes de error por cada elm en el array de $error-->
        <?php foreach($errores as $error) { ?>
            <div class="alerta error"> <?php echo $error ?> </div>
        <?php } ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

<!-- Footer -->
<?php incluirTemplate('footer'); ?>
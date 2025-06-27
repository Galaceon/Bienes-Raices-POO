<?php
    require '../../includes/app.php';

    // Importo la clase Propiedad
    use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

    // AUTENTIFICACION DE USUARIO
    estaAutenticado();

    // Base de datos
    $db = conectarDB();

    $propiedad = new Propiedad;

    // Consulta para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);


    // Array con mensajes de errores
    $errores = Propiedad::getErrores();


    //Ejecutar el código despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $propiedad = new Propiedad($_POST);

        //Generar un nombre único para imagen
        $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";
        if($_FILES['imagen']['tmp_name']) {
            $manager = new Image(Driver::class);
            $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
            $propiedad->setImagen($nombreImagen);
        }

        $errores = $propiedad->validar();

        // Revisar que el arreglo de errores este vacio para enviar la info a la db
        if(empty($errores)) {
            /** SUBIDA DE ARCHIVOS */
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            // Guardar la imagen en el Servidor
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);

            $propiedad->guardar();
            if($resultado) {
                // Redireccionar al usuario
                header("Location: /admin?resultado=1");
            }
        }
    }

?>


<?php
    // Header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!-- Creacion en el DOM mensajes de error por cada elm en el array de $error-->
        <?php foreach($errores as $error) { ?>
            <div class="alerta error"> <?php echo $error ?> </div>
        <?php } ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">

            <?php include '../../includes/templates/formulario_propiedades.php' ?>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">

        </form>
    </main>

<!-- Footer -->
<?php incluirTemplate('footer'); ?>
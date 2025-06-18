<?php
    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth) {
        header('location: /'); // 4 NOTAS
    }


    // Validar la URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /admin');
    }

    // Base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();

    // Obtener los datos de la propiedad
    $consulta = "SELECT * FROM propiedades WHERE id = $id";
    $resultado = mysqli_query($db, $consulta);
    $propiedad = mysqli_fetch_assoc($resultado);

    // Consulta para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);


    // Array con mensajes de errores
    $errores = [];

    // Variables vacia para el name = '$variable' de los inputs
    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento']; 
    $vendedorId = $propiedad['vendedorId'];
    $imagenPropiedad = $propiedad['imagen'];

    //Ejecutar el código despues de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {


        // Variables llenas para cuando el name = '$variable' sea rellenado y se guarde lo que escribio el cliente
        $titulo = mysqli_real_escape_string($db, $_POST["titulo"]);
        $precio = mysqli_real_escape_string($db, $_POST["precio"]);
        $descripcion = mysqli_real_escape_string($db, $_POST["descripcion"]);
        $habitaciones = mysqli_real_escape_string($db, $_POST["habitaciones"]);
        $wc = mysqli_real_escape_string($db, $_POST["wc"]);
        $estacionamiento = mysqli_real_escape_string($db, $_POST["estacionamiento"]);
        $vendedorId = mysqli_real_escape_string($db, $_POST["vendedor"]);
        $creado = date('Y/m/d');

        // Asignar files hacia una variable
        $imagen = $_FILES['imagen'];


        // Verificacion de la existencia del contenido (mensajes a imprimir en DOM en caso de error)
        if(!$titulo) {
            $errores[] = "Debes añadir un titulo";
        }
        if(!$precio || $precio <= 0) {
            $errores[] = "Debes añadir un precio valido";
        }
        if(strlen($descripcion) < 50) {
            $errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }
        if(!$habitaciones) {
            $errores[] = "Debes añadir el numero de habitaciones";
        }
        if(!$wc) {
            $errores[] = "Debes añadir el numero de baños";
        }
        if(!$estacionamiento) {
            $errores[] = "Debes añadir el numero de estacionamientos";
        }
        if(!$vendedorId) {
            $errores[] = "Debes añadir un vendedor";
        }


        //Validar por tamaño (1mb máximo) 
        $medida = 1000 * 1000;
        if($imagen['size'] > $medida) {
            $errores[] = 'La imagen es muy pesada';
        }


        // Revisar que el arreglo de errores este vacio para enviar la info a la db
        if(empty($errores)) {
            //Crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            //Nombre de imagen vacio para agregarselo en la siguiente comprobacion
            $nombreImagen = ''; 

            /** SUBIDA DE ARCHIVOS */

            // Borrar Imagenes Repetidas si se sube nueva imagen, si no se deja la misma
            if($imagen['name']) { 
                //Eliminar la imagen previa
                unlink($carpetaImagenes . $propiedad['imagen']);

                //Generar un nombre único
                $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";

                //Subir la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen); 
            } else {
                // Dejar misma imagen
                $nombreImagen = $propiedad['imagen'];
            }



            //Actualizar en la base de datos
            $query = "UPDATE propiedades SET titulo = '$titulo', precio = '$precio', imagen = '$nombreImagen', descripcion = '$descripcion', habitaciones = '$habitaciones', wc = '$wc', 
            estacionamiento = '$estacionamiento', vendedorId = '$vendedorId' WHERE id = $id ";

            // echo $query | Inserción final en la DB
            $resultado = mysqli_query($db, $query);

            if($resultado) {
                // Redireccionar al usuario
                header("Location: /admin?resultado=2");
            }
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
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id=precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpg, image/png, image/jpeg" name="imagen"> 
                <!-- El input de imagen no se debe autcompletar en actualizar, trae problemas de seguridad, en cambio le 
                 pondremos la imagen actual de esa propiedad/id -->
                <img src="/imagenes/<?php echo $imagenPropiedad;?>" class="imagen-small">
                
                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion"> <?php echo $descripcion; ?> </textarea>
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamientos:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor">
                    <option value="">-- Seleccione --</option>
                    <!-- Bucle para insertar un option por cada vendedor de la DB -->
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"> 
                            <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>

<!-- Footer -->
<?php incluirTemplate('footer'); ?>
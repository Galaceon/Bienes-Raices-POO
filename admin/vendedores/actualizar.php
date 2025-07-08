<?php
require '../../includes/app.php';
use App\Vendedor;
estaAutenticado();

// Validar que sea un ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) {
    header('Location: /admin');
}

// Obtener el array del vendedor desde la DB
$vendedor = Vendedor::find($id);

// Array con mensajes de errores
$errores = Vendedor::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asignar los valores
    $args = $_POST['vendedor'];

    // Sincronizar objeto en memoria con lo que el usuario escribio
    $vendedor->sincronizar($args);

    // Validación
    $errores = $vendedor->validar();

    if(empty($errores)) {
        $vendedor->guardar();
    }
}


// Header
incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar vendedor</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!-- Creacion en el DOM mensajes de error por cada elm en el array de $error-->
        <?php foreach($errores as $error) { ?>
            <div class="alerta error"> <?php echo $error ?> </div>
        <?php } ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">

            <?php include '../../includes/templates/formulario_vendedores.php' ?>

            <input type="submit" value="Guardar Cambios" class="boton boton-verde">

        </form>
    </main>

<!-- Footer -->
<?php incluirTemplate('footer'); ?>
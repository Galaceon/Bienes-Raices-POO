<?php
    // Base de Datos
    require 'includes/config/database.php';
    $db = conectarDB();

    // Obtener ID de cada Propiedad
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('location: index.php');
    }

    // Consulta a la DB
    $query = "SELECT * FROM propiedades WHERE id = $id";
    $resultadoConsulta = mysqli_query($db, $query);
    $propiedad = mysqli_fetch_assoc($resultadoConsulta);

    // Header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1> <?php echo $propiedad['titulo']; ?> </h1>

        <img src="imagenes/<?php echo $propiedad['imagen'] ?>" alt="anuncio image">

        <p class="precio"><?php echo $propiedad['precio']; ?></p>

        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_wc.svg">
                <p><?php echo $propiedad['wc']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg">
                <p><?php echo $propiedad['estacionamiento']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg">
                <p><?php echo $propiedad['habitaciones']; ?></p>
            </li>
        </ul>

        <p> <?php echo $propiedad['descripcion']; ?> </p>
    </main>

<?php incluirTemplate('footer'); ?>
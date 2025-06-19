<?php
    declare(strict_types= 1);

    require 'includes/app.php';
    incluirTemplate('header');
?>

    <section class="contenedor seccion">
        <h1>Anuncios</h1>
    </section>

    <main class="anuncios contenedor">
        <h2>Casas y Departamentos en Venta</h2>
    
        <?php
            $limite = 9;
            include 'includes/templates/anuncios.php'; 
        ?>
    </main>

<?php incluirTemplate('footer'); ?>
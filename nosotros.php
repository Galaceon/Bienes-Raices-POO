<?php 

    require 'includes/funciones.php'; // Para hacer uso de las funciones del archivo funciones.php
    incluirTemplate('header', $inicio = true); // funcion de funciones.php, devuelve el string 'header' y un valor bool que sera usado en la función
?>

    <section class="contenedor seccion">
        <h1>Conoce Sobre Nosotros</h1>

        <div class="nosotros-secction">
            <img src="build/img/nosotros.webp" alt="nosotros-image">

            <div class="nosotros-texto">
                <blockquote>25 Años de Experiencia</blockquote>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sit molestias quaerat voluptatibus
                    dicta unde, recusandae praesentium, reiciendis dolorum iste voluptates dolore velit in. Ullam
                    dicta harum rem. Itaque, dolor perspiciatis. Lorem ipsum dolor sit, amet consectetur adipisicing
                    elit. Iusto dignissimos quasi autem impedit eaque deserunt tenetur, voluptatibus id praesentium sit
                    nam culpa eveniet, facere architecto non, exercitationem ipsum cum repellendus. Lorem ipsum dolor sit, amet
                    consectetur adipisicing elit. Eius nisi enim vitae voluptas quidem. Minima non esse molestias sit delectus nulla,
                    repellendus neque eligendi, laborum fugit nisi dolor numquam alias.
                </p>

                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum accusantium sapiente perspiciatis. Deserunt magnam
                    inventore quam cupiditate facere, corrupti, praesentium ipsum id repellat porro doloremque totam culpa in corporis
                    quas.
                </p>
            </div>
        </div>
    </section>

    <main class="contenedor seccion">
        <h1>Más Sobre Nosotros</h1>
    
        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono Seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem explicabo delectus rerum,
                    blanditiis eos laborum recusandae nisi ullam expedita impedit nesciunt quibusdam ea possimus
                    eum sint non, ab atque eligendi.
                </p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Seguridad" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem explicabo delectus rerum,
                    blanditiis eos laborum recusandae nisi ullam expedita impedit nesciunt quibusdam ea possimus
                    eum sint non, ab atque eligendi.
                </p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Seguridad" loading="lazy">
                <h3>Tiempo</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem explicabo delectus rerum,
                    blanditiis eos laborum recusandae nisi ullam expedita impedit nesciunt quibusdam ea possimus
                    eum sint non, ab atque eligendi.
                </p>
            </div>
        </div>
    </main>

<?php incluirTemplate('footer'); ?>
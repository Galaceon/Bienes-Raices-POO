<?php
    declare(strict_types= 1);

    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="blog contenedor contenido-centrado">
        <h3>Nuestro Blog</h3>
    
        <article class="entrada-blog">
            <div class="imagen">
                <img src="build/img/blog1.webp" alt="blog image">
            </div>
    
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Terraza en el techo de tu casa</h4>
                    <p>Escritorio el: <span> 20/10/2025 </span> por: <span>Admin</span> </p>
    
                    <p>
                        Consejos para construir una terraza en el techo de tu casa con los mejores
                        materiales y ahorrando dinero
                    </p>
                </a>
            </div>
        </article>
    
        <article class="entrada-blog">
            <div class="imagen">
                <img src="build/img/blog2.webp" alt="blog image">
            </div>
    
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Guía para la decoración de tu hogar</h4>
                    <p>Escritorio el: <span> 20/10/2025 </span> por: <span>Admin</span> </p>
    
                    <p>
                        Maximiza el espacio en tu hogar con esta guía, aprende a combinar muebles y colores
                        para darle vida a tu espacio
                    </p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <img src="build/img/blog3.webp" alt="blog image">
            </div>
        
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Terraza en el techo de tu casa</h4>
                    <p>Escritorio el: <span> 20/10/2025 </span> por: <span>Admin</span> </p>
        
                    <p>
                        Consejos para construir una terraza en el techo de tu casa con los mejores
                        materiales y ahorrando dinero
                    </p>
                </a>
            </div>
        </article>
        
        <article class="entrada-blog">
            <div class="imagen">
                <img src="build/img/blog4.webp" alt="blog image">
            </div>
        
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Guía para la decoración de tu hogar</h4>
                    <p>Escritorio el: <span> 20/10/2025 </span> por: <span>Admin</span> </p>
        
                    <p>
                        Maximiza el espacio en tu hogar con esta guía, aprende a combinar muebles y colores
                        para darle vida a tu espacio
                    </p>
                </a>
            </div>
        </article>
    </main>

<?php incluirTemplate('footer'); ?>
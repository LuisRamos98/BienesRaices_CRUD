<?php 
    require "includes/app.php";
    incluirTemplate("header");
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Nuestro Blog</h1>
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog1.jpg" alt="Imagen Blog1">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Guia de decoración de tu hogar</h4>
                    <p>Escrito el: <span>20/10/2021</span> por: <span>Admin</span> </p>
                    <p>
                        Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles y colores para darle vida a tu espacio
                    </p>
                </a>
            </div>
        </article> <!--Entrada Blog-->
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="image/webp">
                    <source srcset="build/img/blog2.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog2.jpg" alt="Imagen Blog2">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Guia de decoración de tu hogar</h4>
                    <p>Escrito el: <span>20/10/2021</span> por: <span>Admin</span> </p>
                    <p>
                        Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles y colores para darle vida a tu espacio
                    </p>
                </a>
            </div>
        </article> <!--Entrada Blog-->
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog3.webp" type="image/webp">
                    <source srcset="build/img/blog3.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog3.jpg" alt="Imagen Blog3">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Guia de decoración de tu hogar</h4>
                    <p>Escrito el: <span>20/10/2021</span> por: <span>Admin</span> </p>
                    <p>
                        Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles y colores para darle vida a tu espacio
                    </p>
                </a>
            </div>
        </article> <!--Entrada Blog-->
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog4.webp" type="image/webp">
                    <source srcset="build/img/blog4.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog4.jpg" alt="Imagen Blog1">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Guia de decoración de tu hogar</h4>
                    <p>Escrito el: <span>20/10/2021</span> por: <span>Admin</span> </p>
                    <p>
                        Maximiza el espacio en tu hogar con esta guia, aprende a combinar muebles y colores para darle vida a tu espacio
                    </p>
                </a>
            </div>
        </article> <!--Entrada Blog-->
    </main>

<?php 
    incluirTemplate("footer");
?>
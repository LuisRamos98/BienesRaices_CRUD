<?php 
    require "includes/app.php";
    incluirTemplate("header");
?>

    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>
        <div class="nosotros">
            <picture>
                <source src="build/img/nosotros.webp" type="image/webp">
                <source src="build/img/nosotros.jpg" type="image/jpeg">
                <img loading="lazy" src="build/img/nosotros.jpg" alt="Imagen Nosostros">
            </picture>
            <div class="nosotros-informacion">
                <blockquote>25 Años de Experiencia</blockquote>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloribus id fugiat, fugit impedit ad corrupti consectetur? Accusamus, corporis cupiditate quisquam recusandae perspiciatis, ratione amet aliquid praesentium repellat, animi id ducimus! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perferendis perspiciatis culpa beatae deserunt ducimus a ad qui. In laboriosam eaque ratione! Nam vitae perspiciatis aliquam nulla eaque quidem nisi quis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse inventore accusamus odio cupiditate voluptate impedit in, dicta deleniti accusantium aut quaerat explicabo. Accusantium doloremque voluptatum quos eveniet obcaecati voluptatem quod.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam error quae corporis, officia harum mollitia fuga facere, nulla dolores nemo aliquid quo necessitatibus doloribus neque ad commodi, sit accusantium velit?</p>
            </div>
        </div>
    </main>

    <section class="contenedor seccion">
        <h1>Más sobre nosotros</h1>
        <div class="icono-nosotros">
            <div class="icono">
                <img src="build/img//icono1.svg" alt="Icono Seguridad" loading="lazy">
                <h3>Seguridad</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, quasi maiores officia magni reprehenderit sed repellendus ducimus culpa aut, enim ea ipsa amet! Assumenda magnam tempore obcaecati labore eveniet itaque?</p>
            </div>
            <div class="icono">
                <img src="build/img//icono2.svg" alt="Icono Precio" loading="lazy">
                <h3>Precio</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, quasi maiores officia magni reprehenderit sed repellendus ducimus culpa aut, enim ea ipsa amet! Assumenda magnam tempore obcaecati labore eveniet itaque?</p>
            </div>
            <div class="icono">
                <img src="build/img//icono3.svg" alt="Icono Tiempo" loading="lazy">
                <h3>A Tiempo</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, quasi maiores officia magni reprehenderit sed repellendus ducimus culpa aut, enim ea ipsa amet! Assumenda magnam tempore obcaecati labore eveniet itaque?</p>
            </div>
        </div>
    </section>

<?php 
    incluirTemplate("footer");
?>
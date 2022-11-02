<?php 

    //conexion a la bd
    $db = conectarDB();

    
    //consulta
    $query = "SELECT * FROM propiedades LIMIT ${limite}";
    
    //resultado
    $propiedades = mysqli_query($db,$query);
?>


<div class="contenedor-anuncios">
    <?php while($propiedad = mysqli_fetch_assoc($propiedades)): ?>
        <div class="anuncio">
            <img src="imagenes/<?php echo $propiedad["imagen"]?>" alt="Imagen Anuncio1">

            <div class="contenido-anuncios">
                <h3><?php echo $propiedad["titulo"]?></h3>
                <p><?php echo $propiedad["descripcion"]?></p>
                <p class="precio"><?php echo $propiedad["precio"]?></p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono_wc">
                        <p><?php echo $propiedad["wc"]?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono_estacionamiento">
                        <p><?php echo $propiedad["estacionamiento"]?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono_dormitorio">
                        <p><?php echo $propiedad["habitaciones"]?></p>
                    </li>
                </ul>
                <a href="anuncio.php?id=<?php echo $propiedad["id"]?>" class="boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div><!--CONTENIDO ANUNCIO-->
        </div><!--ANUNCIO-->
    <?php endwhile; ?>
</div><!--CONTENEDOR DE ANUNCIOS-->

<?php

//cierre de la base de datos
mysqli_close($db);

?>
<?php 

    use App\Propiedad;

    if($_SERVER["SCRIPT_NAME"]=="/index.php") {
        $propiedades = Propiedad::get(3);
    } else {
        $propiedades = Propiedad::all(); 
    }
?>


<div class="contenedor-anuncios">
    <?php foreach($propiedades as $propiedad): ?>
        <div class="anuncio">
            <img src="imagenes/<?php echo $propiedad->imagen?>" alt="Imagen Anuncio1">

            <div class="contenido-anuncios">
                <h3><?php echo $propiedad->titulo?></h3>
                <p><?php echo $propiedad->descripcion?></p>
                <p class="precio"><?php echo $propiedad->precio?></p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono_wc">
                        <p><?php echo $propiedad->wc?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono_estacionamiento">
                        <p><?php echo $propiedad->estacionamiento?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono_dormitorio">
                        <p><?php echo $propiedad->habitaciones?></p>
                    </li>
                </ul>
                <a href="anuncio.php?id=<?php echo $propiedad->id?>" class="boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div><!--CONTENIDO ANUNCIO-->
        </div><!--ANUNCIO-->
    <?php endforeach; ?>
</div><!--CONTENEDOR DE ANUNCIOS-->


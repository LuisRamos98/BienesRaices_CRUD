<?php 


    $id = $_GET["id"];
    $id = filter_var($id,FILTER_VALIDATE_INT);

    if (!$id) {
        header("Location: /");
    }

    //LLAMAMOS A LA BD
    require "includes/config/database.php";
    $db = conectarDB();

    //CONSULTA
    $query = "SELECT * FROM propiedades WHERE id = ${id} ";
    $resultado = mysqli_query($db,$query);

    if (!$resultado->num_rows) {
        header("Location: /");
    }

    //RESULTADO
    $propiedad = mysqli_fetch_assoc($resultado);

    require "includes/funciones.php";
    incluirTemplate("header");
?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad["titulo"]?></h1>
        <img loading="lazy" src="/imagenes/<?php echo $propiedad["imagen"]?>" alt="Imagen destacada">
        <div class="resumen-propiedad">
            <p class="precio">$ <?php echo $propiedad["precio"]?></p>
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
            <p>
                <?php echo $propiedad["descripcion"]?>
            </p>
       </div>
    </main>


<?php 
    mysqli_close($db);
    incluirTemplate("footer");
?>
<?php 
    
    //INICIADO SESSION

    use App\Propiedad;
use App\Vendedor;

    require "../includes/app.php";
    estaAutenticado();

    //OBTENER TODAS LAS PROPIEDADES
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    debugear($vendedores);

    $resultado = $_GET["resultado"]??null;
    // var_dump($resultado); 

    //verificar que haga click el metodo post
    // if($_SERVER ==)
    if($_SERVER["REQUEST_METHOD"]==="POST") {
        $id = $_POST["id"]; 
        $id = filter_var($id,FILTER_VALIDATE_INT);

        if ($id) {
            $propiedad = Propiedad::find($id);
            $propiedad->eliminar();
        }
    }

    incluirTemplate("header");
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raíces</h1>
        <?php if(intval($resultado)===1):?>
                <p class="alerta exito"><?php echo 'Anuncio Creado Correctamente' ?></p>
        <?php elseif(intval($resultado)===2):?>
            <p class="alerta exito"><?php echo 'Anuncio Actualizado Correctamente' ?></p>
        <?php elseif(intval($resultado)===3):?>
            <p class="alerta exito"><?php echo 'Anuncio Eliminado Correctamente' ?></p>
        <?php endif;?>
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Crear</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($propiedades as $propiedad):?>
                    <tr>
                        <td> <?php echo $propiedad->id; ?> </td>
                        <td> <?php echo $propiedad->titulo; ?> </td>
                        <td><img src="../imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla" alt="Imagen Tabla"></td>
                        <td>$<?php echo $propiedad->precio; ?></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value=<?php echo $propiedad->id;?> >
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                            <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>

    </main>


<?php 

    //CERRAR ÑA CPMEXOPM
    mysqli_close($db);
    incluirTemplate("footer");
?>

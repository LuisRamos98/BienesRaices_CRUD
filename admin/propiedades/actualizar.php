<?php 

    //INICIADO SESSION

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

require "../../includes/app.php";
    estaAutenticado();
    
    //VALIDAMOS EL URL
    $id = $_GET["id"];
    $id = filter_var($id,FILTER_VALIDATE_INT);
    $erroes = Propiedad::getErrores();

    if(!$id) {
        header("Location: /admin");
    }

    $propiedad = Propiedad::find($id);

    // debugear($propiedad);

    $consulta = "SELECT * FROM vendedores";
    $vendedores = mysqli_query($db,$consulta);


    //Ejecutar el codigo despues de que el usuario haya enviado el formulario
    if($_SERVER["REQUEST_METHOD"] === "POST"){

        //Asignamos los atributos
        $args = $_POST["propiedad"];

        $propiedad->sincronizar($args);

        /**SUBIDA DE ARCHIVOS**/
        //CREAR UN NOMBRE UNICO PARA LA IMAGEN
        $nombreImagen = md5(uniqid(rand(),true)) . ".jpg";
        //SETEAMOS LA IMAGEN
        //Realiza un resize a la imagen con intervation
        if($_FILES["propiedad"]["tmp_name"]["imagen"]) {
            $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }

        //Validamos
        $errores = $propiedad->validar();

        if (empty($errores)) {

            //Almacenar las imagenes en el disco
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            $propiedad->guardar();
        }

    }
    incluirTemplate("header");
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php  echo $error;?> 
        </div>   
        <?php endforeach?>

        <form class="formulario" method="POST" action="/admin/propiedades/actualizar.php?id=<?php echo $id?>" enctype="multipart/form-data">
            <?php include "../../includes/templates/formulario_propiedades.php" ?>
            <input type="submit" class="boton boton-verde" value="Actualizar Propiedad">
        </form>

    </main>

<?php 
    incluirTemplate("footer");
?>

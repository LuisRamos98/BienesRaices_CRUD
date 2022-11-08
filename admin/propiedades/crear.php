<?php 

    //INICIADO SESSION
    require "../../includes/app.php";
    
  
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();
    
    //Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $vendedores = mysqli_query($db,$consulta);

    //Arreglo de mensajes de errores
    $errores = Propiedad::getErrores();

    //Ejecutar el codigo despues de que el usuario haya enviado el formulario
    if($_SERVER["REQUEST_METHOD"] === "POST"){

        /**CREAMOS UNA NUEVA INSTANCIA**/
        $propiedad = new Propiedad($_POST["propiedad"]);
        /**SUBIDA DE ARCHIVOS**/
        //CREAR UN NOMBRE UNICO PARA LA IMAGEN
        $nombreImagen = md5(uniqid(rand(),true)) . ".jpg";
        //SETEAMOS LA IMAGEN
        //Realiza un resize a la imagen con intervation
        if($_FILES["propiedad"]["tmp_name"]["imagen"]) {
            $image = Image::make($_FILES["propiedad"]["tmp_name"]["imagen"])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        //VALIDAMOS
        $errores = $propiedad->validar();        
        //Debemos revisar si nuestro arreglo de erroes esté vacío
        if (empty($errores)) {

            // CREAR LA CARPETA EN DONDE VAMOS A GUARDAR LAS IMGENES            
            if (!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }
        
            //Asignar files hacia una variable
            $imagen = $_FILES["imagen"];
            
            //Guarda la imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            $resultado = $propiedad->guardar();
        }

    }

    incluirTemplate("header");

?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php  echo $error;?> 
        </div>   
        <?php endforeach?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <?php include "../../includes/templates/formulario_propiedades.php"?>
            <input type="submit" class="boton boton-verde" value="Crear Propiedad">
        </form>

    </main>

<?php 
    incluirTemplate("footer");
?>

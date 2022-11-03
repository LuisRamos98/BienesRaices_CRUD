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

    $titulo = "";
    $precio = "";
    $descripcion = "";
    $habitaciones = "";
    $wc = "";
    $estacionamiento = "";
    $vendedorID = "";

    //Ejecutar el codigo despues de que el usuario haya enviado el formulario
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        /**CREAMOS UNA NUEVA INSTANCIA**/
        $propiedad = new Propiedad($_POST);

        /**SUBIDA DE ARCHIVOS**/
        //CREAR UN NOMBRE UNICO PARA LA IMAGEN
        $nombreImagen = md5(uniqid(rand(),true)) . ".jpg";

        //SETEAMOS LA IMAGEN
        //Realiza un resize a la imagen con intervation
        if($_FILES["imagen"]["tmp_name"]) {
            $image = Image::make($_FILES["imagen"]["tmp_name"])->fit(800,600);
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

            //MENSAJE DE RESULTADO O ERROR
            if($resultado) {
                // echo "Insertado correctamente";
                header("Location: /admin?resultado=1");
            }

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
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $propiedad->titulo ?>">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $propiedad->precio ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg,image/png" name="imagen">

                <label for="descripcion">Descripcion</label>
                <textarea id="descripcion" name="descripcion"><?php echo $propiedad->descripcion ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $propiedad->habitaciones ?>">

                <label for="wc">Baños</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $propiedad->wc ?>">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $propiedad->estacionamiento ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedores_id">
                    <option value="" disabled selected>--Seleccione--</option>
                    <?php while($vendedor = mysqli_fetch_assoc($vendedores)): ?>
                    <option <?php echo $vendedor["id"] == $propiedad->vendedores_id ? "selected" : ""; ?> value="<?php echo $vendedor["id"]; ?>"><?php echo $vendedor["nombre"] . " " . $vendedor["apellido"]; ?></option>
                    <!-- <option value="1">Juan</option>
                    <option value="2">Karen</option> -->
                    <?php endwhile ?>
                </select>
            </fieldset>

            <input type="submit" class="boton boton-verde" value="Crear Propiedad">
        </form>

    </main>

<?php 
    incluirTemplate("footer");
?>

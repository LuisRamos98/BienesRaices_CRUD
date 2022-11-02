<?php 

    //INICIADO SESSION
    require "../../includes/app.php";
    estaAutenticado();
    
    //VALIDAMOS EL URL
    $id = $_GET["id"];
    $id = filter_var($id,FILTER_VALIDATE_INT);
    // var_dump($id);

    if(!$id) {
        header("Location: /admin");
    }

    $db = conectarDB();

    $consulta = "SELECT * FROM propiedades WHERE id=${id}";
    $resultado = mysqli_query($db,$consulta);
    $propiedad = mysqli_fetch_assoc($resultado);
    // echo "<pre>";
    // var_dump($propiedad);
    // echo "</pre>";

    $consulta = "SELECT * FROM vendedores";
    $vendedores = mysqli_query($db,$consulta);

    //arreglo de mensaje de errores
    $titulo = $propiedad["titulo"];
    $precio = $propiedad["precio"];
    $descripcion = $propiedad["descripcion"];
    $habitaciones = $propiedad["habitaciones"];
    $wc = $propiedad["wc"];
    $estacionamiento = $propiedad["estacionamiento"];
    $vendedorID = $propiedad["vendedores_id"];
    $errores = [];

    //Ejecutar el codigo despues de que el usuario haya enviado el formulario
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";
        
        $titulo = mysqli_real_escape_string($db, $_POST["titulo"] );
        $precio = mysqli_real_escape_string($db, $_POST["precio"] );
        $descripcion = mysqli_real_escape_string($db, $_POST["descripcion"] );
        $habitaciones = mysqli_real_escape_string($db, $_POST["habitaciones"] );
        $wc = mysqli_real_escape_string($db, $_POST["wc"] );
        $estacionamiento = mysqli_real_escape_string($db, $_POST["estacionamiento"] );
        $creado = date('y/m/d');
        $vendedorID = mysqli_real_escape_string($db, $_POST["vendedor"] );
        $imagen = $_FILES["imagen"];
        

        if(!$titulo) {
            $errores[] = "Debes ingresar un titulo";
        }

        if(!$precio) {
            $errores[] = "Debes ingresar un precio";
        }

        if( strlen($descripcion) < 50) {
            $errores[] = "Debes ingresar un descripcion y debe ser mayor a 50 caracteres";
        }

        if(!$habitaciones) {
            $errores[] = "El numero de habitacion es obligatoria";
        }

        if(!$wc) {
            $errores[] = "El numero de wc es obligatoria";
        }

        if(!$estacionamiento) {
            $errores[] = "El numero de estacionamientos es obligatoria";
        }

        if(!$vendedorID) {
            $errores[] = "Ingrese un vendedor ";
        }

        //MEDIDA menos a 1MB
        $medida = 1000 * 1000;
    
        if($imagen["size"]>$medida) {
            $errores[] = "Ingrese una imagen menor a 1MB";
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";
        // exit;

        //Debemos revisar si nuestro arreglo de erroes esté vacío
        if (empty($errores)) {

            // //CREAMOS LA CARPETA PARA ALMACENAR LAS IMAGENES
            if($imagen["name"]){
                $carpetaImagenes = "../../imagenes/";

                if (!is_dir($carpetaImagenes)) {
                    mkdir($carpetaImagenes);
                }
    
                // //CREAR UN NOMBRE UNICO PARA LA IMAGEN
                $nombreImagen = md5(uniqid(rand(),true)) . ".jpg";
                
                // //SUBIR LA IMAGEN
                move_uploaded_file($imagen["tmp_name"], $carpetaImagenes . $nombreImagen);

                unlink($carpetaImagenes .  $propiedad["imagen"]);

            } else {
                $nombreImagen = $propiedad["imagen"];
            }


            // Insertar en base de datos
            $query = "UPDATE propiedades SET titulo = '${titulo}', precio = ${precio}, imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedores_id = ${vendedorID} WHERE id=${id}";

            // echo $query;
            // exit;


            $resultado = mysqli_query($db,$query);
            if($resultado) {
                // echo "Insertado correctamente";
                header("Location: /admin?resultado=2");
            }

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
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo ?>">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg,image/png" name="imagen">
                <img src="/imagenes/<?php echo $propiedad["imagen"] ?>" alt="Imagen Propiedad" class="imagen-small">

                <label for="descripcion">Descripcion</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones ?>">

                <label for="wc">Baños</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc ?>">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor">
                    <option value="" disabled selected>--Seleccione--</option>
                    <?php while($vendedor = mysqli_fetch_assoc($vendedores)): ?>
                    <option <?php echo $vendedorID == $vendedor["id"] ? "selected" : ""; ?> value="<?php echo $vendedor["id"]; ?>"><?php echo $vendedor["nombre"]; ?></option>
                    <!-- <option value="1">Juan</option>
                    <option value="2">Karen</option> -->
                    <?php endwhile ?>
                </select>
            </fieldset>

            <input type="submit" class="boton boton-verde" value="Actualizar Propiedad">
        </form>

    </main>

<?php 
    incluirTemplate("footer");
?>

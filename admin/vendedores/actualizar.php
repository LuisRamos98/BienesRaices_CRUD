<?php 

    //INICIADO SESSION
    require "../../includes/app.php";
    use App\Vendedor;
    estaAutenticado();

    //VALIDAMOS EL URL
    $id = $_GET["id"];
    $id = filter_var($id,FILTER_VALIDATE_INT);

    if(!$id) {
        header("Location: /admin");
    }

    //Obtener el arreglo del vendedor
    $vendedor = Vendedor::find($id);

    //Arreglo de mensajes de errores
    $errores = Vendedor::getErrores();

    //Ejecutar el codigo despues de que el usuario haya enviado el formulario
    if($_SERVER["REQUEST_METHOD"] === "POST"){

        //Asginar los valores 
        $args = $_POST["vendedor"];

        //Sincroniza objeto en memoria con lo que el usuario escribio
        $vendedor->sincronizar($args);

        

        //Validamos
        $errores = $vendedor->validar();
        //Debemos revisar si nuestro arreglo de erroes esté vacío
        if (empty($errores)) {
            $vendedor->guardar();
        }

    }


    incluirTemplate("header");

?>

    <main class="contenedor seccion">
        <h1>Actualizar Vendedor(a)</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php  echo $error;?> 
        </div>   
        <?php endforeach?>

        <form class="formulario" method="POST" action="/admin/vendedores/actualizar.php?id=<?php echo $id?>">
            <?php include "../../includes/templates/formulario_vendedores.php"?>
            <input type="submit" class="boton boton-verde" value="Guardar Cambios">
        </form>

    </main>

<?php 
    incluirTemplate("footer");
?>

<?php 

    //INICIADO SESSION
    require "../../includes/app.php";

    use App\Vendedor;

    estaAutenticado();

    $vendedor = new Vendedor;
    //Arreglo de mensajes de errores
    $errores = Vendedor::getErrores();

    //Ejecutar el codigo despues de que el usuario haya enviado el formulario
    if($_SERVER["REQUEST_METHOD"] === "POST"){

        /**CREAMOS UNA NUEVA INSTANCIA**/
        $vendedor = new Vendedor($_POST["vendedor"]);
        // debugear($vendedor);
        $errores = $vendedor->validar();
        //Debemos revisar si nuestro arreglo de erroes esté vacío
        if (empty($errores)) {
            $vendedor->guardar();
        }

    }

    incluirTemplate("header");

?>

    <main class="contenedor seccion">
        <h1>Registrar Vendedor(a)</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php  echo $error;?> 
        </div>   
        <?php endforeach?>

        <form class="formulario" method="POST" action="/admin/vendedores/crear.php">
            <?php include "../../includes/templates/formulario_vendedores.php"?>
            <input type="submit" class="boton boton-verde" value="Registrar Vendedor(a)">
        </form>

    </main>

<?php 
    incluirTemplate("footer");
?>

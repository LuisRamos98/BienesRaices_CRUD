<?php 

    //CONEXION DB
    require "includes/app.php";
    $db = conectarDB();

    //VALIDACIONES
    $errores = [];

    if($_SERVER["REQUEST_METHOD"] === "POST" ) {
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        $email = mysqli_real_escape_string($db,filter_var($_POST["email"],FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST["password"]);

        if(!$email) {
            $errores[] = "El email es obligatorio";
        }

        if(!$password) {
            $errores[] = "El password es obligatorio";
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";

        if (empty($errores)) {
            
            $query = "SELECT * FROM usuarios WHERE email = '${email}'";
            $resultado = mysqli_query($db,$query);

            // var_dump($resultado);
            if($resultado->num_rows) {
                //REVISAR SI EL PASSWORD ES CORRECTO

                $usuario = mysqli_fetch_assoc($resultado);
                // var_dump($usuario["password"]);
                // var_dump($password);
                $auth = password_verify($password, $usuario["password"]);
                // var_dump($auth);

                if($auth){
                    session_start();

                    $_SESSION["email"] = $usuario["email"];
                    $_SESSION["login"] = true;
                    // var_dump($_SESSION);
                    header("Location: /admin");

                } else {
                    $errores [] = "La contraseña es incorrecta";
                }


            } else {
                $errores[] = "El usuario no existe"; 
            }
        }

    
    }

    incluirTemplate("header");
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Inicio de Sesión</h1>
        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>
        <?php endforeach ?>

        <form class="formulario" method="POST">
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" >
                <label for="password">Password</label>
                <input type="password" name="password" id="password" >
            </fieldset>

            <input type="submit" value="Inciar Sesión" class="boton boton-verde">
        </form>
    </main>

<?php 
    incluirTemplate("footer");
?>

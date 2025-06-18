<?php
    // Conexión a la DB
    require 'includes/config/database.php';
    $db = conectarDB();


    // Autentificar el usuario

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        

        $email = mysqli_real_escape_string( $db ,filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
        $password = mysqli_real_escape_string( $db ,$_POST['password']);

        if(!$email) {
            $errores[] = "El email es obligatorio o no es valido";
        }
        if(!$password) {
            $errores[] = "El password es obligatorio";
        }

        if(empty($errores)) {
            // Revisar si un usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query( $db, $query );

            // 2NOTA num_rows te permite saber si un registro existe despues de una consulta
            if($resultado->num_rows) {
                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // Verificar si el password es correcto o no
                $auth = password_verify($password, $usuario["password"]);

                if($auth) {
                    //El usuario esta autenticado || 3NOTAS session_start() u $_SESSION
                    session_start();

                    //Llenar el arreglo de la sesión
                    $_SESSION["usuario"] = $usuario["email"];
                    $_SESSION["login"] = true;
                } else {
                    $errores[] = "El password es incorrecto";
                }

            }else {
                $errores[] = "El usuario no existe";
            }
        }
    }


    // Header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error) : ?>
            <div class="alerta error"> <?php echo $error ?> </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST">
            <fieldset>
                <legend>Email y Contraseña</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu email" id="email">

                <label for="password">Contraseña</label>
                <input type="password" name="password" placeholder="Tu password" id="password">
            </fieldset>

            <input type="submit" value="Iniciar Sesion" class="boton-verde">
        </form>
    </main>

<?php incluirTemplate('footer'); ?>
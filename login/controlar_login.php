<?php
session_start();
include '../conexion/conexion.php';

// Set inactivity limit in seconds
$inactivity_limit = 500;

// Check if user has submitted the form
if (isset($_POST['enviar'])) {
    if (!empty($_POST['usuario']) &&!empty($_POST['password'])) {
        $usuario = $_POST['usuario'];
        $pass = $_POST['password'];

        // Consulta para obtener los datos del usuario
        $sql = $conexion->query("SELECT * FROM profesor WHERE usuario = '$usuario' AND pass = '$pass'");

        if ($datos = $sql->fetch_object()) {
            // Almacenar datos del usuario en variables de sesión
            $_SESSION["id"] = $datos->idProrfesor;
            $_SESSION["nombre"] = $datos->nombre_profe;
            $_SESSION["apellido"] = $datos->apellido_profe;
            $_SESSION["dni"] = $datos->dni_profe;
            $_SESSION["celular"] = $datos->celular;
            $_SESSION["usuario"] = $datos->usuario;
            $_SESSION["contraseña"] = $datos->pass;
            $_SESSION["roles"] = $datos->rol;
            $_SESSION['time'] = time();

            // Redireccionar según el rol del usuario using switch case
            switch ($datos->rol) {
                case 1:
                    header("Location:../Profesor/notas/login_notas/index_notas.php"); // Redirigir a la página de asistencia
                    break;
                case 2:
                    header("Location:../Profesor/notas/login_notas/index_notas.php"); // Redirigir a la página de asistencia
                    break;
                case 3:
                    header("Location:../index.php"); // Redirigir a la página principal
                    break;
                default:
                    echo '<div class="alert alert-danger" role="alert">!! ACCESO DENEGADO!!</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">!! ACCESO DENEGADO!!</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">!! HAY CAMPOS VACÍOS!!</div>';
    }
} else {
    // Check if the user has been inactive for too long
    if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > $inactivity_limit)) {
        // User has been inactive, so destroy the session and redirect to login page
        session_unset();
        session_destroy();
        header("Location: login.php");
    } else {
        // Update the session time to the current time
        $_SESSION['time'] = time();
    }
}
?>
<script>
setInterval(function() {
   $_SESSION['time'] = time(); // Update session time with JavaScript
}, 1000); // Update the session time every second
</script>
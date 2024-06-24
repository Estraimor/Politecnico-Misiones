<?php
session_start();
include '../conexion/conexion.php';

// Set inactivity limit in seconds
$inactivity_limit = 1200;

// Check if user has submitted the form
if (isset($_POST['enviar'])) {
    if (!empty($_POST['usuario']) && !empty($_POST['password'])) {
        $usuario = $_POST['usuario'];
        $pass = $_POST['password'];

        // Primero intentamos iniciar sesión como profesor
        $sql = $conexion->query("SELECT * FROM profesor WHERE usuario = '$usuario' AND pass = '$pass'");

        if ($datos = $sql->fetch_object()) {
            // Almacenar datos del profesor en variables de sesión
            $_SESSION["id"] = $datos->idProrfesor;
            $_SESSION["nombre"] = $datos->nombre_profe;
            $_SESSION["apellido"] = $datos->apellido_profe;
            $_SESSION["dni"] = $datos->dni_profe;
            $_SESSION["celular"] = $datos->celular;
            $_SESSION["usuario"] = $datos->usuario;
            $_SESSION["contraseña"] = $datos->pass;
            $_SESSION["roles"] = $datos->rol;
            $_SESSION['time'] = time();
            // Continuar con el switch para redireccionar según el rol

            // Redireccionar según el rol del usuario using switch case
            switch ($datos->rol) {
                case 1:
                    header("Location: ../index_secretario.php"); // Rol Administracion
                    break;
                case 2:
                    header("Location: ../index.php"); // Rol Programadores
                    break;
                case 3:
                    header("Location: ../indexs/preceptor_1.php"); // Manu
                    break;
                    case 4:
                         header("Location: ../indexs/preceptor_2.php"); // Mariela
                        break;
                        case 5:
                             header("Location: ../indexs/preceptor_3.php"); // Carla kensel
                            break;
                            case 6: 
                                 header("Location: ../indexs/preceptor_4.php"); // Jorge
                                break;
                                case 8: 
                                     header("Location: ../indexs/preceptor_5.php"); // Pazz
                                    break;
                                    case 11:
                                         header("Location: ../indexs/preceptor_6.php"); // Rocio 
                                        break;
                                        case 9:
                                             header("Location: ../index_bruno.php"); // Redirigir a la página principal
                                            break;
                                             case 10:
                                             header("Location: ../profesores/index-p.php"); // Redirigir a la página principal
                                            break;
                default:
                    echo '<div class="alert alert-danger" role="alert">!! ACCESO DENEGADO!!</div>';}

        } else {
            // Si no es profesor, intentamos iniciar sesión como alumno
            $sql = $conexion->query("SELECT * FROM alumno WHERE usu_alumno = '$usuario' AND pass_alumno = '$pass'");

            if ($datos = $sql->fetch_object()) {
                // Almacenar datos del alumno en variables de sesión
                $_SESSION["id"] = $datos->idAlumno;
                $_SESSION["nombre"] = $datos->nombre_alumno;
                $_SESSION["apellido"] = $datos->apellido_alumno;
                $_SESSION["dni"] = $datos->dni_alumno;
                $_SESSION["celular"] = $datos->celular;
                $_SESSION["usuario"] = $datos->usul_alumno;
                $_SESSION["contraseña"] = $datos->pass_alumno;
                $_SESSION['time'] = time();
                // Redirigir a la página principal de alumnos
                header("Location: ../estudiantes/index_estudiante.php");
            } else {
                echo '<div class="alert alert-danger" role="alert">!! DATOS INCORRECTOS!!</div>';
            }
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">!! HAY CAMPOS VACÍOS!!</div>';
    }
}
?>

<script>
setInterval(function() {
   $_SESSION['time'] = time(); // Update session time with JavaScript
}, 1000); // Update the session time every second
</script>

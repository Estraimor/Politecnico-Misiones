<?php
session_start();
include '../conexion/conexion.php';

// Set inactivity limit in seconds
$inactivity_limit = 1200;

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
                    header("Location: ../index.php"); // Rol Administracion
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
                                case 7: 
                                     header("Location: ../indexs/preceptor_5.php"); // Carla Paola
                                    break;
                                    case 8:
                                         header("Location: ../indexs/preceptor_6.php"); // Pazz 
                                        break;
                                        case 9:
                                             header("Location: ../index_bruno.php"); // Redirigir a la página principal
                                            break;
                default:
                    echo '<div class="alert alert-danger" role="alert">!! ACCESO DENEGADO!!</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">!! DATOS INCORRECTOS!!</div>';
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
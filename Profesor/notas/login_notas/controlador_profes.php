<?php
session_start();
include '../../../conexion/conexion.php';

$sql = $conexion->query("SELECT * FROM profesor ");

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
            // Redireccionar según el rol del usuario using switch case
            switch ($datos->rol) {
                case 1:
                    header("Location:../Profesor/notas/login_notas/index_notas.php"); // Redirigir a la página de asistencia
                    break;
                case 2:
                    header("Location:../Profesor/notas/login_notas/index_notas.php"); // Redirigir a la página de asistencia
                    break;
                case 3:
                    header("Location: ./index_nota.php"); // Redirigir a la página principal
                    break;
                default:
                    echo '<div class="alert alert-danger" role="alert">!! ACCESO DENEGADO!!</div>';
                }}
?>
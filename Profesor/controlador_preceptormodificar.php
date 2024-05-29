<?php
session_start();

// Verificar si existe un rol de preceptor en la sesión
if (isset($_SESSION["roles"])) {
    // Redireccionar según el rol del usuario usando switch case
    switch ($_SESSION["roles"]) {
        case 1:
            header("Location: ../index_secretario.php"); // Administracion
            exit();
        case 2:
            header("Location: ../index.php"); // Programador
            exit();
        case 3:
            header("Location: ../indexs/preceptor_1.php"); // Manu
            exit();
        case 4:
            header("Location: ../indexs/preceptor_2.php"); // Mariela
            exit();
        case 5:
            header("Location: ../indexs/preceptor_3.php"); // Carla kensel
            exit();
        case 6: 
            header("Location: ../indexs/preceptor_4.php"); // Jorge
            exit();
        case 8: 
            header("Location: ../indexs/preceptor_5.php"); // Carla Paola
            exit(); 
        case 11:
            header("Location: ../indexs/preceptor_6.php"); // Luciano 
            exit();
        case 9:
            header("Location: ../index_bruno.php"); // Bruno 
            exit();
        default:
            echo '<div class="alert alert-danger" role="alert">!! ACCESO DENEGADO!!</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">!! ACCESO DENEGADO!!</div>';
}
?>

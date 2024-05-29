<?php
session_start();

// Verificar si existe un rol de preceptor en la sesión
if (isset($_SESSION["roles"]) ) {
    // Redireccionar según el rol del preceptor usando switch case
    switch ($_SESSION["roles"]) {
        case 3:
            header("Location: ./preceptor_1.php"); // Manu
            exit();
        case 4:
            header("Location: ./preceptor_2.php"); // Mariela
            exit();
        case 5:
            header("Location: ./preceptor_3.php"); // Carla kensel
            exit();
        case 6: 
            header("Location: ./preceptor_4.php"); // Jorge
            exit();
        case 8: 
            header("Location: ./preceptor_5.php"); // Pazz
            exit();
        case 11:
            header("Location: ./preceptor_6.php"); // Rocio 
            exit();
        default:
            echo '<div class="alert alert-danger" role="alert">!! ACCESO DENEGADO!!</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">!! ACCESO DENEGADO!!</div>';
}
?>

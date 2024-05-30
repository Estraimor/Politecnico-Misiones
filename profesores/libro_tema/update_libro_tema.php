<?php
session_start();
if (empty($_SESSION["id"])) {
    header('Location: ../../login/login.php');
    exit();
}

include '../../conexion/conexion.php';

$original_fecha = $_POST['original_fecha'];
$fecha = $_POST['fecha'];
$capacidades = $_POST['capacidades'];
$contenidos = $_POST['contenidos'];
$evaluacion = $_POST['evaluacion'];
$observacion_diaria = $_POST['observacion_diaria'];

$sql = "UPDATE libro_tema SET 
        capacidades = '$capacidades', 
        contenidos = '$contenidos', 
        evaluacion = '$evaluacion', 
        observacion_diaria = '$observacion_diaria'
        WHERE fecha = '$original_fecha' AND profesor_id = '{$_SESSION['id']}'";

if (mysqli_query($conexion, $sql)) {
    echo "Registro actualizado exitosamente";
} else {
    echo "Error al actualizar el registro: " . mysqli_error($conexion);
}

mysqli_close($conexion);

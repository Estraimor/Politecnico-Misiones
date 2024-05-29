<?php
include '../conexion/conexion.php';

if (isset($_POST['enviar'])){
    $carrera = $_POST['carrera'];
    $materia = $_POST['materia'];
    $profesor = $_POST['profesor'];
    $capacidades = $_POST['capacidades'];
    $contenidos = $_POST['contenidos'];
    $evaluacion = $_POST['evaluacion'];
    $fecha = $_POST['fecha'];

    $sql = "INSERT INTO `libro_tema` (`profesor_idProrfesor`, `carreras_idCarrera`, `materias_idMaterias`, `capacidades`, `contenidos`, `evaluacion`, `fecha`) 
            VALUES ('$profesor', '$carrera', '$materia', '$capacidades', '$contenidos', '$evaluacion', '$fecha')";

    $query = mysqli_query($conexion, $sql);
    if ($query) {
        header('Location: ./index-p.php');
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>
<?php
include'../conexion/conexion.php';
if (isset($_POST['enviar'])) {
    $legajo=$_POST['selectAlumno'];
    $carrea=$_POST['carrera'];
    $motivo=$_POST['motivo'];
    $profesor=$_POST['profesor'];
    $fecha=$_POST['fecha'];
    
     $sql_insertar="INSERT INTO `alumnos_rat` (`alumno_legajo`, `profesor_idProrfesor`, `carreras_idCarrera`, `motivo`, `fecha`) 
     VALUES ('$legajo', '$profesor', '$carrea', '$motivo', '$fecha');";
     $query=mysqli_query($conexion,$sql_insertar);
     header('Location: alumnos_rat.php');
}

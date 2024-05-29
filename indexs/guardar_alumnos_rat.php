<?php
include'../conexion/conexion.php';
if (isset($_POST['enviar'])) {
    $legajo=$_POST['selectAlumno'];
    $carrea=$_POST['carrera'];
    $motivo=$_POST['motivo'];
    $materia=$_POST['materia'];
    $fecha=$_POST['fecha'];
    $Profe=$_POST['profesor'];
    
     

    
      $sql_insertar="INSERT INTO `alumnos_rat` (`alumno_legajo`, `carreras_idCarrera`, `materias_idMaterias`, `profesor_idProrfesor`, `motivo`, `fecha`) 
      VALUES ('$legajo', '$carrea', '$materia', '$Profe', '$motivo', '$fecha');";
      $query=mysqli_query($conexion,$sql_insertar);
      header('Location: controlador_preceptor.php');
}

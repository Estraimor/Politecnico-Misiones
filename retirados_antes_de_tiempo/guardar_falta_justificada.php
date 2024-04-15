<?php
include'../conexion/conexion.php';
if (isset($_POST['enviar'])) {
    $legajo=$_POST['selectAlumno'];
    $carrea=$_POST['carrera'];
    $motivo=$_POST['motivo'];
    $materia=$_POST['materia'];
    $fecha=$_POST['fecha'];
    
     $sql_insertar="INSERT INTO `alumnos_justificados` (`idalumnos_justificados`, `inscripcion_asignatura_idinscripcion_asignatura`, `inscripcion_asignatura_carreras_idCarrera`, `inscripcion_asignatura_alumno_legajo`, `materias_idMaterias`, `fecha`, `Motivo`) 
     VALUES (NULL, NULL, '$carrea', '$legajo', '$materia', '$fecha', '$motivo');";
     $query=mysqli_query($conexion,$sql_insertar);
     header('Location: alumno_justificados.php');
}

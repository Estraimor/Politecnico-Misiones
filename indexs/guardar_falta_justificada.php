<?php
include '../conexion/conexion.php';
if (isset($_POST['enviar'])) {
    $legajo = $_POST['selectAlumnoJustificado'];
    $carrera = $_POST['carrera'];
    $curso = $_POST['curso'];
    $comision = $_POST['comision'];
    $motivo = $_POST['motivo'];
    $materia1 = $_POST['materia1'];
    $materia2 = $_POST['materia2'];
    $fecha = $_POST['fecha'];
    $profesor = $_POST['profesor'];

   

     // Insertar la primera materia
     $sql_insertar1 = "INSERT INTO alumnos_justificados (alumno_legajo, carreras_idCarrera, materias_idMaterias, profesor_idProrfesor, motivo, fecha, cursos_idcursos, comisiones_idComisiones) 
                      VALUES ('$legajo', '$carrera', '$materia1', '$profesor', '$motivo', '$fecha', '$curso', '$comision')";
     $query1 = mysqli_query($conexion, $sql_insertar1);

      // Insertar la segunda materia si está seleccionada
     if (!empty($materia2)) {
         $sql_insertar2 = "INSERT INTO alumnos_justificados (alumno_legajo, carreras_idCarrera, materias_idMaterias, profesor_idProrfesor, motivo, fecha, cursos_idcursos, comisiones_idComisiones) 
                           VALUES ('$legajo', '$carrera', '$materia2', '$profesor', '$motivo', '$fecha', '$curso', '$comision')";
         $query2 = mysqli_query($conexion, $sql_insertar2);
     }

     header('Location: controlador_preceptor.php');
}
?>

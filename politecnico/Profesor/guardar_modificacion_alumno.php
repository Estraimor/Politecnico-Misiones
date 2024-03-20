<?php
include'../conexion/conexion.php';
if (isset($_POST['Enviar'])){
    $nombre=$_POST['nombre_alumno'];
    $apellido=$_POST['apellido_alumno'];
    $dni=$_POST['dni_alumno'];
    $celular=$_POST['celular'];
    $legajo=$_POST['legajo'];
    $edad=$_POST['edad'];
    $formacion_P=$_POST['formacion_previa'];
    $trabaja_HS=$_POST['Trabaja_Horario'];
    $carrera=$_POST['carreras'];


    $sql="update politecnico.alumno set nombre_alumno = '$nombre' , apellido_alumno = '$apellido',
    dni_alumno = '$dni',celular = '$celular',legajo = ' $legajo',edad = '$edad',formacion_previa = '$formacion_P',Trabaja_Horario = '$trabaja_HS' 
    where legajo = '$legajo';";
    $query=mysqli_query($conexion,$sql);

    $sql_update_carrera="UPDATE politecnico.inscripcion_asignatura SET carreras_idCarrera = '$carrera' 
    WHERE (alumno_legajo = '$legajo');";
    $query_carrera=mysqli_query($conexion,$sql_update_carrera);

if ($query_carrera) {
    // La consulta se ejecutó con éxito
      header('Location: index.php');
} else {
    // Hubo un error en la consulta
    echo "Error al actualizar la carrera: " . mysqli_error($conexion);
}
}


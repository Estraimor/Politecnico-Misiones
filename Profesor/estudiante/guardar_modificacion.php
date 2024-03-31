<?php
 include'../../conexion/conexion.php';
 if (isset($_POST['enviar'])) 
 {
    $id=$_POST['idalumno'];
    $nombre_alu=$_POST['nombre_alu'];
    $apellido_alu=$_POST['apellido_alu'];
    $dni=$_POST['dni'];
    $celular=$_POST['celular'];
    $sql="UPDATE politecnico.alumno 
    SET nombre_alumno = '$nombre_alu', apellido_alumno = '$apellido_alu', dni_alumno = '$dni', celular = '$celular' 
    WHERE (idAlumno = '$id');";
    $query=mysqli_query($conexion,$sql);
    header("Location: alta_estudiante.php ");
 }
?>
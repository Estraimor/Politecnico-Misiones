<?php
include'../../conexion/conexion.php';
$id=$_GET["id"];
$sql="UPDATE alumno SET estado = '2' WHERE (idAlumno = '$id');";
$query=mysqli_query($conexion,$sql);
header("Location: alta_estudiante.php");
?>
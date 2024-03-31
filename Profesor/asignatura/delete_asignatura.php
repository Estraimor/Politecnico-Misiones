<?php
include'../../conexion/conexion.php'; 
$id=$_GET["id"];
$sql="DELETE FROM politecnico.materia WHERE (idMateria = '$id');";
$query=mysqli_query($conexion,$sql);
header("Location: alta_materia.php");
?>
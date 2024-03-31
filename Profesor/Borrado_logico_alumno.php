<?php
include'../conexion/conexion.php';
$legajo=$_GET['legajo'];
$sql="UPDATE politecnico.alumno SET estado = '2' WHERE (legajo = '$legajo');";
$query=mysqli_query($conexion,$sql);
header('Location: index.php');
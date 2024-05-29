<?php
$server='localhost';
$user='root';
$pass='';
$bd='u756746073_politecnico';
$conexion=mysqli_connect($server,$user,$pass,$bd, '3306');

if ($conexion) { echo ""; } else { echo "conexion not connected"; }


<?php
include'../conexion/conexion.php';
if (isset($_POST['enviar'])) {
    $nombre=$_POST['nombre'];
    $apellido=$_POST['apellido'];
    $dni=$_POST['dni'];
    $celular=$_POST['celular'];
    $legajo=$_POST['legajo'];
    $observaciones=$_POST['observaciones'];
    $trabaja=$_POST['trabaja'];
    $fp1=$_POST['FP1'];
    $fp2=$_POST['FP2'];
    $fp3=$_POST['FP3'];
    $fp4=$_POST['FP4'];
    $sql="INSERT INTO alumnos_fp (legajo, nombre_afp, apellido_afp, dni_afp, celular_afp, observaciones_afp, trabaja_fp, carreras_idCarrera, carreras_idCarrera1, carreras_idCarrera2, carreras_idCarrera3) 
    VALUES ( '$legajo', '$nombre', '$apellido', '$dni', '$celular', '$observaciones', '$trabaja', '$fp1', '$fp2', $fp3, $fp4);";
    $query=mysqli_query($conexion,$sql);
}

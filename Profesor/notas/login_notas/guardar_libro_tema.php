<?php
include'../coenxion/conexion.php';
if (isset($_POST['enviar'])){
    $carrera=$_POST['carrera'];
    $materia=$_POST['materia'];
    $profesor=$_POST['profesor'];
    $capacidades=$_POST['capacidades'];
    $contenidos=$_POST['contenidos'];
    $evaluacion=$_POST['evaluacion'];
    $fecha=$_POST['fecha'];
    echo "Carrea:" .$carrera;
    echo "Materia:" . $materia;
    echo "Profesor:" . $profesor;
    echo "Capacidades:" . $capacidades;
    echo "Contenidos:" . $contenidos;
    echo "Evaluacion:" . $evaluacion;
    echo "Fecha" . $fecha;
}
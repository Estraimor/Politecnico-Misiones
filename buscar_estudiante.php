<?php
include './conexion/conexion.php';

$nombre = $_GET['nombre'] ?? '';

$sql = "SELECT legajo, nombre_alumno, apellido_alumno FROM alumno WHERE nombre_alumno LIKE ? LIMIT 15";
$stmt = $conexion->prepare($sql);
$busqueda = "%$nombre%";
$stmt->bind_param("s", $busqueda);
$stmt->execute();
$result = $stmt->get_result();

$estudiantes = [];
while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

echo json_encode($estudiantes);
?>

<?php
session_start();
include'../../conexion/conexion.php';


$sql = "SELECT * FROM libro_tema"; // Cambia esto por tu consulta
$result = $conexion->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Output data de cada fila
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo json_encode([]);
}

$conn->close();

echo json_encode($data);
?>

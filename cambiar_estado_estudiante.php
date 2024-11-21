<?php
include './conexion/conexion.php'; // Archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $legajo = $_POST['legajo'];
    $sql = "UPDATE alumno SET estado = '1' WHERE legajo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $legajo);
    if ($stmt->execute()) {
        echo "Estado del estudiante actualizado con éxito.";
    } else {
        echo "Error al actualizar el estado.";
    }
    $stmt->close();
}
?>

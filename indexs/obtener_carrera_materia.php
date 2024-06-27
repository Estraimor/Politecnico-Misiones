<?php
include '../conexion/conexion.php';

// Obtener el ID de la materia enviado desde la solicitud AJAX
$materia = isset($_POST['materia']) ? $conexion->real_escape_string($_POST['materia']) : '';

// Consulta SQL para obtener la carrera de la materia
$sql = "SELECT carreras_idCarrera 
        FROM materias 
        WHERE idMaterias = '$materia'";

// Ejecutar la consulta
$query = mysqli_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if ($query) {
    // Obtener el resultado de la consulta
    $resultado = mysqli_fetch_assoc($query);

    // Verificar si se encontró la carrera
    if ($resultado) {
        // Devolver la carrera en formato JSON
        echo json_encode(array('carrera' => $resultado['carreras_idCarrera']));
    } else {
        // Si no se encontró, devolver un mensaje de error
        echo json_encode(array('error' => 'No se encontró la carrera para la materia.'));
    }
} else {
    // Si ocurrió un error en la consulta, devolver un mensaje de error
    echo json_encode(array('error' => 'Error en la consulta SQL: ' . mysqli_error($conexion)));
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

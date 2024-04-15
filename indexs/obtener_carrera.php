<?php
include '../conexion/conexion.php';

// Obtener el legajo del alumno enviado desde la solicitud AJAX
$legajo = $_POST['legajo'];

// Consulta SQL para obtener la carrera del alumno
$sql = "SELECT ia.carreras_idCarrera 
        FROM inscripcion_asignatura ia
        WHERE ia.alumno_legajo = '$legajo' ";

// Ejecutar la consulta
$query = mysqli_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if ($query) {
    // Obtener el resultado de la consulta
    $resultado = mysqli_fetch_assoc($query);

    // Verificar si se encontró la carrera
    if ($resultado) {
        // Obtener el ID de la carrera
        $carrera = $resultado['carreras_idCarrera'];

        // Devolver la carrera en formato JSON
        echo json_encode(array('carrera' => $carrera));
    } else {
        // Si no se encontró la carrera, devolver un mensaje de error
        echo json_encode(array('error' => 'No se encontró la carrera para el alumno.'));
    }
} else {
    // Si ocurrió un error en la consulta, devolver un mensaje de error
    echo json_encode(array('error' => 'Error en la consulta SQL: ' . mysqli_error($conexion)));
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

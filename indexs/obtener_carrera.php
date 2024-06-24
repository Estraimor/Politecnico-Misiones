<?php
// Incluir la conexión a la base de datos
include '../conexion/conexion.php';

// Obtener el legajo del alumno enviado desde la solicitud AJAX
$legajo = isset($_POST['legajo']) ? $conexion->real_escape_string($_POST['legajo']) : '';

// Consulta SQL para obtener la carrera del alumno
$sql = "SELECT c.idCarrera 
        FROM inscripcion_asignatura ia
        INNER JOIN materias m on ia.materias_idMaterias = m.idMaterias
        INNER JOIN carreras c on m.carreras_idCarrera = c.idCarrera
        WHERE ia.alumno_legajo = '$legajo'
        GROUP BY ia.alumno_legajo";

// Ejecutar la consulta
$query = mysqli_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if ($query) {
    // Obtener el resultado de la consulta
    $resultado = mysqli_fetch_assoc($query);

    // Verificar si se encontró la carrera
    if ($resultado) {
        // Obtener el ID de la carrera
        $carrera = $resultado['idCarrera'];

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

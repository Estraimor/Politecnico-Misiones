<?php
include '../conexion/conexion.php';

// Obtener el legajo del alumno enviado desde la solicitud AJAX
$legajo = isset($_POST['legajo']) ? $conexion->real_escape_string($_POST['legajo']) : '';

// Consulta SQL para obtener el curso y la comisión del alumno
$sql = "SELECT ia.cursos_idcursos, ia.comisiones_idComisiones
        FROM inscripcion_asignatura ia
        WHERE ia.alumno_legajo = '$legajo'
        GROUP BY ia.alumno_legajo";

// Ejecutar la consulta
$query = mysqli_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if ($query) {
    // Obtener el resultado de la consulta
    $resultado = mysqli_fetch_assoc($query);

    // Verificar si se encontró el curso y la comisión
    if ($resultado) {
        // Devolver los datos en formato JSON
        echo json_encode(array(
            'curso' => $resultado['cursos_idcursos'],
            'comision' => $resultado['comisiones_idComisiones']
        ));
    } else {
        // Si no se encontró, devolver un mensaje de error
        echo json_encode(array('error' => 'No se encontraron datos para el alumno.'));
    }
} else {
    // Si ocurrió un error en la consulta, devolver un mensaje de error
    echo json_encode(array('error' => 'Error en la consulta SQL: ' . mysqli_error($conexion)));
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

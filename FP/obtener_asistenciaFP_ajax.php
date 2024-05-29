<?php
// obtener_asistencia_ajax.php

session_start();
if (empty($_SESSION["id"])) {
    header('Location: ../../login/login.php');
    exit;
}

include'../conexion/conexion.php';

// Obtenemos los parámetros de la solicitud AJAX
$fecha = isset($_GET['fecha']) ? mysqli_real_escape_string($conexion, $_GET['fecha']) : '';
$comisionID = isset($_GET['comisionId']) ? mysqli_real_escape_string($conexion, $_GET['comisionId']) : '';

// Verificamos si se proporcionaron todos los parámetros necesarios
if (empty($fecha) || empty($comisionID)) {
    echo "Error: Parámetros incorrectos.";
    exit;
}

try {
    // Consulta para obtener los datos de asistencia
    $sql_asistencia = "SELECT af.nombre_afp, af.apellido_afp, afp.1_horario, afp.fecha_FP  
            FROM asistencia_FP afp 
            LEFT JOIN alumnos_fp af ON afp.alumnos_fp_legajo_afp = af.legajo_afp
            WHERE afp.carreras_idCarrera = '$comisionID' AND afp.fecha_FP = '$fecha'";

    $query_asistencia = mysqli_query($conexion, $sql_asistencia);

    if (!$query_asistencia) {
        throw new Exception("Error en la consulta SQL de asistencia: " . mysqli_error($conexion));
    }

    // Inicializamos un contador para el número de filas
    $contador = 1;

    // Iteramos sobre los resultados y generamos las filas de la tabla HTML
    while ($datos = mysqli_fetch_assoc($query_asistencia)) {
        echo "<tr>
                <td>$contador</td>
                <td>{$datos['apellido_afp']}</td>
                <td>{$datos['nombre_afp']}</td>
                <td>{$datos['1_horario']}</td>
                <td>{$datos['fecha_FP']}</td>
              </tr>";
        $contador++;
    }       

    // Consulta para contar la cantidad de presentes y ausentes
    $sql_cantidad_presentes = "SELECT COUNT(*) AS cantidad FROM asistencia_FP WHERE 1_horario = 'Presente' AND carreras_idCarrera = '$comisionID' AND fecha_FP = '$fecha'";
    $query_cantidad_presentes = mysqli_query($conexion, $sql_cantidad_presentes);
    $cantidad_presentes = mysqli_fetch_assoc($query_cantidad_presentes)['cantidad'];

    $sql_cantidad_ausentes = "SELECT COUNT(*) AS cantidad FROM asistencia_FP WHERE 1_horario = 'Ausente' AND carreras_idCarrera = '$comisionID' AND fecha_FP = '$fecha'";
    $query_cantidad_ausentes = mysqli_query($conexion, $sql_cantidad_ausentes);
    $cantidad_ausentes = mysqli_fetch_assoc($query_cantidad_ausentes)['cantidad'];

    // Imprimimos la fila con la cantidad de presentes y ausentes
    echo "<tr>
            <td colspan='5'>Cantidad de presentes: $cantidad_presentes</td>
          </tr>";
    echo "<tr>
            <td colspan='5'>Cantidad de ausentes: $cantidad_ausentes</td>
          </tr>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>

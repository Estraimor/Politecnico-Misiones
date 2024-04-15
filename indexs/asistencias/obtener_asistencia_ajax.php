<?php
// obtener_asistencia_ajax.php

session_start();
if (empty($_SESSION["id"])) {
    header('Location: ../../login/login.php');
    exit;
}

$server = 'localhost';
$user = 'u756746073_root';
$pass = 'POLITECNICOmisiones2023.';
$bd = 'u756746073_politecnico';
$conexion = mysqli_connect($server, $user, $pass, $bd, '3306');

if (!$conexion) {
    echo "Error: No se pudo conectar a la base de datos.";
    exit;
}

$fecha = isset($_GET['fecha']) ? mysqli_real_escape_string($conexion, $_GET['fecha']) : '';
$comisionID = isset($_GET['comisionId']) ? mysqli_real_escape_string($conexion, $_GET['comisionId']) : '';

if (empty($fecha) || empty($comisionID)) {
    echo "Error: Parámetros incorrectos.";
    exit;
}

try {
    // Consulta para obtener los datos de asistencia
    $sql_asistencia = "SELECT a2.nombre_alumno, a2.apellido_alumno, a.`1_Horario`, a.`2_Horario`, a.fecha  
            FROM asistencia a 
            LEFT JOIN alumno a2 ON a.inscripcion_asignatura_alumno_legajo = a2.legajo
            WHERE a.inscripcion_asignatura_carreras_idCarrera = '$comisionID' AND a.fecha = '$fecha'";

    $query_asistencia = mysqli_query($conexion, $sql_asistencia);

    if (!$query_asistencia) {
        throw new Exception("Error en la consulta SQL de asistencia: " . mysqli_error($conexion));
    }

    // Consulta para contar la cantidad de presentes 1HS
    $sql_presentes = "select count(`1_Horario` ) as cantidad_presentes from asistencia a
    where `1_Horario` = 'Presente' and fecha = '$fecha' 
    and inscripcion_asignatura_carreras_idCarrera = '$comisionID'";

    $query_presentes = mysqli_query($conexion, $sql_presentes);

// Consulta para contar la cantidad de ausentes 1HS

    $sql_ausente = "select count(`1_Horario` ) as cantidad_ausentes from asistencia a
    where `1_Horario` = 'ausente' and fecha = '$fecha' 
    and inscripcion_asignatura_carreras_idCarrera = '$comisionID'";

    $query_ausentes = mysqli_query($conexion, $sql_ausente);

    // Consulta para contar la cantidad de Justificada 1HS  

    $sql_justificada = "select count(`1_Horario` ) as cantidad_justificada from asistencia a
    where `1_Horario` = 'justificada' and fecha = '$fecha' 
    and inscripcion_asignatura_carreras_idCarrera = '$comisionID'";

    $query_justificadas = mysqli_query($conexion, $sql_justificada);

    //__________________________________2HS_____________________________________________________

     // Consulta para contar la cantidad de presentes 2HS
    $sql_presentes2HS = "select count(`2_Horario` ) as cantidad_presentes2 from asistencia a
    where `2_Horario` = 'Presente' and fecha = '$fecha' 
    and inscripcion_asignatura_carreras_idCarrera = '$comisionID'";

    $query_presentes2HS = mysqli_query($conexion, $sql_presentes2HS);

// Consulta para contar la cantidad de ausentes 2HS

    $sql_ausente2HS = "select count(`2_Horario` ) as cantidad_ausentes2 from asistencia a
    where `2_Horario` = 'ausente' and fecha = '$fecha' 
    and inscripcion_asignatura_carreras_idCarrera = '$comisionID'";

    $query_ausentes2HS = mysqli_query($conexion, $sql_ausente2HS);

    // Consulta para contar la cantidad de Justificada 2HS

    $sql_justificada2HS = "select count(`2_Horario` ) as cantidad_justificada2 from asistencia a
    where `2_Horario` = 'justificada' and fecha = '$fecha' 
    and inscripcion_asignatura_carreras_idCarrera = '$comisionID'";
 

    $query_justificadas2HS = mysqli_query($conexion, $sql_justificada2HS);

    if (!$query_presentes) {
        throw new Exception("Error en la consulta SQL de conteo de presentes 1HS: " . mysqli_error($conexion));
    }
    if (!$query_ausentes) {
        throw new Exception("Error en la consulta SQL de conteo de ausentes 1HS: " . mysqli_error($conexion));
    }
    if (!$query_justificadas    ) {
        throw new Exception("Error en la consulta SQL de conteo de justificadas 1HS: " . mysqli_error($conexion));
    }

     if (!$query_presentes2HS) {
        throw new Exception("Error en la consulta SQL de conteo de presentes 2HS: " . mysqli_error($conexion));
    }
    if (!$query_ausentes2HS) {
        throw new Exception("Error en la consulta SQL de conteo de ausentes 2HS: " . mysqli_error($conexion));
    }
    if (!$query_justificadas2HS) {
        throw new Exception("Error en la consulta SQL de conteo de justificadas 2HS: " . mysqli_error($conexion));
    }

    $cantidad_presentes1HS = mysqli_fetch_assoc($query_presentes)['cantidad_presentes'];
    $cantidad_ausentes1HS = mysqli_fetch_assoc($query_ausentes)['cantidad_ausentes'];
    $cantidad_justificadas1HS = mysqli_fetch_assoc($query_justificadas)['cantidad_justificada'];


    $cantidad_presentes2HS = mysqli_fetch_assoc($query_presentes2HS)['cantidad_presentes2'];
    $cantidad_ausentes2HS = mysqli_fetch_assoc($query_ausentes2HS)['cantidad_ausentes2'];
    $cantidad_justificadas2HS = mysqli_fetch_assoc($query_justificadas2HS)['cantidad_justificada2'];

    // Muestra los datos de asistencia y la cantidad de presentes
$contador = 1; // Inicializamos el contador en 1
    
    while ($datos = mysqli_fetch_assoc($query_asistencia)) {
        echo "<tr>
                <td>{$contador}</td>
                <td>{$datos['apellido_alumno']}</td>
                <td>{$datos['nombre_alumno']}</td>
                <td>{$datos['1_Horario']}</td>
                <td>{$datos['2_Horario']}</td>
                <td>{$datos['fecha']}</td>
              </tr>";
        $contador++; // Incrementamos el contador en 1 para el próximo ciclo
    }
    echo "<tr>  
            <td>Cantidad de presentes 1HS: $cantidad_presentes1HS
            <td>Cantidad de presentes 2HS: $cantidad_presentes2HS

         <tr>";
    echo "<tr>  
            <td>Cantidad de ausentes 1HS: $cantidad_ausentes1HS
            <td>Cantidad de ausentes 2HS: $cantidad_ausentes2HS
         <tr>";
    echo "<tr>  
            <td>Cantidad de justificadas 1HS: $cantidad_justificadas1HS
            <td>Cantidad de justificadas 2HS: $cantidad_justificadas2HS
         <tr>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>

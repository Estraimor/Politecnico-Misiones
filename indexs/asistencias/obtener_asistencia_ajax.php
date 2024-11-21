<?php
// obtener_asistencia_ajax.php

session_start();
if (empty($_SESSION["id"])) {
    header('Location: ../../login/login.php');
    exit;
}

$server = 'localhost';
$user = 'root';
$pass = '';
$bd = 'u756746073_politecnico';
$conexion = mysqli_connect($server, $user, $pass, $bd, '3306');

if (!$conexion) {
    echo "Error: No se pudo conectar a la base de datos.";
    exit;
}

$carrera = isset($_GET['carrera']) ? mysqli_real_escape_string($conexion, $_GET['carrera']) : '';
$comision = isset($_GET['comision']) ? mysqli_real_escape_string($conexion, $_GET['comision']) : '';
$curso = isset($_GET['curso']) ? mysqli_real_escape_string($conexion, $_GET['curso']) : '';
$fecha = isset($_GET['fecha']) ? mysqli_real_escape_string($conexion, $_GET['fecha']) : '';

if (empty($fecha) || empty($carrera) || empty($comision) || empty($curso)) {
    echo "Error: Parámetros incorrectos.";
    exit;
}

try {
    // Consulta para obtener los datos de asistencia
    $sql_asistencia = "SELECT a2.nombre_alumno, a2.apellido_alumno, a.asistencia, a.fecha, a.materias_idMaterias, m.Nombre as nombre_materia
            FROM asistencia a 
            INNER JOIN materias m ON a.materias_idMaterias = m.idMaterias
            INNER JOIN carreras cr ON a.carreras_idCarrera = cr.idCarrera
            INNER JOIN cursos cs ON a.cursos_idcursos = cs.idcursos
            INNER JOIN comisiones cm ON a.comisiones_idComisiones = cm.idComisiones
            LEFT JOIN alumno a2 ON a.inscripcion_asignatura_alumno_legajo = a2.legajo
            WHERE cs.idcursos = '$curso' AND cr.idCarrera = '$carrera' AND cm.idComisiones = '$comision' AND a.fecha = '$fecha'";

    $query_asistencia = mysqli_query($conexion, $sql_asistencia);

    if (!$query_asistencia) {
        throw new Exception("Error en la consulta SQL de asistencia: " . mysqli_error($conexion));
    }

    // Array para almacenar los datos de asistencia agrupados por materia
    $materias_asistencia = [];
    $alumnos_asistencia = [];

    // Procesar los resultados de la consulta
    while ($datos = mysqli_fetch_assoc($query_asistencia)) {
        $materia_id = $datos['materias_idMaterias'];
        if (!isset($materias_asistencia[$materia_id])) {
            // Inicializa el array para una nueva materia
            $materias_asistencia[$materia_id] = [
                'nombre_materia' => $datos['nombre_materia'],
                'presentes' => 0,
                'ausentes' => 0,
                'justificadas' => 0,
            ];
        }
        // Agrega los datos del alumno al array general
        $alumnos_asistencia[] = $datos;
        // Incrementa los contadores de presentes, ausentes y justificadas según corresponda
        if (strtolower($datos['asistencia']) == '1') {
            $materias_asistencia[$materia_id]['presentes']++;
        } elseif (strtolower($datos['asistencia']) == '2') {
            $materias_asistencia[$materia_id]['ausentes']++;
        } elseif (strtolower($datos['asistencia']) == 'justificada') {
            $materias_asistencia[$materia_id]['justificadas']++;
        }
    }

    // Mostrar la tabla general de alumnos
    echo "<table class='table table-bordered'>";
    echo "<tr>
            <th>N°</th>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>Asistencia</th>
            <th>Fecha</th>
        </tr>";

        $contador = 1;
        foreach ($alumnos_asistencia as $alumno) {
              // Convertir el valor de asistencia a texto
                $asistencia_texto = $alumno['asistencia'] == 1 ? 'Presente' : ($alumno['asistencia'] == 2 ? 'Ausente' : 'No especificado');

                echo "<tr>
                        <td>{$contador}</td>
                        <td>{$alumno['apellido_alumno']}</td>
                        <td>{$alumno['nombre_alumno']}</td>
                        <td>{$asistencia_texto}</td>
                        <td>{$alumno['fecha']}</td>
                    </tr>";
                $contador++;
        }
    echo "</table>";

    // Mostrar los contadores al final
    echo "<table class='table table-bordered'>";
    echo "<tr>";
    foreach ($materias_asistencia as $materia_id => $asistencia) {
        echo "<td>";
        echo "<strong>Materia: {$asistencia['nombre_materia']}</strong><br>";
        echo "Cantidad de presentes: {$asistencia['presentes']}<br>";
        echo "Cantidad de ausentes: {$asistencia['ausentes']}<br>";
        echo "Cantidad de justificadas: {$asistencia['justificadas']}";
        echo "</td>";
    }
    echo "</tr>";
    echo "</table>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

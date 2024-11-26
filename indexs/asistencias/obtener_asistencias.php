<?php
include '../../conexion/conexion.php';

// Capturar los parámetros
$materia = $_GET['materia'] ?? null;
$curso = $_GET['curso'] ?? null;
$carrera = $_GET['carrera'] ?? null;
$comision = $_GET['comision'] ?? null;
$fecha_actual = date('Y-m-d'); // Fecha actual

// Validar parámetros
if (!$materia || !$curso || !$carrera || !$comision) {
    echo json_encode(["error" => "Faltan parámetros"]);
    exit;
}

// Consulta SQL
$sql = "
    SELECT 
        a.nombre_alumno, 
        a.apellido_alumno, 
        a.legajo, 
        IFNULL(asis.asistencia, 0) AS asistencia
    FROM inscripcion_asignatura ia
    INNER JOIN alumno a ON ia.alumno_legajo = a.legajo
    LEFT JOIN asistencia asis 
        ON ia.alumno_legajo = asis.inscripcion_asignatura_alumno_legajo
        AND asis.materias_idMaterias = '$materia'
        AND asis.cursos_idcursos = '$curso'
        AND asis.carreras_idCarrera = '$carrera'
        AND asis.comisiones_idComisiones = '$comision'
        AND asis.fecha = '$fecha_actual'
    WHERE ia.cursos_idcursos = '$curso'
      AND ia.comisiones_idComisiones = '$comision'
      AND ia.materias_idMaterias = '$materia'
";

$query = mysqli_query($conexion, $sql);

// Manejo de errores en la consulta
if (!$query) {
    echo json_encode(["error" => mysqli_error($conexion)]);
    exit;
}

// Procesar resultados
$resultado = [];
while ($row = mysqli_fetch_assoc($query)) {
    $resultado[] = $row;
}

// Devolver resultados en formato JSON
echo json_encode($resultado);
?>

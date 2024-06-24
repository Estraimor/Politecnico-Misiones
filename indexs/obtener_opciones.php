<?php
// Conexión a la base de datos
include '../conexion/conexion.php';

// Filtrar por nombre, apellido o legajo del alumno
$alumnoFiltro = isset($_POST['alumno']) ? $conexion->real_escape_string($_POST['alumno']) : '';

// Consulta para obtener los alumnos y la carrera que cursa
$sqlAlumnos = "SELECT a.nombre_alumno, a.apellido_alumno, a.legajo, c.idCarrera, c.nombre_carrera
               FROM alumno a
               INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.legajo
               INNER JOIN materias m on ia.materias_idMaterias = m.idMaterias
               INNER JOIN carreras c on m.carreras_idCarrera = c.idCarrera
               WHERE a.nombre_alumno LIKE '%$alumnoFiltro%' 
               OR a.apellido_alumno LIKE '%$alumnoFiltro%' 
               OR a.legajo LIKE '%$alumnoFiltro%' 
               GROUP BY a.legajo";

// Ejecutar consulta
$resultadoAlumnos = $conexion->query($sqlAlumnos);

// Armar array con resultados
$alumnos = array();

if ($resultadoAlumnos && $resultadoAlumnos->num_rows > 0) {
    while ($fila = $resultadoAlumnos->fetch_assoc()) {
        $alumnos[] = $fila;
    }
}

// Cerrar conexión
$conexion->close();

// Devolver resultados en formato JSON
echo json_encode(array('alumnos' => $alumnos));
?>

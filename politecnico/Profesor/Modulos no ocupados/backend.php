<?php
// Conexión a la base de datos
$server = 'localhost';
$user = 'root';
$pass = '';
$bd = 'politecnico';
$conexion = new mysqli($server, $user, $pass, $bd, '3306');

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Filtrar por nombre, apellido o legajo del alumno
$alumnoFiltro = isset($_POST['alumno']) ? $conexion->real_escape_string($_POST['alumno']) : '';
$materiaFiltro = isset($_POST['materia']) ? $conexion->real_escape_string($_POST['materia']) : '';

// Consulta para obtener los alumnos y materias que coincidan con los filtros
$sqlAlumnos = "SELECT a.nombre_alumno, a.apellido_alumno, a.legajo FROM alumno a 
               WHERE a.nombre_alumno LIKE '%$alumnoFiltro%' 
               OR a.apellido_alumno LIKE '%$alumnoFiltro%' 
               OR a.legajo LIKE '%$alumnoFiltro%'";

$sqlMaterias = "SELECT m.idMaterias, m.Nombre FROM materias m 
                WHERE m.Nombre LIKE '%$materiaFiltro%'";

// Ejecutar consultas
$resultadoAlumnos = $conexion->query($sqlAlumnos);
$resultadoMaterias = $conexion->query($sqlMaterias);

// Armar array con resultados
$alumnos = array();
$materias = array();

if ($resultadoAlumnos && $resultadoAlumnos->num_rows > 0) {
    while ($fila = $resultadoAlumnos->fetch_assoc()) {
        $alumnos[] = $fila;
    }
}

if ($resultadoMaterias && $resultadoMaterias->num_rows > 0) {
    while ($fila = $resultadoMaterias->fetch_assoc()) {
        $materias[] = $fila;
    }
}

// Cerrar conexión
$conexion->close();

// Devolver resultados en formato JSON
echo json_encode(array('alumnos' => $alumnos, 'materias' => $materias));
?>

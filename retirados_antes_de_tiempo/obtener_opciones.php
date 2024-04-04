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

// Consulta para obtener los alumnos y materias que coincidan con los filtros
$sqlAlumnos = "SELECT a.nombre_alumno, a.apellido_alumno, a.legajo FROM alumno a 
               WHERE a.nombre_alumno LIKE '%$alumnoFiltro%' 
               OR a.apellido_alumno LIKE '%$alumnoFiltro%' 
               OR a.legajo LIKE '%$alumnoFiltro%'";


// Ejecutar consultas
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


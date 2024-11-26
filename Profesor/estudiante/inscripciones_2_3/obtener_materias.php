<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$bd = 'u756746073_politecnico';
$conexion = mysqli_connect($server, $user, $pass, $bd, '3306');

if (isset($_POST['carrera']) && isset($_POST['curso']) && isset($_POST['legajo'])) {
    $carrera = $_POST['carrera'];
    $curso = $_POST['curso'];
    $legajo = $_POST['legajo'];

    // Seleccionar materias del curso y verificar si están siendo cursadas por el estudiante
    $sql = "
        SELECT m.idMaterias, m.Nombre,
               CASE WHEN ia.alumno_legajo IS NOT NULL THEN 1 ELSE 0 END AS cursada
        FROM materias m
        INNER JOIN cursos_has_materias cm ON cm.materias_idMaterias = m.idMaterias
        LEFT JOIN inscripcion_asignatura ia 
               ON ia.materias_idMaterias = m.idMaterias 
               AND ia.alumno_legajo = ? 
               AND ia.cursos_idcursos = ?
        WHERE m.carreras_idCarrera = ? 
          AND cm.cursos_idcursos = ?
    ";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iiii", $legajo, $curso, $carrera, $curso);
    $stmt->execute();
    $result = $stmt->get_result();

    $materias = array();
    while ($row = $result->fetch_assoc()) {
        $materias[] = $row;
    }

    echo json_encode($materias);
} else {
    echo json_encode(array('error' => 'No se recibieron los datos correctamente'));
}
?>

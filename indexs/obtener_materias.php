<?php
// Incluir el archivo de conexión a la base de datos
include '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $legajo = $_POST['legajo'];

    // Consulta SQL para obtener las materias específicas del alumno
    $sql = "SELECT m.idMaterias, m.Nombre
            FROM inscripcion_asignatura ia
            INNER JOIN materias m ON ia.materias_idMaterias = m.idMaterias
            WHERE ia.alumno_legajo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $legajo);
    $stmt->execute();
    $result = $stmt->get_result();

    $materias = [];
    while ($row = $result->fetch_assoc()) {
        $materias[] = $row;
    }

    echo json_encode(['materias' => $materias]);
}
?>

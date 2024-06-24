<?php
include '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carreraId = $_POST['carreraId'];
    $curso = $_POST['curso'];

    $sql = "SELECT m.idMaterias, m.Nombre 
            FROM materias m 
            INNER JOIN cursos_has_materias cm ON cm.materias_idMaterias = m.idMaterias 
            WHERE m.carreras_idCarrera = ? AND cm.cursos_idcursos = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $carreraId, $curso);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $materias = array();
    while ($row = $result->fetch_assoc()) {
        $materias[] = $row;
    }

    echo json_encode($materias);
}
?>

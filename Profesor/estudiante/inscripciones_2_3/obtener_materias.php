<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$bd = 'u756746073_politecnico';
$conexion = mysqli_connect($server, $user, $pass, $bd, '3306');

if (isset($_POST['carrera']) && isset($_POST['curso'])) {
    $carrera = $_POST['carrera'];
    $curso = $_POST['curso'];

    $sql = "SELECT m.idMaterias, m.Nombre 
            FROM materias m 
            INNER JOIN cursos_has_materias cm ON cm.materias_idMaterias = m.idMaterias 
            WHERE m.carreras_idCarrera = ? AND cm.cursos_idcursos = ?";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $carrera, $curso);
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
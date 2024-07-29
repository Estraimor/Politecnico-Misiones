<?php
session_start();
include '../conexion/conexion.php';
// Consulta para obtener los datos necesarios
$sql = "
    SELECT 
        c.idCarrera,
        c.nombre_carrera,
        cu.idcursos,
        cu.nombre_curso,
        co.idComisiones,
        co.N_comicion
    FROM 
        carreras c
    INNER JOIN 
        preceptores p ON c.idCarrera = p.carreras_idCarrera
    INNER JOIN 
        cursos cu ON cu.idcursos = p.cursos_idcursos
    INNER JOIN 
        comisiones co ON co.idComisiones = p.comisiones_idComisiones
    WHERE 
        p.profesor_idProrfesor = ?
";

// Preparar y ejecutar la consulta
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $_SESSION["id"]);
$stmt->execute();
$result = $stmt->get_result();

// Array para almacenar los resultados
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'idCarrera' => $row['idCarrera'],
        'nombreCarrera' => htmlspecialchars($row['nombre_carrera']),
        'idCurso' => $row['idcursos'],
        'nombreCurso' => htmlspecialchars($row['nombre_curso']),
        'idComision' => $row['idComisiones'],
        'nombreComision' => htmlspecialchars($row['N_comicion'])
    );
}

// Cerrar la conexión
$stmt->close();
$conn->close();

// Devolver los datos como JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
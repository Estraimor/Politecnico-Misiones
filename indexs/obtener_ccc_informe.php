<?php
session_start();
include '../conexion/conexion.php'; // Asegúrate de que este archivo define correctamente la variable de conexión

// Verifica la conexión
if ($conexion->connect_error) {
    die(json_encode(['error' => 'Conexión fallida: ' . $conexion->connect_error]));
}

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

$stmt = $conexion->prepare($sql);
if ($stmt === false) {
    die(json_encode(['error' => 'Error en la preparación de la consulta: ' . $conexion->error]));
}
$stmt->bind_param("i", $_SESSION["id"]);
$stmt->execute();
$result = $stmt->get_result();

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

$stmt->close();
$conexion->close(); // Asegúrate de usar la variable correcta para cerrar la conexión

header('Content-Type: application/json');
echo json_encode($data);
?>

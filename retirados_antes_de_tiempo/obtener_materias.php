<?php
// Incluir el archivo de conexión a la base de datos
include '../conexion/conexion.php';

// Obtener el ID de la carrera seleccionada enviado desde el cliente
$idCarrera = $_POST['carrera'];

// Consulta SQL para obtener las materias relacionadas con la carrera seleccionada
$sql = "SELECT idMaterias , Nombre,carreras_idCarrera FROM materias WHERE carreras_idCarrera = $idCarrera";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $sql);

// Verificar si se obtuvieron resultados
if ($resultado) {
    // Arreglo para almacenar las materias
    $materias = array();
    
    // Recorrer los resultados y guardar cada materia en el arreglo
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $materias[] = $fila;
    }
    
    // Devolver las materias en formato JSON
    echo json_encode(array('materias' => $materias));
} else {
    // Si hay un error en la consulta, devolver un mensaje de error
    echo json_encode(array('error' => 'Error al obtener las materias.'));
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

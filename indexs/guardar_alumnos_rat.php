<?php
session_start();
include '../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Establecer la zona horaria a Buenos Aires
    date_default_timezone_set('America/Argentina/Buenos_Aires');

    // Obtener el ID del profesor desde la sesión
    $profesor_id = $_SESSION['id'];

    $materia_id = $_POST['materia'];
    $curso_id = $_POST['curso'];
    $carrera_id = $_POST['carrera'];
    $comision_id = $_POST['comision'];
    $motivos = $_POST['motivo'];

    // Preparar la declaración para insertar datos
    $sql_insert = "INSERT INTO alumnos_rat (alumno_legajo, carreras_idCarrera, materias_idMaterias, profesor_idProrfesor, cursos_idcursos, comisiones_idComisiones, motivo, fecha) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, now())";
    $stmt_insert = $conexion->prepare($sql_insert);

    if (!$stmt_insert) {
        echo "Error en la preparación de la consulta: " . $conexion->error;
        exit;
    }

    // Insertar cada registro de asistencia
    foreach ($motivos as $legajo => $motivo) {
        $stmt_insert->bind_param("iiiiiss", $legajo, $carrera_id, $materia_id, $profesor_id, $curso_id, $comision_id, $motivo);
        $stmt_insert->execute();

        if ($stmt_insert->error) {
            echo "Error en la inserción: " . $stmt_insert->error;
            exit;
        }
    }

    // Redirigir a la página principal después de guardar
    header('Location: preceptor_1.php');
    exit();
}
?>

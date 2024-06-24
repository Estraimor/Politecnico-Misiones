<?php
include '../conexion/conexion.php';

if (isset($_POST['enviar'])) {
    $legajo = $_POST['selectAlumno'];
    $carrera = $_POST['carrera'];
    $motivo = $_POST['motivo'];
    $fecha = $_POST['fecha'];

    // Recoger materias seleccionadas en un array
    $materias = array($_POST['materia'], $_POST['materia2']);

    foreach ($materias as $materia) {
        // Asegurarse de que la materia no esté vacía antes de insertar
        if (!empty($materia)) {
            $sql_insertar = "INSERT INTO `alumnos_justificados` (
                                `idalumnos_justificados`, 
                                `inscripcion_asignatura_idinscripcion_asignatura`, 
                                `inscripcion_asignatura_alumno_legajo`, 
                                `materias_idMaterias`, 
                                `fecha`, 
                                `Motivo`
                             ) VALUES (
                                NULL, 
                                NULL, 
                                '$legajo', 
                                '$materia', 
                                '$fecha', 
                                '$motivo'
                             );";
            $query = mysqli_query($conexion, $sql_insertar);

            // Verificar si la consulta se ejecutó correctamente
            if (!$query) {
                die('Error: ' . mysqli_error($conexion));
            }
        }
    }

    // Redirigir después de la inserción
    header('Location: controlador_preceptor.php');
    exit;
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
 
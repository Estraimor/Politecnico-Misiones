<?php
include '../../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se solicita eliminar una materia
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        $legajo = mysqli_real_escape_string($conexion, $_POST['legajo']);
        $materia = mysqli_real_escape_string($conexion, $_POST['materia']);
        $curso = mysqli_real_escape_string($conexion, $_POST['curso']);

        // Eliminar la inscripción de la tabla `inscripcion_asignatura`
        $sql_eliminar = "DELETE FROM inscripcion_asignatura 
                         WHERE alumno_legajo = '$legajo' 
                           AND materias_idMaterias = '$materia' 
                           AND cursos_idcursos = '$curso'";
        $resultado_eliminar = mysqli_query($conexion, $sql_eliminar);

        if ($resultado_eliminar) {
            echo "Inscripción eliminada correctamente.";
        } else {
            echo "Error al eliminar la inscripción: " . mysqli_error($conexion);
        }
        exit; // Terminar la ejecución después de eliminar
    }

    // Inscripción de materias (mantener lógica existente)
    $legajo = mysqli_real_escape_string($conexion, $_POST['legajo']);
    $carrera = mysqli_real_escape_string($conexion, $_POST['carrera']);
    $curso = mysqli_real_escape_string($conexion, $_POST['curso']);
    $materias = isset($_POST['materias']) ? $_POST['materias'] : []; // Array de materias
    $comision = mysqli_real_escape_string($conexion, $_POST['comision']);
    $año_inscripcion = mysqli_real_escape_string($conexion, $_POST['Año_inscripcion']);

    // Verificar la carrera actual del estudiante
    $sql_carrera_actual = "
        SELECT m.carreras_idCarrera 
        FROM inscripcion_asignatura ia
        INNER JOIN materias m ON ia.materias_idMaterias = m.idMaterias
        WHERE ia.alumno_legajo = '$legajo'
        LIMIT 1
    ";
    $resultado_carrera_actual = mysqli_query($conexion, $sql_carrera_actual);

    if ($resultado_carrera_actual && mysqli_num_rows($resultado_carrera_actual) > 0) {
        $fila_carrera_actual = mysqli_fetch_assoc($resultado_carrera_actual);
        $carrera_actual = $fila_carrera_actual['carreras_idCarrera'];

        if ($carrera_actual != $carrera) {
            echo "El estudiante ya está inscrito en otra carrera y no puede inscribirse a esta.";
            exit;
        }
    }

    $errores = [];
    $exitos = [];

    foreach ($materias as $materiaId) {
        $sql_inscribir_materia = "INSERT INTO inscripcion_asignatura (cursos_idcursos, comisiones_idComisiones, materias_idMaterias, alumno_legajo, año_cursada) 
                                  VALUES ($curso, $comision, $materiaId, $legajo, $año_inscripcion)";
        $resultado_inscribir_materia = mysqli_query($conexion, $sql_inscribir_materia);

        if ($resultado_inscribir_materia) {
            $exitos[] = "Inscripción en materia ID: $materiaId exitosa.";
        } else {
            $errores[] = "Error al inscribir en materia ID: $materiaId: " . mysqli_error($conexion);
        }
    }

    if (!empty($exitos)) {
        echo implode("\n", $exitos) . "\n";
    }

    if (!empty($errores)) {
        echo implode("\n", $errores) . "\n";
    }

    if (empty($exitos) && empty($errores)) {
        echo "No se seleccionaron materias para inscribir.";
    }
} else {
    echo "Método no permitido.";
}
?>

<?php
include '../../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $legajo = mysqli_real_escape_string($conexion, $_POST['legajo']);
    $carrera = mysqli_real_escape_string($conexion, $_POST['carrera']);
    $curso = mysqli_real_escape_string($conexion, $_POST['curso']);
    $materias = $_POST['materias']; // Array de materias
    $comision = mysqli_real_escape_string($conexion, $_POST['comision']);
    $año_inscripcion = mysqli_real_escape_string($conexion, $_POST['año_inscripcion']);

    $errores = [];
    $exitos = [];

    foreach ($materias as $materiaId => $materia) {
        if ($materia != '0') { // Si la materia no es "No cursa"
            $sql_inscribir_materia = "INSERT INTO inscripcion_asignatura (cursos_idcursos, comisiones_idComisiones, materias_idMaterias, alumno_legajo, año_cursada) 
                                      VALUES ($curso, $comision, $materia, $legajo, $año_inscripcion)";
            $resultado_inscribir_materia = mysqli_query($conexion, $sql_inscribir_materia);

            if ($resultado_inscribir_materia) {
                $exitos[] = "Inscripción en materia ID: $materia exitosa.";
            } else {
                $errores[] = "Error al inscribir en materia ID: $materia: " . mysqli_error($conexion);
            }
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

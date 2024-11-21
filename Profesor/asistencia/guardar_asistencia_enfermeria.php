<?php
include '../../conexion/conexion.php';

// Configuramos el huso horario a Argentina (Misiones)
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['materia1']) && !empty($_POST['asistencia'])) {
        // Obtener datos desde el formulario
        $materia1 = $_POST['materia1'];
        $curso = $_POST['curso'];
        $carrera = $_POST['idcarrera'];
        $comision = $_POST['comision'];
        $horaArgentina = date('Y-m-d H:i:s'); // Fecha y hora actual en formato MySQL
        $asistencias = $_POST['asistencia']; // Array con la asistencia de cada estudiante

        // Array para almacenar estudiantes con la misma asistencia
        $estudiantes_misma_asistencia = [];

        foreach ($asistencias as $legajo => $estadoAsistencia) {
            // Validar que el estado de asistencia sea válido (1 o 2)
            if (in_array($estadoAsistencia, ['1', '2'])) {
                // Verificar si ya existe un registro de asistencia para este estudiante
                $sql_check = "
                    SELECT asistencia 
                    FROM asistencia 
                    WHERE 
                        inscripcion_asignatura_alumno_legajo = '$legajo' AND 
                        carreras_idCarrera = '$carrera' AND 
                        materias_idMaterias = '$materia1' AND 
                        cursos_idcursos = '$curso' AND 
                        comisiones_idComisiones = '$comision' AND 
                        DATE(fecha) = CURDATE()
                ";
                $query_check = mysqli_query($conexion, $sql_check);
                $registro_existente = mysqli_fetch_assoc($query_check);

                if ($registro_existente) {
                    // Si ya existe un registro, verificar el estado actual
                    $estado_actual = $registro_existente['asistencia'];

                    if ($estado_actual != $estadoAsistencia) {
                        // Actualizar si el estado cambió (de Presente a Ausente o viceversa)
                        $sql_update = "
                            UPDATE asistencia 
                            SET asistencia = '$estadoAsistencia', fecha = '$horaArgentina' 
                            WHERE 
                                inscripcion_asignatura_alumno_legajo = '$legajo' AND 
                                carreras_idCarrera = '$carrera' AND 
                                materias_idMaterias = '$materia1' AND 
                                cursos_idcursos = '$curso' AND 
                                comisiones_idComisiones = '$comision' AND 
                                DATE(fecha) = CURDATE()
                        ";
                        mysqli_query($conexion, $sql_update);
                    } else {
                        // Si el estado es el mismo, añadir al array para mostrar alerta
                        $estudiantes_misma_asistencia[] = $legajo;
                    }
                } else {
                    // Si no existe registro, insertar nuevo
                    $sql_insert = "
                        INSERT INTO asistencia (
                            fecha, 
                            inscripcion_asignatura_alumno_legajo, 
                            carreras_idCarrera, 
                            materias_idMaterias, 
                            asistencia, 
                            cursos_idcursos, 
                            comisiones_idComisiones
                        ) 
                        VALUES (
                            '$horaArgentina', 
                            '$legajo', 
                            '$carrera', 
                            '$materia1', 
                            '$estadoAsistencia', 
                            '$curso', 
                            '$comision'
                        )
                    ";
                    mysqli_query($conexion, $sql_insert);
                }
            }
        }

        // Si hay estudiantes con la misma asistencia, mostrar alerta
        if (!empty($estudiantes_misma_asistencia)) {
            $estudiantes = implode(', ', $estudiantes_misma_asistencia);
            echo "<script>
                alert('Los siguientes estudiantes ya tienen la misma asistencia: $estudiantes');
                window.location.href='../../indexs/controlador_preceptor.php';
            </script>";
        } else {
            // Redirigir después de guardar
            header('Location: ../../indexs/controlador_preceptor.php');
        }
        exit;
    } else {
        // Si faltan datos obligatorios, redirigir con mensaje de error
        header('Location: ../../indexs/controlador_preceptor.php?error=Faltan datos obligatorios');
        exit;
    }
} else {
    // Si se accede directamente sin enviar el formulario, redirigir
    header('Location: ../../indexs/controlador_preceptor.php');
    exit;
}
?>

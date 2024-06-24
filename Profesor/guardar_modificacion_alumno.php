<?php
include '../conexion/conexion.php';

if (isset($_POST['Enviar'])) {
    $legajo = $_POST['legajo'];
    $nombre_alumno = mysqli_real_escape_string($conexion, $_POST['nombre_alumno']);
    $apellido_alumno = mysqli_real_escape_string($conexion, $_POST['apellido_alumno']);
    $dni_alumno = mysqli_real_escape_string($conexion, $_POST['dni_alumno']);
    $celular = mysqli_real_escape_string($conexion, $_POST['celular']);
    $edad = mysqli_real_escape_string($conexion, $_POST['edad']);
    $observaciones = mysqli_real_escape_string($conexion, $_POST['observaciones']);
    $trabaja_horario = mysqli_real_escape_string($conexion, $_POST['Trabaja_Horario']);
    $año_cursada = mysqli_real_escape_string($conexion, $_POST['Año_cursada']);
    $comision = mysqli_real_escape_string($conexion, $_POST['Comision']);
    $carreras = mysqli_real_escape_string($conexion, $_POST['carreras']);
    $materias = $_POST['materias'];

    // Actualizar datos del alumno
    $sql_update_alumno = "UPDATE alumno SET nombre_alumno='$nombre_alumno', apellido_alumno='$apellido_alumno', dni_alumno='$dni_alumno', 
                          celular='$celular', edad='$edad', observaciones='$observaciones', Trabaja_Horario='$trabaja_horario'
                          WHERE legajo='$legajo'";
    $resultado_update_alumno = mysqli_query($conexion, $sql_update_alumno);

    if ($resultado_update_alumno) {
        echo "Datos del alumno actualizados.\n";
    } else {
        echo "Error al actualizar los datos del alumno: " . mysqli_error($conexion) . "\n";
    }

    // Eliminar inscripciones anteriores si se cambió de carrera
    $sql_delete_inscripciones = "DELETE FROM inscripcion_asignatura WHERE alumno_legajo='$legajo'";
    $resultado_delete_inscripciones = mysqli_query($conexion, $sql_delete_inscripciones);

    // Insertar nuevas inscripciones de materias
    foreach ($materias as $curso => $materias_curso) {
        foreach ($materias_curso as $materia_id) {
            if ($materia_id != '0') {
                $sql_insert_materia = "INSERT INTO inscripcion_asignatura (cursos_idcursos, comisiones_idComisiones, materias_idMaterias, alumno_legajo, año_cursada)
                                       VALUES ('$curso', '$comision', '$materia_id', '$legajo', '$año_cursada')";
                $resultado_insert_materia = mysqli_query($conexion, $sql_insert_materia);

                if ($resultado_insert_materia) {
                    header("Location: controlador_preceptormodificar.php");
                } else {
                    echo "Error al inscribir en materia ID: $materia_id: " . mysqli_error($conexion) . "\n";
                }
            }
        }
    }
}
?>

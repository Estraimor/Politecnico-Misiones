<?php
include '../../conexion/conexion.php';

if (isset($_POST['Enviar'])) {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre_alumno'];
    $apellido = $_POST['apellido_alumno'];
    $dni = $_POST['dni_alumno'];
    $celular = $_POST['celular'];
    $legajo = $_POST['legajo'];
    $observaciones = $_POST['observaciones'];
    $trabaja = $_POST['Trabaja_Horario'];
    $carreras = array($_POST['carreras_1'], $_POST['carreras_2'], $_POST['carreras_3'], $_POST['carreras_4']);

    // Actualizar los datos del alumno en la tabla alumnos_fp
    $sql_alumno = "UPDATE alumnos_fp 
                   SET nombre_afp = '$nombre', apellido_afp = '$apellido', dni_afp = '$dni', celular_afp = '$celular', 
                       observaciones_afp = '$observaciones', trabaja_fp = '$trabaja'
                   WHERE legajo_afp = '$legajo'";

    $query_alumno = mysqli_query($conexion, $sql_alumno);

    if ($query_alumno) {
        // Eliminar las carreras actuales del alumno en la tabla alumnos_fp_has_carreras
        $sql_delete_carreras = "DELETE FROM alumnos_fp_has_carreras WHERE alumnos_fp_legajo_afp = '$legajo'";
        mysqli_query($conexion, $sql_delete_carreras);

        // Insertar las nuevas carreras del alumno
        foreach ($carreras as $carrera) {
            if (!empty($carrera) && $carrera != '65') {
                $sql_insert_carrera = "INSERT INTO alumnos_fp_has_carreras (alumnos_fp_legajo_afp, carreras_idCarrera) VALUES ('$legajo', '$carrera')";
                mysqli_query($conexion, $sql_insert_carrera);
            }
        }

        echo "Datos del alumno actualizados correctamente.";
        header("Location: ../../Profesor/controlador_preceptormodificar.php");
        exit();
    } else {
        echo "Error al actualizar los datos del alumno: " . mysqli_error($conexion);
    }
}
?>

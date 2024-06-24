<?php
include '../../conexion/conexion.php';

if (isset($_POST['enviar'])) {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $celular = $_POST['celular'];
    $legajo = $_POST['legajo'];
    $observaciones = $_POST['observaciones'];
    $trabaja = $_POST['trabaja'];
    $fp1 = !empty($_POST['FP1']) ? $_POST['FP1'] : null;
    $fp2 = !empty($_POST['FP2']) ? $_POST['FP2'] : null;
    $fp3 = !empty($_POST['FP3']) ? $_POST['FP3'] : null;
    $fp4 = !empty($_POST['FP4']) ? $_POST['FP4'] : null;

    // Insertar los datos en la tabla de alumnos_fp
    $sql_alumno = "INSERT INTO alumnos_fp (legajo_afp, nombre_afp, apellido_afp, dni_afp, celular_afp, observaciones_afp, trabaja_fp, estado) 
                   VALUES ('$legajo', '$nombre', '$apellido', '$dni', '$celular', '$observaciones', '$trabaja', 1)";

    $query_alumno = mysqli_query($conexion, $sql_alumno);

    if ($query_alumno) {
        echo "Datos del alumno guardados correctamente.";

        // Insertar las carreras seleccionadas en la tabla alumnos_fp_has_carreras
        $carreras = array($fp1, $fp2, $fp3, $fp4);
        foreach ($carreras as $carrera) {
            if ($carrera !== null) {
                // Verificar si la combinación de legajo_afp y carreras_idCarrera ya existe
                $sql_check = "SELECT * FROM alumnos_fp_has_carreras WHERE alumnos_fp_legajo_afp = '$legajo' AND carreras_idCarrera = '$carrera'";
                $query_check = mysqli_query($conexion, $sql_check);

                if (mysqli_num_rows($query_check) == 0) {
                    // Solo insertar si no existe
                    $sql_carrera = "INSERT INTO alumnos_fp_has_carreras (alumnos_fp_legajo_afp, carreras_idCarrera) VALUES ('$legajo', '$carrera')";
                    $query_carrera = mysqli_query($conexion, $sql_carrera);

                    if (!$query_carrera) {
                        echo "Error al guardar la carrera: " . mysqli_error($conexion);
                    }
                } else {
                    echo "La combinación de legajo y carrera ya existe: $legajo - $carrera<br>";
                }
            }
        }

        // Redirigir a la página de nuevo_alumnofp.php
        header("Location: ../../Profesor/controlador_preceptormodificar.php");
        exit();
    } else {
        echo "Error al guardar los datos del alumno: " . mysqli_error($conexion);
    }
}
?>

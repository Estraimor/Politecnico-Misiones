<?php
include'../../conexion/conexion.php';

if (isset($_POST['Enviar'])) {
    $nombre = $_POST['nombre_alumno'];
    $apellido = $_POST['apellido_alumno'];
    $dni = $_POST['dni_alumno'];
    $celular = $_POST['celular'];
    $legajo = $_POST['legajo'];
    $observacioness = $_POST['observaciones'];
    $trabaja_HS = $_POST['Trabaja_Horario'];
    $carrera = $_POST['carreras_1'];
    $carrera1 = $_POST['carreras_2'];
    $carrera2 = $_POST['carreras_3'];
    $carrera3 = $_POST['carreras_4'];
    
    
   $sql = "UPDATE alumnos_fp SET nombre_afp = '$nombre', apellido_afp = '$apellido',
        dni_afp = '$dni', celular_afp = '$celular', legajo_afp = '$legajo',
        observaciones_afp = '$observacioness', trabaja_fp = '$trabaja_HS',
        carreras_idCarrera = '$carrera', carreras_idCarrera1 = '$carrera1',
        carreras_idCarrera2 = '$carrera2', carreras_idCarrera3 = '$carrera3'
        WHERE legajo_afp  = '$legajo';";


    $query = mysqli_query($conexion, $sql);

    if ($query) {
        echo "El registro ha sido actualizado correctamente.";
    } else {
        echo "Error al actualizar el registro: " . mysqli_error($conexion);
    }

    header('Location: ../../Profesor/controlador_preceptormodificar.php');
}
?>

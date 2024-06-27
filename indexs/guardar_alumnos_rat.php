<?php
include '../conexion/conexion.php';

// Verificar si el formulario fue enviado
if (isset($_POST['enviar'])) {
    // Obtener y sanitizar los datos del formulario
    $legajo = $conexion->real_escape_string($_POST['selectAlumno']);
    $carrera = $conexion->real_escape_string($_POST['carrera']);
    $motivo = $conexion->real_escape_string($_POST['motivo']);
    $materia = $conexion->real_escape_string($_POST['materia']);
    $fecha = $conexion->real_escape_string($_POST['fecha']);
    $profe = $conexion->real_escape_string($_POST['profesor']);
    $curso = $conexion->real_escape_string($_POST['curso']);
    $comision = $conexion->real_escape_string($_POST['comision']);
    
    // Construir la consulta SQL para insertar los datos en la tabla alumnos_rat
    $sql_insertar = "INSERT INTO alumnos_rat (
                        alumno_legajo, 
                        carreras_idCarrera, 
                        materias_idMaterias, 
                        profesor_idProrfesor, 
                        motivo, 
                        fecha,
                        cursos_idcursos,
                        comisiones_idComisiones
                     ) VALUES (
                        '$legajo', 
                        '$carrera', 
                        '$materia', 
                        '$profe', 
                        '$motivo', 
                        '$fecha',
                        '$curso',
                        '$comision'
                     )";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $sql_insertar)) {
        // Redirigir después de la inserción exitosa
        header('Location: controlador_preceptor.php');
    } else {
        // Mostrar un mensaje de error si la consulta falla
        echo "Error: " . $sql_insertar . "<br>" . mysqli_error($conexion);
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

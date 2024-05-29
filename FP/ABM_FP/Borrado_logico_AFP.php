<?php
include '../../conexion/conexion.php';

// Verificar si se recibió el legajo
if(isset($_GET['legajo'])) {
    // Obtener el legajo y preparar la consulta
    $legajo = $_GET['legajo'];
    $sql = "UPDATE alumnos_fp SET estado = '2' WHERE legajo_afp  = ?";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $legajo);
    
    // Ejecutar la consulta
    if(mysqli_stmt_execute($stmt)) {
        // Redirigir a la página de inicio después de realizar el borrado lógico
        header('Location: ../../Profesor/controlador_preceptormodificar.php');
        exit; // Salir del script después de redirigir
    } else {
        // Manejar el error si la consulta no se ejecuta correctamente
        echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
    }

    // Cerrar la consulta preparada
    mysqli_stmt_close($stmt);
} else {
    // Manejar el caso en el que no se recibió el legajo
    echo "No se recibió el legajo.";
}


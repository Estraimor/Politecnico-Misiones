<?php
include '../conexion/conexion.php';

if (isset($_POST['enviar'])) {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $celular = $_POST['celular'];
    $legajo = $_POST['legajo'];
    $observaciones = $_POST['observaciones'];
    $trabaja = $_POST['trabaja'];
    $fp1 = isset($_POST['FP1']) ? $_POST['FP1'] : null; // Si FP1 no se seleccionó, establecer NULL
    $fp2 = isset($_POST['FP2']) ? $_POST['FP2'] : null; // Si FP2 no se seleccionó, establecer NULL
    $fp3 = isset($_POST['FP3']) ? $_POST['FP3'] : null; // Si FP3 no se seleccionó, establecer NULL
    $fp4 = isset($_POST['FP4']) ? $_POST['FP4'] : null; // Si FP4 no se seleccionó, establecer NULL

    echo "FP1: " . ($fp1 ?? 'NULL') . "<br>"; // Mostrar 'NULL' si $fp1 es null
    echo "FP2: " . ($fp2 ?? 'NULL') . "<br>"; // Mostrar 'NULL' si $fp2 es null
    echo "FP3: " . ($fp3 ?? 'NULL') . "<br>"; // Mostrar 'NULL' si $fp3 es null
    echo "FP4: " . ($fp4 ?? 'NULL') . "<br>"; // Mostrar 'NULL' si $fp4 es null

 //Insertar los datos en la tabla de la base de datos
     $sql = "INSERT INTO alumnos_fp (legajo_afp, nombre_afp, apellido_afp, dni_afp, celular_afp, observaciones_afp, trabaja_fp, carreras_idCarrera, carreras_idCarrera1, carreras_idCarrera2, carreras_idCarrera3) 
            VALUES ('$legajo', '$nombre', '$apellido', '$dni', '$celular', '$observaciones', '$trabaja', $fp1, $fp2, $fp3, $fp4)";
    
    $query = mysqli_query($conexion, $sql);
    
     if ($query) {
         echo "Datos guardados correctamente.";
       // Redirigir a la página de nuevo_alumnofp.php
         header("Location: ../Profesor/controlador_preceptormodificar.php");
         exit();
     } else {
         echo "Error al guardar los datos: " . mysqli_error($conexion);
     }
 }
?>

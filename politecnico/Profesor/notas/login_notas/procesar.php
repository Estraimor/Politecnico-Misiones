<?php
include '../../../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado datos del formulario
    if (isset($_POST['enviar'])) {
        // Recuperar los datos del formulario
        $tp1 = $_POST['tp1'];
        $tp2 = $_POST['tp2'];
        $parcial1 = $_POST['parcial1'];
        $tp3 = $_POST['tp3'];
        $tp4 = $_POST['tp4'];
        $parcial2 = $_POST['parcial2'];
        $condicion = $_POST['condicion'];
        $legajo = $_POST['legajo'];
        $materia = $_POST['materia'];
        $mesa_de_examen = $_POST['Mesa_final'];

      // Verificar si la conexión fue exitosa
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Iterar sobre los datos del formulario
foreach ($_POST['legajo'] as $index => $valor) {
    // Verificar si existen datos para el alumno y la materia en la tabla finales
    $sql_verificar = "SELECT * FROM finales WHERE alumno_legajo = '$valor' AND materias_idMaterias = '$materia'";
    $query_verificar = mysqli_query($conexion, $sql_verificar);

    // Verificar si la consulta fue exitosa
    if (!$query_verificar) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    // Obtener el número de filas
    $num_rows = mysqli_num_rows($query_verificar);

    if ($num_rows > 0) {
        // Realizar actualización (UPDATE)
        $sql_update = "UPDATE finales 
                       SET tp_1 = '{$tp1[$index]}', 
                           tp_2 = '{$tp2[$index]}', 
                           parcial_1 = '{$parcial1[$index]}', 
                           to_3 = '{$tp3[$index]}',
                           tp_4 = '{$tp4[$index]}', 
                           parcial_2 = '{$parcial2[$index]}', 
                           condicion_materia_idcondicion_materia = '{$condicion[$index]}', 
                           mesa_final = '{$mesa_de_examen[$index]}' 
                       WHERE alumno_legajo = '$valor' AND materias_idMaterias = '$materia'";
        $query_update = mysqli_query($conexion, $sql_update);
        header("Location: index_nota.php");
        // Verificar si la actualización fue exitosa
        if (!$query_update) {
            die("Error en la actualización: " . mysqli_error($conexion));
        }
    } else {
        // Realizar inserción (INSERT)
        $sql_insert = "INSERT INTO finales (alumno_legajo, materias_idMaterias, tp_1, tp_2, parcial_1, to_3, tp_4, parcial_2, condicion_materia_idcondicion_materia, mesa_final) 
                       VALUES ('$valor', '$materia', '{$tp1[$index]}', '{$tp2[$index]}', '{$parcial1[$index]}', '{$tp3[$index]}', '{$tp4[$index]}', '{$parcial2[$index]}', '1', '{$mesa_de_examen[$index]}')";
        $query_insert = mysqli_query($conexion, $sql_insert);
        header("Location: index_nota.php");

        // Verificar si la inserción fue exitosa
        if (!$query_insert) {
            die("Error en la inserción: " . mysqli_error($conexion));
        }
    }
}
    }}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>


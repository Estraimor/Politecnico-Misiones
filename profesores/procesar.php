<?php
include '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado datos del formulario
    if (isset($_POST['enviar'])) {
        // Recuperar los datos del formulario
        $tp1 = $_POST['tp1'];
        $tp2 = $_POST['tp2'];
        $parcial1 = $_POST['parcial1'];
        $recuperatorio1 = $_POST['recuperatorio1'];
        $tp3 = $_POST['tp3'];
        $tp4 = $_POST['tp4'];
        $parcial2 = $_POST['parcial2'];
        $recuperatorio2 = $_POST['recuperatorio2'];
        $condicion = $_POST['condicion'];
        $legajo = $_POST['legajo'];
        $materia = $_POST['materia'];
        $mesa_de_examen = $_POST['Mesa_final'];
        $carrera = $_POST['carrera'];

        // Iterar sobre los datos del formulario
        foreach ($legajo as $index => $valor) {
            // Verificar si el alumno está inscrito en la materia y carrera seleccionadas
            $sql_verificar = "SELECT * FROM inscripcion_asignatura ia WHERE ia.alumno_legajo = '$valor' AND ia.carreras_idCarrera = '$carrera';";
            $query_verificar = mysqli_query($conexion, $sql_verificar);

            // Verificar si la consulta fue exitosa
            if (!$query_verificar) {
                die("Error en la consulta: " . mysqli_error($conexion));
            }

            // Verificar si el alumno está inscrito en la materia y carrera seleccionadas
            $num_rows = mysqli_num_rows($query_verificar);

            if ($num_rows > 0) {
                // Verificar si el alumno ya tiene notas registradas para esta materia
                $sql_verificar_notas = "SELECT * FROM finales WHERE alumno_legajo = '$valor' AND materias_idMaterias = '$materia'";
                $query_verificar_notas = mysqli_query($conexion, $sql_verificar_notas);

                // Verificar si la consulta fue exitosa
                if (!$query_verificar_notas) {
                    die("Error en la consulta: " . mysqli_error($conexion));
                }

                // Obtener el número de filas
                $num_rows_notas = mysqli_num_rows($query_verificar_notas);

                if ($num_rows_notas > 0) {
                    // Realizar actualización (UPDATE)
                    $sql_update = "UPDATE finales 
                                   SET tp_1 = '{$tp1[$index]}', 
                                       tp_2 = '{$tp2[$index]}', 
                                       parcial_1 = '{$parcial1[$index]}', 
                                       recuperatorio1 = '{$recuperatorio1[$index]}',
                                       to_3 = '{$tp3[$index]}',
                                       tp_4 = '{$tp4[$index]}', 
                                       parcial_2 = '{$parcial2[$index]}', 
                                        recuperatorio2 = '{$recuperatorio2[$index]}',
                                       condicion_materia_idcondicion_materia = '{$condicion[$index]}', 
                                       mesa_final = '{$mesa_de_examen[$index]}' 
                                   WHERE alumno_legajo = '$valor' AND materias_idMaterias = '$materia'";
                    $query_update = mysqli_query($conexion, $sql_update);

                    // Verificar si la actualización fue exitosa
                    if (!$query_update) {
                        die("Error en la actualización: " . mysqli_error($conexion));
                    }
                } else {
                    // Realizar inserción (INSERT)
                    $sql_insert = "INSERT INTO finales (alumno_legajo, materias_idMaterias, tp_1, tp_2, parcial_1,recuperatorio1, to_3, tp_4, parcial_2,recuperatorio2, condicion_materia_idcondicion_materia, mesa_final) 
                                   VALUES ('$valor', '$materia', '{$tp1[$index]}', '{$tp2[$index]}', '{$parcial1[$index]}','{$recuperatorio1[$index]}', '{$tp3[$index]}', '{$tp4[$index]}', '{$parcial2[$index]}','{$recuperatorio2[$index]}', '1', '{$mesa_de_examen[$index]}')";
                    $query_insert = mysqli_query($conexion, $sql_insert);

                    // Verificar si la inserción fue exitosa
                    if (!$query_insert) {
                        die("Error en la inserción: " . mysqli_error($conexion));
                        
                    }
                }
            } else {
                // El alumno no está inscrito en la materia y carrera seleccionadas
                echo "El alumno con legajo $valor no está inscrito en la materia y carrera seleccionadas.";
                // Aquí puedes agregar el código para manejar esta situación, como redirigir a otra página o mostrar un mensaje de error.
            }
        }

        // Redirigir después de procesar los datos
        header("Location: index-p.php");
        exit(); // Terminar la ejecución del script después de redirigir
    }
}

// Cerrar la conexión a la

?>

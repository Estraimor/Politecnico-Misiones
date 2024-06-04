<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$bd = 'u756746073_politecnico';
$conexion = mysqli_connect($server, $user, $pass, $bd, '3306');

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
    echo "<script>console.log('Error de conexión: " . mysqli_connect_error() . "');</script>";
}

if (isset($_POST['enviar'])) {
    $nombre_alu = mysqli_real_escape_string($conexion, $_POST['nombre_alu']);
    $apellido_alu = mysqli_real_escape_string($conexion, $_POST['apellido_alu']);
    $dni_alu = mysqli_real_escape_string($conexion, $_POST['dni_alu']);
    $legajo = mysqli_real_escape_string($conexion, $_POST['legajo']);
    $celular = mysqli_real_escape_string($conexion, $_POST['celular']);
    $fecha_nacimiento = mysqli_real_escape_string($conexion, $_POST['edad']);
    $observaciones = mysqli_real_escape_string($conexion, $_POST['observaciones']);
    $trabajo_hs = mysqli_real_escape_string($conexion, $_POST['Trabajo_Horario']);
    $inscripcion_carrera = mysqli_real_escape_string($conexion, $_POST['inscripcion_carrera']);
    $comision = mysqli_real_escape_string($conexion, $_POST['Comision']);
    $año_cursada = mysqli_real_escape_string($conexion, $_POST['Año_inscripcion']); // Añadir el año de cursada

    // Inserción del alumno
    $sql_insertar_alumno = "INSERT INTO alumno (nombre_alumno, apellido_alumno, dni_alumno, legajo, Trabaja_Horario, edad, observaciones, celular, estado) 
                            VALUES ('$nombre_alu', '$apellido_alu', '$dni_alu', '$legajo', '$trabajo_hs', '$fecha_nacimiento', '$observaciones', '$celular', '1')";
    $resultado_insertar_alumno = mysqli_query($conexion, $sql_insertar_alumno);

    if ($resultado_insertar_alumno) {
        echo "<script>console.log('Alumno registrado con éxito.');</script>";

        // Obtención de las materias de la carrera
        $sql_materias = "SELECT idMaterias FROM materias WHERE carreras_idCarrera = $inscripcion_carrera";
        $result_materias = mysqli_query($conexion, $sql_materias);

        if ($result_materias) {
            if (mysqli_num_rows($result_materias) > 0) {
                $materia = mysqli_fetch_assoc($result_materias);
                do {
                    echo "<script>console.log('Procesando materia ID: " . $materia['idMaterias'] . "');</script>";

                    $sql_inscribir_materia = "INSERT INTO inscripcion_asignatura (cursos_idcursos, comisiones_idComisiones, materias_idMaterias, alumno_legajo, año_cursada) 
                                              VALUES ('1', $comision, " . $materia['idMaterias'] . ", $legajo, $año_cursada)";
                    $resultado_inscribir_materia = mysqli_query($conexion, $sql_inscribir_materia);

                    if ($resultado_inscribir_materia) {
                        echo "<script>console.log('Inscripción en materia exitosa para materia ID: " . $materia['idMaterias'] . "');</script>";
                    } else {
                        echo "<script>console.log('Error al inscribir en materia: " . mysqli_error($conexion) . "');</script>";
                    }

                    $materia = mysqli_fetch_assoc($result_materias);
                } while ($materia);
            } else {
                echo "<script>console.log('No se encontraron materias para la carrera ID: " . $inscripcion_carrera . "');</script>";
            }
        } else {
            echo "<script>console.log('Error al obtener materias: " . mysqli_error($conexion) . "');</script>";
        }
    } else {
        echo "Error al insertar el alumno: " . mysqli_error($conexion);
        echo "<script>console.log('Error al insertar el alumno: " . mysqli_error($conexion) . "');</script>";
    }
}
?>

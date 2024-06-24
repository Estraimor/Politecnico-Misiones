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
    $legajo = mysqli_real_escape_string($conexion, $_POST['legajo']);
    $nombre_alu = mysqli_real_escape_string($conexion, $_POST['nombre_alu']);
    $apellido_alu = mysqli_real_escape_string($conexion, $_POST['apellido_alu']);
    $dni_alu = mysqli_real_escape_string($conexion, $_POST['dni_alu']);
    $celular = mysqli_real_escape_string($conexion, $_POST['celular']);
    $edad = mysqli_real_escape_string($conexion, $_POST['edad']);
    $observaciones = mysqli_real_escape_string($conexion, $_POST['observaciones']);
    $trabajo_hs = mysqli_real_escape_string($conexion, $_POST['Trabajo_Horario']);
    $inscripcion_carrera = mysqli_real_escape_string($conexion, $_POST['inscripcion_carrera']);
    $comision = mysqli_real_escape_string($conexion, $_POST['Comision']);
    $año_inscripcion = mysqli_real_escape_string($conexion, $_POST['Año_inscripcion']);


    $fecha_nacimiento = $_POST['edad'];

    // Convertir la fecha de nacimiento a un objeto DateTime
    $fecha_nacimiento_dt = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);

    // Verificar si se creó correctamente el objeto DateTime
    if ($fecha_nacimiento_dt instanceof DateTime) {
        // Obtener la fecha actual
        $fecha_actual = new DateTime();

        // Calcular la diferencia en años entre la fecha actual y la fecha de nacimiento
        $diff = $fecha_actual->diff($fecha_nacimiento_dt);

        // Calcular la edad restando el año de nacimiento del año actual
        $edad = $fecha_actual->format('Y') - $fecha_nacimiento_dt->format('Y');

        // Verificar si la fecha de nacimiento ya ha ocurrido este año
        if ($fecha_actual < $fecha_nacimiento_dt->add(new DateInterval('P'.$edad.'Y'))) {
            $edad--;
        }

        // Imprimir la edad
    } else {
        // Si $fecha_nacimiento_dt no es un objeto DateTime válido
    }


    // Insertar el nuevo alumno
    $sql_insertar_alumno = "INSERT INTO alumno (nombre_alumno, apellido_alumno, dni_alumno, legajo, Trabaja_Horario, edad, observaciones, celular, estado) 
                            VALUES ('$nombre_alu', '$apellido_alu', '$dni_alu', '$legajo', '$trabajo_hs', '$edad', '$observaciones', '$celular', '1')";
    $resultado_insertar_alumno = mysqli_query($conexion, $sql_insertar_alumno);

    if ($resultado_insertar_alumno) {
        echo "<script>console.log('Alumno registrado con éxito.');</script>";

        // Obtener las materias del primer año de la carrera
        $sql_materias_primer_anio = "SELECT idMaterias FROM materias WHERE carreras_idCarrera = $inscripcion_carrera AND idMaterias IN (SELECT materias_idMaterias FROM cursos_has_materias WHERE cursos_idcursos = 1)";
        $result_materias = mysqli_query($conexion, $sql_materias_primer_anio);

        if ($result_materias) {
            if (mysqli_num_rows($result_materias) > 0) {
                while ($materia = mysqli_fetch_assoc($result_materias)) {
                    echo "<script>console.log('Procesando materia ID: " . $materia['idMaterias'] . "');</script>";

                    $sql_inscribir_materia = "INSERT INTO inscripcion_asignatura (cursos_idcursos, comisiones_idComisiones, materias_idMaterias, alumno_legajo, año_cursada) 
                                              VALUES ('1', $comision, " . $materia['idMaterias'] . ", $legajo, $año_inscripcion)";
                    $resultado_inscribir_materia = mysqli_query($conexion, $sql_inscribir_materia);

                    if ($resultado_inscribir_materia) {
                        echo "<script>console.log('Inscripción en materia exitosa para materia ID: " . $materia['idMaterias'] . "');</script>";
                    } else {
                        echo "<script>console.log('Error al inscribir en materia: " . mysqli_error($conexion) . "');</script>";
                    }
                }
            } else {
                echo "<script>console.log('No se encontraron materias para el primer año de la carrera ID: " . $inscripcion_carrera . "');</script>";
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

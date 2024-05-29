<?php
include '../../conexion/conexion.php';

// Configuramos el huso horario a Argentina (Misiones)
date_default_timezone_set('America/Argentina/Buenos_Aires');

if (isset($_POST['Enviar'])) {
    if (!empty($_POST['presentePrimera']) || !empty($_POST['ausentePrimera']) || !empty($_POST['justificadaPrimera']) || !empty($_POST['idcarrera']) || !empty($_POST['materia1']) || !empty($_POST['materia2'])) {
        $idasignatura = $_POST['idcarrera'];
        $materia1 = $_POST['materia1'];

        // Obtenemos la hora actual en formato de MySQL
        $horaArgentina = date('Y-m-d H:i:s');

        if (!empty($_POST['presentePrimera'])) {
            $presentes = $_POST['presentePrimera'];
            foreach ($presentes as $legajo) {
                $sql = "INSERT INTO asistencia_FP (alumnos_fp_legajo_afp , carreras_idCarrera , materias_idMaterias , 1_horario, fecha_FP) 
                        VALUES ('$legajo', '$idasignatura', '$materia1', 'Presente', '$horaArgentina')";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['ausentePrimera'])) {
            $ausentes = $_POST['ausentePrimera'];
            foreach ($ausentes as $legajo) {
                $sql = "INSERT INTO asistencia_FP (alumnos_fp_legajo_afp , carreras_idCarrera , materias_idMaterias , 1_horario, fecha_FP) 
                VALUES ('$legajo', '$idasignatura', '$materia1', 'Ausente', '$horaArgentina')";
                $query = mysqli_query($conexion, $sql);
            }
        }
        
       

    }

    header('Location: ../../Profesor/controlador_preceptormodificar.php');
}
?>

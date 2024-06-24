<?php
include '../../conexion/conexion.php';

// Configuramos el huso horario a Argentina (Misiones)
date_default_timezone_set('America/Argentina/Buenos_Aires');

if (isset($_POST['Enviar'])) {
    if (!empty($_POST['presentePrimera']) || !empty($_POST['ausentePrimera']) || !empty($_POST['idcarrera']) || !empty($_POST['materia1']) || !empty($_POST['materia2'])) {
        $idasignatura = $_POST['idcarrera'];
        $materia1 = $_POST['materia1'];
        $materia2 = $_POST['materia2'];

        // Obtenemos la hora actual en formato de MySQL
        $horaArgentina = date('Y-m-d H:i:s');

        // Obtenemos los datos adicionales desde el formulario
        $curso = $_POST['curso'];
        $carrera = $_POST['idcarrera'];
        $comision = $_POST['comision'];

        if (!empty($_POST['presentePrimera'])) {
            $presentes = $_POST['presentePrimera'];
            foreach ($presentes as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, carreras_idCarrera, materias_idMaterias, asistencia, cursos_idcursos, comisiones_idComisiones) 
                        VALUES ('$horaArgentina', '$legajo', '$carrera', '$materia1', 'Presente', '$curso', '$comision')";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['ausentePrimera'])) {
            $ausentes = $_POST['ausentePrimera'];
            foreach ($ausentes as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, carreras_idCarrera, materias_idMaterias, asistencia, cursos_idcursos, comisiones_idComisiones) 
                        VALUES ('$horaArgentina', '$legajo', '$carrera', '$materia1', 'Ausente', '$curso', '$comision')";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['justificadaPrimera'])) {
            $justificada = $_POST['justificadaPrimera'];
            foreach ($justificada as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, carreras_idCarrera, materias_idMaterias, asistencia, cursos_idcursos, comisiones_idComisiones) 
                        VALUES ('$horaArgentina', '$legajo', '$carrera', '$materia1', 'Justificada', '$curso', '$comision')";
                $query = mysqli_query($conexion, $sql);
            }
        }

        // Repite el mismo proceso para la segunda materia
        if (!empty($_POST['presenteSegunda'])) {
            $presentes = $_POST['presenteSegunda'];
            foreach ($presentes as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, carreras_idCarrera, materias_idMaterias, asistencia, cursos_idcursos, comisiones_idComisiones) 
                        VALUES ('$horaArgentina', '$legajo', '$carrera', '$materia2', 'Presente', '$curso', '$comision')";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['ausenteSegunda'])) {
            $ausentes = $_POST['ausenteSegunda'];
            foreach ($ausentes as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, carreras_idCarrera, materias_idMaterias, asistencia, cursos_idcursos, comisiones_idComisiones) 
                        VALUES ('$horaArgentina', '$legajo', '$carrera', '$materia2', 'Ausente', '$curso', '$comision')";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['justificadaSegunda'])) {
            $justificada = $_POST['justificadaSegunda'];
            foreach ($justificada as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, carreras_idCarrera, materias_idMaterias, asistencia, cursos_idcursos, comisiones_idComisiones) 
                        VALUES ('$horaArgentina', '$legajo', '$carrera', '$materia2', 'Justificada', '$curso', '$comision')";
                $query = mysqli_query($conexion, $sql);
            }
        }
    }

    header('Location: ../../indexs/controlador_preceptor.php');
}
?>

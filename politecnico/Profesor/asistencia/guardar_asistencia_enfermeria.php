
<?php
include '../../conexion/conexion.php';
if (isset($_POST['Enviar'])) {
    if (!empty($_POST['presentePrimera']) || !empty($_POST['ausentePrimera']) || !empty($_POST['justificadaPrimera'])|| !empty($_POST['fecha'])|| !empty($_POST['idcarrera'])) {
        $idasignatura=$_POST['idcarrera'];
        $fecha=$_POST['fecha'];  
              
        if (!empty($_POST['presentePrimera'])) {
            $presentes = $_POST['presentePrimera'];
            foreach ($presentes as $legajo) {
                $sql = "INSERT INTO politecnico.asistencia (fecha, inscripcion_asignatura_alumno_legajo, inscripcion_asignatura_carreras_idCarrera,1_Horario) 
                VALUES ('$fecha', '$legajo', '$idasignatura','Presente');";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['ausentePrimera'])) {
            $ausentes = $_POST['ausentePrimera'];
            foreach ($ausentes as $legajo) {
                $sql = "INSERT INTO politecnico.asistencia (fecha, inscripcion_asignatura_alumno_legajo, inscripcion_asignatura_carreras_idCarrera,1_Horario) 
                VALUES ( '$fecha', '$legajo', '$idasignatura','ausente');";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['justificadaPrimera'])) {
            $justificada = $_POST['justificadaPrimera'];
            foreach ($justificada as $legajo) {
                $sql = "INSERT INTO politecnico.asistencia (fecha, inscripcion_asignatura_alumno_legajo, inscripcion_asignatura_carreras_idCarrera,1_Horario) 
                VALUES ( '$fecha', '$legajo', '$idasignatura','justificada');";
                $query = mysqli_query($conexion, $sql);
            }
        }



        //---------------------------Segunda Hora--------------------------------------------------------//


        if (!empty($_POST['presenteSegunda'])) {
            $presentes = $_POST['presenteSegunda'];
            foreach ($presentes as $legajo) {
                $sql = "UPDATE asistencia 
                SET `2_Horario` = 'Presente'
                WHERE inscripcion_asignatura_alumno_legajo = '$legajo'
                AND fecha = '$fecha'
                AND inscripcion_asignatura_carreras_idCarrera = '$idasignatura'";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['ausenteSegunda'])) {
    $ausentes = $_POST['ausenteSegunda'];
    foreach ($ausentes as $legajo) {
        $sql = "UPDATE asistencia 
                SET `2_Horario` = 'Ausente'
                WHERE inscripcion_asignatura_alumno_legajo = '$legajo'
                AND fecha = '$fecha'
                AND inscripcion_asignatura_carreras_idCarrera = '$idasignatura'";
        $query = mysqli_query($conexion, $sql);


            }
        }

        if (!empty($_POST['justificadaSegunda'])) {
            $justificada = $_POST['justificadaSegunda'];
            foreach ($justificada as $legajo) {
                $sql = "UPDATE asistencia 
                SET `2_Horario` = 'Justificada'
                WHERE inscripcion_asignatura_alumno_legajo = '$legajo'
                AND fecha = '$fecha'
                AND inscripcion_asignatura_carreras_idCarrera = '$idasignatura'";
                $query = mysqli_query($conexion, $sql);
            }
        }
    }

     header('Location: ./asistencia_enfermeria.php');
    }
?>
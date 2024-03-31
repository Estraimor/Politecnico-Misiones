
<?php
include '../../conexion/conexion.php';
if (isset($_POST['Enviar'])) {
    if (!empty($_POST['presentePrimera']) || !empty($_POST['ausentePrimera']) || !empty($_POST['justificadaPrimera'])|| !empty($_POST['idcarrera'])|| !empty($_POST['materia1'])|| !empty($_POST['materia2'])) {
        $idasignatura=$_POST['idcarrera'];
        
        $materia1=$_POST['materia1'];  
        $materia2=$_POST['materia2'];
              
        if (!empty($_POST['presentePrimera'])) {
            $presentes = $_POST['presentePrimera'];
            foreach ($presentes as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, inscripcion_asignatura_carreras_idCarrera,materias_idMaterias,1_Horario) 
                VALUES (now(), '$legajo', '$idasignatura',$materia1,'Presente');";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['ausentePrimera'])) {
            $ausentes = $_POST['ausentePrimera'];
            foreach ($ausentes as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, inscripcion_asignatura_carreras_idCarrera,materias_idMaterias,1_Horario) 
                VALUES ( now(), '$legajo', '$idasignatura',$materia1,'ausente');";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['justificadaPrimera'])) {
            $justificada = $_POST['justificadaPrimera'];
            foreach ($justificada as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, inscripcion_asignatura_carreras_idCarrera,materias_idMaterias,1_Horario) 
                VALUES ( now(), '$legajo', '$idasignatura',$materia1,'justificada');";
                $query = mysqli_query($conexion, $sql);
            }
        }



        //---------------------------Segunda Hora--------------------------------------------------------//


        if (!empty($_POST['presenteSegunda'])) {
            $presentes = $_POST['presenteSegunda'];
            foreach ($presentes as $legajo) {
                $sql = $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, inscripcion_asignatura_carreras_idCarrera,materias_idMaterias,2_Horario) 
                VALUES ( now(), '$legajo', '$idasignatura',$materia2,'Presente');";
                $query = mysqli_query($conexion, $sql);
            }
        }

        if (!empty($_POST['ausenteSegunda'])) {
    $ausentes = $_POST['ausenteSegunda'];
    foreach ($ausentes as $legajo) {
        $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, inscripcion_asignatura_carreras_idCarrera,materias_idMaterias,2_Horario) 
                VALUES ( now(), '$legajo', '$idasignatura',$materia2,'Ausente');";
        $query = mysqli_query($conexion, $sql);


            }
        }

        if (!empty($_POST['justificadaSegunda'])) {
            $justificada = $_POST['justificadaSegunda'];
            foreach ($justificada as $legajo) {
                $sql = "INSERT INTO asistencia (fecha, inscripcion_asignatura_alumno_legajo, inscripcion_asignatura_carreras_idCarrera,materias_idMaterias,2_Horario) 
                VALUES ( now(), '$legajo', '$idasignatura',$materia2,'Justificada');";
                $query = mysqli_query($conexion, $sql);
            }
        }
    }

     header('Location: ../../index.php');
    }
?>
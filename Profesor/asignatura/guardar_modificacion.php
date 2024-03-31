<?php
include '../../conexion/conexion.php';
if (isset($_POST['enviar'])) {
    if (!empty($_POST['asignatura']) || !empty($_POST['profe'])) {
        $idasignatura = $_POST['idasignatura'];
        $asignatura = $_POST['asignatura'];
        $profesor = $_POST['profe'];
        $sql = "UPDATE `politecnico`.`materia` 
                SET nombre_materia = '$asignatura', profesor_idProrfesor = '$profesor' 
                WHERE (idMateria = '$idasignatura');";
        $query = mysqli_query($conexion, $sql);
        header("Location: alta_materia.php");
        exit;
    }
}
?>
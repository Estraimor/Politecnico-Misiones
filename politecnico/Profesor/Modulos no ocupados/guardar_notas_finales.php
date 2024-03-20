<?php
include '../../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibieron los datos esperados del formulario
    if(isset($_POST['selectAlumno']) && isset($_POST['selectMateria']) && isset($_POST['condicion']) && isset($_POST['nota']) ) {
        // Obtener los valores de los selectores
        $alumno = $_POST['selectAlumno'];
        $materia = $_POST['selectMateria'];
        $condicion = $_POST['condicion'];
        $nota = $_POST['nota'];

        // Realizar cualquier otra operación que necesites con los datos obtenidos

        $sql_insertar= "INSERT INTO politecnico.finales (alumno_legajo, materias_idMaterias, condicion_materia_idcondicion_materia, nota) 
        VALUES ('$alumno', '$materia', '$condicion', '$nota');";
        $query_insertar=mysqli_query($conexion,$sql_insertar);
        


       header("Location: cargar_notas_finales.php");

    } else {
        echo "No se recibieron datos del formulario";
    }
} else {
    echo "La solicitud no es válida";
}
?>

<?php
if (isset($_POST['enviar'])) {
    include '../../../conexion/conexion.php';
    $alumno_id = $_POST['alumno_id'];
    $asignatura = $_POST['materia'];
    $existingRecords = array();

    for ($i = 0; $i < count($alumno_id); $i++) {
        $alumnoId = $alumno_id[$i];
        $materia = $asignatura[$i];

        // Verificar si el registro ya existe en la tabla
        $checkSql = "SELECT * FROM politecnico.inscripcion_asignatura WHERE alumno_idAlumno = '$alumnoId' AND materia_idMateria = '$materia'";
        $checkQuery = mysqli_query($conexion, $checkSql);

        if (mysqli_num_rows($checkQuery) == 0) {
            // Si no existe, insertar el registro en la tabla
            $insertSql = "INSERT INTO politecnico.inscripcion_asignatura (materia_idMateria, alumno_idAlumno) VALUES ('$materia', '$alumnoId')";
            $insertQuery = mysqli_query($conexion, $insertSql);
            

            if ($insertQuery) {
                header('Location: inscripcion_materia.php');
            }
        } else {
            // Si ya existe, agregar el registro a la lista de registros existentes
            $existingRecords[] = "Alumno ID: $alumnoId, Materia ID: $materia";
        }
    }

    // Si existen registros existentes, mostrar un mensaje o realizar alguna acción adicional
    if (!empty($existingRecords)) {
        echo '<div class="alert alert-danger" role="alert">
        !! Estas personas ya estan en esta Asignatura !!
      </div>' ;
        foreach ($existingRecords as $record) {
            echo "- $record<br>";
        }
    }
}
?>
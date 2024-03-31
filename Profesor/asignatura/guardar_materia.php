<?php
$server='localhost';
$user='root';
$pass='';
$bd='politecnico';
$conexion=mysqli_connect($server,$user,$pass,$bd, '3306');

if ($conexion) { echo ""; } else { echo "conexion not connected"; }

if (isset($_POST['enviar'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['profe'])) {
        $nombre = $_POST['nombre'];
        $idprofe = $_POST['profe'];

        // Verificar si ya existe el nombre de la materia
        $sql_verificar = "SELECT nombre_materia FROM politecnico.materia WHERE nombre_materia = '$nombre'";
        $query_verificar = mysqli_query($conexion, $sql_verificar);

        if (mysqli_num_rows($query_verificar) > 0) {
          echo '<div class="alert alert-danger" role="alert">
          !! YA EXISTE LA MATERIA !!
        </div>' ;
        } else {
            // Insertar nueva materia
            $sql_insertar = "INSERT INTO politecnico.materia (nombre_materia, profesor_idProrfesor) VALUES ('$nombre', '$idprofe')";
            $query_insertar = mysqli_query($conexion, $sql_insertar);

            if ($query_insertar) {
                echo '';
            } else {
                echo 'Error al insertar la materia';
            }
        }
    }
}
?>
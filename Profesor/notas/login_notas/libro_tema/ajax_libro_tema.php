<?php
session_start();
include'../../conexion/conexion.php';

if (isset($_POST['fecha'])) {
    $fecha = $_POST['fecha'];
    $sql = "SELECT * FROM libro_tema l WHERE l.profesor_idProrfesor = '{$_SESSION["id"]}' AND l.fecha = '$fecha'";
    $query = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($query) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Capacidades</th>
                    <th>Contenidos</th>
                    <th>Evaluacion</th>
                    <th>Fecha</th>
                </tr>";
        
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>";
            echo "<td>".$row['capacidades']."</td>";
            echo "<td>".$row['contenidos']."</td>";
            echo "<td>".$row['evaluacion']."</td>";
            echo "<td>".$row['fecha']."</td>";
            // Agrega más celdas según sea necesario
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron resultados.";
    }
}
?>

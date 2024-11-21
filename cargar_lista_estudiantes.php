<?php
include './conexion/conexion.php'; // Archivo de conexión a la base de datos

$sql = "SELECT a.legajo, a.apellido_alumno, a.nombre_alumno, a.dni_alumno, a.celular, c.nombre_carrera, c2.N_comicion 
        FROM alumno a
        INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.legajo
        INNER JOIN materias m ON ia.materias_idMaterias = m.idMaterias
        INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
        INNER JOIN comisiones c2 ON ia.comisiones_idComisiones = c2.idComisiones
        WHERE a.estado = '2'
        GROUP BY a.legajo";

$query = mysqli_query($conexion, $sql);
while ($fila = mysqli_fetch_assoc($query)) {
        echo "<tr>
        <td>{$fila['apellido_alumno']}</td>
        <td>{$fila['nombre_alumno']}</td>
        <td>{$fila['legajo']}</td>
        <td>{$fila['dni_alumno']}</td>
        <td>{$fila['celular']}</td>
        <td>{$fila['nombre_carrera']}</td>
        <td>{$fila['N_comicion']}</td>
        <td><button class='boton-recuperar' data-legajo='{$fila['legajo']}'>Recuperar</button></td>
        </tr>";
}
?>

<?php
include './conexion/conexion.php';

$sql1 = "SELECT a.apellido_alumno, a.nombre_alumno, a.dni_alumno, a.legajo, a.celular, c.nombre_carrera, c2.N_comicion
        FROM inscripcion_asignatura ia
            INNER JOIN alumno a ON ia.alumno_legajo = a.legajo
            INNER JOIN materias m ON ia.materias_idMaterias = m.idMaterias
            INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
            INNER JOIN comisiones c2 ON ia.comisiones_idComisiones = c2.idComisiones
        WHERE a.estado = '1'
        GROUP BY a.legajo";

$query1 = mysqli_query($conexion, $sql1);

if ($query1) {
    while ($datos = mysqli_fetch_assoc($query1)) {
        echo "<tr>
                    <td>{$datos['legajo']}</td>
                    <td>{$datos['apellido_alumno']}</td>
                    <td>{$datos['nombre_alumno']}</td>
                    <td>{$datos['dni_alumno']}</td>
                    <td>{$datos['celular']}</td>
                    <td>{$datos['nombre_carrera']}</td>
                    <td>{$datos['N_comicion']}</td>
                    <td>
                    <a href='./Profesor/modificar_alumno.php?legajo={$datos['legajo']}' class='modificar-button'><i class='fas fa-pencil-alt'></i></a>
                    <a href='#' onclick='return confirmarBorrado(\"{$datos['legajo']}\")' class='borrar-button'><i class='fas fa-trash-alt'></i></a>
                    <a href='./Profesor/porcentajes_de_asistencia.php?legajo={$datos['legajo']}' class='accion-button'><i class='fas fa-exclamation'></i></a>
                    </td>
                </tr>";
    }
} else {
    echo "<tr><td colspan='8'>Error al obtener los datos: " . mysqli_error($conexion) . "</td></tr>";
}
?>

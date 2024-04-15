<?php include'../../../conexion/conexion.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>
    <link rel="stylesheet" href="estilos_tablas.css">
    <link rel="stylesheet" href="prueba_tabla.css">
    <link rel="icon" href="../../../politecnico.ico">
    
    
</head>
<body>
       
<?php
// Aquí va tu código PHP para conectarte a la base de datos

// Supongamos que ya tienes una conexión establecida llamada $conexion

if (isset($_GET['materia'])) {
    $materia = $_GET['materia'];
    $carrera = $_GET['carrera'];
}

$sql_alumno = "SELECT a.dni_alumno, a.nombre_alumno, a.apellido_alumno, a.legajo, 
       f.tp_1, f.tp_2, f.parcial_1, f.to_3, f.tp_4, f.parcial_2,
       f.condicion_materia_idcondicion_materia, f.mesa_final, m.idMaterias  
FROM alumno a
JOIN materias m ON m.idMaterias = '$materia'
LEFT JOIN finales f ON a.legajo = f.alumno_legajo AND f.materias_idMaterias = m.idMaterias
LEFT JOIN inscripcion_asignatura ia ON a.legajo = ia.alumno_legajo AND m.carreras_idCarrera = ia.carreras_idCarrera
WHERE m.idMaterias = '$materia' AND ia.carreras_idCarrera = '$carrera';";

$query_alumno = mysqli_query($conexion, $sql_alumno);

if (!$query_alumno) {
    echo "Error al obtener los datos de los alumnos.";
    exit;
}

?>

<form action="procesar.php" method="POST">
<input type="hidden" name="materia" value="<?php echo $materia; ?>">
    <table border="1">
        
    <tr>
            <th class="columna-roja" rowspan="2">DNI</th>
            <th class="columna-roja" rowspan="2">Apellido</th>
            <th class="columna-roja" rowspan="2">Nombre</th>
            <th class="columna-roja" colspan="3">Primer Cuatrimestre</th>
            <th class="columna-roja" colspan="3">Segundo Cuatrimestre</th> <!-- Asumiendo que quieres algo similar para el segundo cuatrimestre -->
            <th class="columna-roja" rowspan="2">Promedio</th>
            <th class="columna-roja" rowspan="2">Condición</th>
            <th class="columna-roja" colspan="3">Asistencia 1</th> <!-- Asumiendo una agrupación para la asistencia -->
            <th class="columna-roja" colspan="3">Asistencia 2</th> <!-- Segunda agrupación de asistencia, si es necesaria -->
        </tr>
        <!-- Segunda fila para los subencabezados dentro de los grupos -->
        <tr>
            <!-- Subencabezados para el Primer Cuatrimestre -->
            <th class="columna-roja">Tp1</th>
            <th class="columna-roja">Tp2</th>
            <th class="columna-roja">Parcial 1</th>
            <!-- Asumiendo subencabezados para el Segundo Cuatrimestre -->
            <th class="columna-roja">Tp3</th>
            <th class="columna-roja">Tp4</th>
            <th class="columna-roja">Parcial 2</th>
            <!-- Subencabezados para la primera agrupación de asistencia -->
            <th class="columna-roja">Presente</th>
            <th class="columna-roja">Ausente</th>
            <th class="columna-roja">Justificada</th>
            <!-- Subencabezados para la segunda agrupación de asistencia, si es necesaria -->
            <th class="columna-roja">Presente</th>
            <th class="columna-roja">Ausente</th>
            <th class="columna-roja">Justificada</th>
        </tr>
        <?php
        while ($datos_alumno = mysqli_fetch_assoc($query_alumno)) {
            $promedio = ($datos_alumno['parcial_1'] + $datos_alumno['parcial_2']) / 2;
            ?>
            <tr>
                
                <td><?php echo $datos_alumno['dni_alumno'] ?></td>
                <td><?php echo $datos_alumno['apellido_alumno'] ?></td>
                <td><?php echo $datos_alumno['nombre_alumno'] ?></td>
                <!-- Aquí añades los campos ocultos con los datos de cada alumno -->
                <input type="hidden" name="dni[]" value="<?php echo $datos_alumno['dni_alumno'] ?>">
                <input type="hidden" name="nombre[]" value="<?php echo $datos_alumno['nombre_alumno'] ?>">
                <input type="hidden" name="apellido[]" value="<?php echo $datos_alumno['apellido_alumno'] ?>">
                <input type="hidden" name="legajo[]" value="<?php echo $datos_alumno['legajo'] ?>">
                <input type="hidden" name="materia" value="<?php echo $materia; ?>">
                <input type="hidden" name="carrera" value="<?php echo $carrera; ?>">
                <!-- Aquí añades los campos de entrada para las notas -->
                <td>
                    <select name="tp1[]" class="estilo-select">
                        <option value="">Seleccionar</option>
                        <option value="Aprobado" <?php echo ($datos_alumno['tp_1'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                        <option value="Desaprobado" <?php echo ($datos_alumno['tp_1'] == 'Desaprobado') ? 'selected' : ''; ?>>Desaprobado</option>
                    </select>
                </td>
                <td>
                    <select name="tp2[]" class="estilo-select">
                        <option value="">Seleccionar</option>
                        <option value="Aprobado" <?php echo ($datos_alumno['tp_2'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                        <option value="Desaprobado" <?php echo ($datos_alumno['tp_2'] == 'Desaprobado') ? 'selected' : ''; ?>>Desaprobado</option>
                    </select>
                </td>
                <td><input type="number" min="0" max="10" step="0.01"  name="parcial1[]" value="<?php echo number_format((float)$datos_alumno['parcial_1'], 2, '.', ''); ?>"></td>

                <td>
                    <select name="tp3[]" class="estilo-select">
                        <option value="">Seleccionar</option>
                        <option value="Aprobado" <?php echo ($datos_alumno['to_3'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                        <option value="Desaprobado" <?php echo ($datos_alumno['to_3'] == 'Desaprobado') ? 'selected' : ''; ?>>Desaprobado</option>
                    </select>
                </td>
                <td>
                    <select name="tp4[]" class="estilo-select">
                        <option value="">Seleccionar</option>
                        <option value="Aprobado" <?php echo ($datos_alumno['tp_4'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                        <option value="Desaprobado" <?php echo ($datos_alumno['tp_4'] == 'Desaprobado') ? 'selected' : ''; ?>>Desaprobado</option>
                    </select>
                </td>
                <td><input type="number" step="0.01" name="parcial2[]" value="<?php echo number_format((float)$datos_alumno['parcial_2'], 2, '.', ''); ?>"></td>
                
                <td><?php echo $promedio; ?></td>
                <td>
                    <select name="condicion[]" class="estilo-select">
                        <option value="">Seleccionar</option>
                        <option value="1" <?php echo ($datos_alumno['condicion_materia_idcondicion_materia'] == '1') ? 'selected' : ''; ?>>Regular</option>
                        <option value="2" <?php echo ($datos_alumno['condicion_materia_idcondicion_materia'] == '2') ? 'selected' : ''; ?>>Promoción</option>
                        <option value="3" <?php echo ($datos_alumno['condicion_materia_idcondicion_materia'] == '3') ? 'selected' : ''; ?>>Recursa</option>
                        <option value="4" <?php echo ($datos_alumno['condicion_materia_idcondicion_materia'] == '4') ? 'selected' : ''; ?>>Aprobado</option>
                    </select>
                </td>
                
                <?php 

$sql_porcentaje_asistencia_1er_horario="SELECT 
                                            (SUM(1_Horario = 'Presente') / COUNT(1_Horario)) * 100 AS porcentaje_presentes_1er_horario,
                                            (SUM(1_Horario = 'ausente') / COUNT(1_Horario)) * 100 AS porcentaje_ausentes_1er_horario,
                                            (SUM(1_Horario = 'justificada') / COUNT(1_Horario)) * 100 AS porcentaje_justificados_1er_horario
                                        FROM asistencia a
                                        WHERE 
                                            inscripcion_asignatura_alumno_legajo = '{$datos_alumno['legajo']}'
                                            AND inscripcion_asignatura_carreras_idCarrera = '$carrera'
                                            AND a.materias_idMaterias = '$materia';";
$query_porcentajes_1er_horario=mysqli_query($conexion,$sql_porcentaje_asistencia_1er_horario);

$sql_porcentaje_asistencia_2do_horario="SELECT 
                                            (SUM(2_Horario = 'Presente') / COUNT(2_Horario)) * 100 AS porcentaje_presentes_2do_horario,
                                            (SUM(2_Horario = 'ausente') / COUNT(2_Horario)) * 100 AS porcentaje_ausentes_2do_horario,
                                            (SUM(2_Horario = 'justificada') / COUNT(2_Horario)) * 100 AS porcentaje_justificados_2do_horario
                                        FROM asistencia a
                                        WHERE 
                                            inscripcion_asignatura_alumno_legajo = '{$datos_alumno['legajo']}'
                                            AND inscripcion_asignatura_carreras_idCarrera = '$carrera' 
                                            AND a.materias_idMaterias = '$materia';";
$query_porcentajes_2do_horario=mysqli_query($conexion,$sql_porcentaje_asistencia_2do_horario);

if(mysqli_num_rows($query_porcentajes_1er_horario) > 0) {
    $row_1er_horario = mysqli_fetch_assoc($query_porcentajes_1er_horario);
    $porcentaje_presentes_1er_horario = $row_1er_horario['porcentaje_presentes_1er_horario'];
    $porcentaje_ausentes_1er_horario = $row_1er_horario['porcentaje_ausentes_1er_horario'];
    $porcentaje_justificados_1er_horario = $row_1er_horario['porcentaje_justificados_1er_horario'];?>

    <td><?php echo number_format($porcentaje_presentes_1er_horario, 2); ?>%</td>
    <td><?php echo number_format($porcentaje_ausentes_1er_horario, 2); ?>%</td>
<td><?php echo number_format($porcentaje_justificados_1er_horario, 2); ?>%</td>

<?php
}

if(mysqli_num_rows($query_porcentajes_2do_horario) > 0) {
    $row_2do_horario = mysqli_fetch_assoc($query_porcentajes_2do_horario);
    $porcentaje_presentes_2do_horario = $row_2do_horario['porcentaje_presentes_2do_horario'];
    $porcentaje_ausentes_2do_horario = $row_2do_horario['porcentaje_ausentes_2do_horario'];
    $porcentaje_justificados_2do_horario = $row_2do_horario['porcentaje_justificados_2do_horario'];?>

    <td><?php echo number_format($porcentaje_presentes_2do_horario, 2); ?>%</td>
<td><?php echo number_format($porcentaje_ausentes_2do_horario, 2); ?>%</td>
<td><?php echo number_format($porcentaje_justificados_2do_horario, 2); ?>%</td>
<?php
}
?>

                
                
            </tr>
        <?php
        }
        ?>
    </table>
    
    <button type="submit" name="enviar" class="boton-enviar">Confirmar</button>
    <button class="boton-enviar"><a href="./index_notas.php">Cancelar</a></button>
    
</form>




</body>
</html>





<?php

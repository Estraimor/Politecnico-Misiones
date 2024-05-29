<?php 
include '../conexion/conexion.php'; 

if (isset($_GET['materia'])) {
    $materia = $_GET['materia'];
    $carrera = $_GET['carrera'];
}

$sql_alumno = "SELECT a.dni_alumno, a.nombre_alumno, a.apellido_alumno, a.legajo, 
       f.tp_1, f.tp_2, f.parcial_1, f.recuperatorio1, f.to_3, f.tp_4, f.parcial_2, f.recuperatorio2,
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
    <form action="procesar.php" method="POST">
        <input type="hidden" name="materia" value="<?php echo $materia; ?>">
        <table border="1">
            <tr>
                <th class="columna-roja" rowspan="2">DNI</th>
                <th class="columna-roja" rowspan="2">Apellido</th>
                <th class="columna-roja" rowspan="2">Nombre</th>
                <th class="columna-roja" colspan="4">Primer Cuatrimestre</th>
                <th class="columna-roja" colspan="4">Segundo Cuatrimestre</th>
                <th class="columna-roja" rowspan="2">Promedio</th>
                <th class="columna-roja" rowspan="2">Condición</th>
                <th class="columna-roja" colspan="3">Asistencia 1</th>
            </tr>
            <tr>
                <th class="columna-roja">Tp1</th>
                <th class="columna-roja">Tp2</th>
                <th class="columna-roja">Parcial 1</th>
                <th class="columna-roja">Recuperatorio 1</th>
                <th class="columna-roja">Tp3</th>
                <th class="columna-roja">Tp4</th>
                <th class="columna-roja">Parcial 2</th>
                <th class="columna-roja">Recuperatorio 2</th>
                <th class="columna-roja">Presente</th>
                <th class="columna-roja">Ausente</th>
       
            </tr>
    <?php while ($datos_alumno = mysqli_fetch_assoc($query_alumno)) { 
    // Inicializar el promedio con las notas de los parciales por defecto
    $promedio = ($datos_alumno['parcial_1'] + $datos_alumno['parcial_2']) / 2;

    // Verificar si el alumno tiene una nota en el primer recuperatorio y es mayor que cero
    if (!empty($datos_alumno['recuperatorio1']) && $datos_alumno['recuperatorio1'] > 0) {
        // Si hay nota en el primer recuperatorio y es mayor que cero, se utiliza para calcular el promedio
        if (!empty($datos_alumno['recuperatorio2']) && $datos_alumno['recuperatorio2'] > 0) {
            // Si hay nota en el segundo recuperatorio y es mayor que cero, se promedian ambos recuperatorios
            $promedio = ($datos_alumno['recuperatorio1'] + $datos_alumno['recuperatorio2']) / 2;
        } else {
            // Si no hay nota en el segundo recuperatorio o es menor o igual que cero, se promedia el primer recuperatorio con el segundo parcial
            $promedio = ($datos_alumno['recuperatorio1'] + $datos_alumno['parcial_2']) / 2;
        }
    } elseif (!empty($datos_alumno['recuperatorio2']) && $datos_alumno['recuperatorio2'] > 0) {
        // Si no hay nota en el primer recuperatorio o es menor o igual que cero, pero sí en el segundo recuperatorio y es mayor que cero, se utiliza el segundo recuperatorio con el primer parcial
        $promedio = ($datos_alumno['parcial_1'] + $datos_alumno['recuperatorio2']) / 2;
    }

    // Ahora $promedio contendrá el promedio calculado correctamente
?>





            <tr>
                <td><?php echo $datos_alumno['dni_alumno'] ?></td>
                <td><?php echo $datos_alumno['apellido_alumno'] ?></td>
                <td><?php echo $datos_alumno['nombre_alumno'] ?></td>
                <input type="hidden" name="dni[]" value="<?php echo $datos_alumno['dni_alumno'] ?>">
                <input type="hidden" name="nombre[]" value="<?php echo $datos_alumno['nombre_alumno'] ?>">
                <input type="hidden" name="apellido[]" value="<?php echo $datos_alumno['apellido_alumno'] ?>">
                <input type="hidden" name="legajo[]" value="<?php echo $datos_alumno['legajo'] ?>">
                <input type="hidden" name="materia" value="<?php echo $materia; ?>">
                <input type="hidden" name="carrera" value="<?php echo $carrera; ?>">
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
                <td><input type="number" step="0.01" name="recuperatorio1[]" value="<?php echo number_format((float)$datos_alumno['recuperatorio1'], 2, '.', ''); ?>"></td>
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
                <td><input type="number" step="0.01" name="recuperatorio2[]" value="<?php echo number_format((float)$datos_alumno['recuperatorio2'], 2, '.', ''); ?>"></td>
                <td><?php echo number_format($promedio, 2); ?></td>
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
                    $sql_porcentaje_asistencia="SELECT 
                                                    (SUM((a.1_Horario = 'Presente' OR a.2_Horario = 'Presente') AND (a.1_Horario != 'Ausente' AND a.2_Horario != 'Ausente')) / COUNT(*)) * 100 AS porcentaje_presentes,
                                                    (SUM((a.1_Horario = 'Ausente' OR a.2_Horario = 'Ausente') AND (a.1_Horario != 'Presente' AND a.2_Horario != 'Presente')) / COUNT(*)) * 100 AS porcentaje_ausentes
                                                FROM asistencia a
                                                WHERE 
                                                    a.inscripcion_asignatura_alumno_legajo = '{$datos_alumno['legajo']}'
                                                    AND a.inscripcion_asignatura_carreras_idCarrera = '$carrera'
                                                    AND a.materias_idMaterias = '$materia';";
                    $query_porcentajes=mysqli_query($conexion,$sql_porcentaje_asistencia);

                    if(mysqli_num_rows($query_porcentajes) > 0) {
                        $row_porcentajes = mysqli_fetch_assoc($query_porcentajes);
                        $porcentaje_presentes = $row_porcentajes['porcentaje_presentes'];
                        $porcentaje_ausentes = $row_porcentajes['porcentaje_ausentes'];
                ?>
                        <td><?php echo number_format($porcentaje_presentes, 2); ?>%</td>
                        <td><?php echo number_format($porcentaje_ausentes, 2); ?>%</td>
                <?php
                    }
                ?>
            </tr>
            <?php } ?>
        </table>
        <button type="submit" name="enviar" class="boton-enviar">Confirmar</button>
        <button class="boton-enviar"><a href="./index_notas.php">Cancelar</a></button>
    </form>
</body>
</html>

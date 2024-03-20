<?php include'../../../conexion/conexion.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Aquí va tu código PHP para conectarte a la base de datos

// Supongamos que ya tienes una conexión establecida llamada $conexion

if (isset($_GET['materia'])) {
    $materia = $_GET['materia'];
    $materia2 = $_GET['materia2'];
    $materia3 = $_GET['materia3'];
    $carrera = $_GET['carrera'];
    $carrera2 = $_GET['carrera2'];
    $carrera3 = $_GET['carrera3'];
}

$sql_alumno = "SELECT a.dni_alumno, a.nombre_alumno, a.apellido_alumno, a.legajo, 
f.tp_1, f.tp_2, f.parcial_1, f.to_3, f.tp_4, f.parcial_2,
f.condicion_materia_idcondicion_materia, f.mesa_final  
FROM finales f 
RIGHT JOIN inscripcion_asignatura ia ON f.alumno_legajo = ia.alumno_legajo  
INNER JOIN alumno a ON ia.alumno_legajo = a.legajo 
INNER JOIN materias m ON m.carreras_idCarrera = ia.carreras_idCarrera 
WHERE m.idMaterias in ('$materia' , '$materia2', '$materia3') 
AND ia.carreras_idCarrera IN ('$carrera', '$carrera2', '$carrera3');
";

$query_alumno = mysqli_query($conexion, $sql_alumno);

if (!$query_alumno) {
    echo "Error al obtener los datos de los alumnos.";
    exit;
}

?>

<form action="procesar.php" method="POST">
<input type="hidden" name="materia" value="<?php echo $materia; ?>">
    <table border="1">
        <th>Legajo</th>
        <th>DNI</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Tp1</th>
        <th>Tp2</th>
        <th>Parcial 1</th>
        <th>Tp3</th>
        <th>Tp4</th>
        <th>Parcial 2</th>
        <th>Promedio</th>
        <th>Condicion</th>
        <th>Mesa</th>
        <?php
        while ($datos_alumno = mysqli_fetch_assoc($query_alumno)) {
            $promedio = ($datos_alumno['parcial_1'] + $datos_alumno['parcial_2']) / 2;
            ?>
            <tr>
                <td><?php echo $datos_alumno['legajo'] ?></td>
                <td><?php echo $datos_alumno['dni_alumno'] ?></td>
                <td><?php echo $datos_alumno['nombre_alumno'] ?></td>
                <td><?php echo $datos_alumno['apellido_alumno'] ?></td>
                <!-- Aquí añades los campos ocultos con los datos de cada alumno -->
                <input type="hidden" name="dni[]" value="<?php echo $datos_alumno['dni_alumno'] ?>">
                <input type="hidden" name="nombre[]" value="<?php echo $datos_alumno['nombre_alumno'] ?>">
                <input type="hidden" name="apellido[]" value="<?php echo $datos_alumno['apellido_alumno'] ?>">
                <input type="hidden" name="legajo[]" value="<?php echo $datos_alumno['legajo'] ?>">
                <!-- Aquí añades los campos de entrada para las notas -->
                <td>
                    <select name="tp1[]">
                        <option value="">Seleccionar</option>
                        <option value="Aprobado" <?php echo ($datos_alumno['tp_1'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                        <option value="Desaprobado" <?php echo ($datos_alumno['tp_1'] == 'Desaprobado') ? 'selected' : ''; ?>>Desaprobado</option>
                    </select>
                </td>
                <td>
                    <select name="tp2[]">
                        <option value="">Seleccionar</option>
                        <option value="Aprobado" <?php echo ($datos_alumno['tp_2'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                        <option value="Desaprobado" <?php echo ($datos_alumno['tp_2'] == 'Desaprobado') ? 'selected' : ''; ?>>Desaprobado</option>
                    </select>
                </td>
                <td><input type="number" name="parcial1[]" value="<?php echo $datos_alumno['parcial_1'] ?>"></td>
                <td>
                    <select name="tp3[]">
                        <option value="">Seleccionar</option>
                        <option value="Aprobado" <?php echo ($datos_alumno['to_3'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                        <option value="Desaprobado" <?php echo ($datos_alumno['to_3'] == 'Desaprobado') ? 'selected' : ''; ?>>Desaprobado</option>
                    </select>
                </td>
                <td>
                    <select name="tp4[]">
                        <option value="">Seleccionar</option>
                        <option value="Aprobado" <?php echo ($datos_alumno['tp_4'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                        <option value="Desaprobado" <?php echo ($datos_alumno['tp_4'] == 'Desaprobado') ? 'selected' : ''; ?>>Desaprobado</option>
                    </select>
                </td>
                <td><input type="number" name="parcial2[]" value="<?php echo $datos_alumno['parcial_2'] ?>"></td>
                <td><?php echo $promedio; ?></td>
                <td>
                    <select name="condicion[]">
                        <option value="">Seleccionar</option>
                        <option value="1" <?php echo ($datos_alumno['condicion_materia_idcondicion_materia'] == '1') ? 'selected' : ''; ?>>Regular</option>
                        <option value="2" <?php echo ($datos_alumno['condicion_materia_idcondicion_materia'] == '2') ? 'selected' : ''; ?>>Promoción</option>
                        <option value="3" <?php echo ($datos_alumno['condicion_materia_idcondicion_materia'] == '3') ? 'selected' : ''; ?>>Recursa</option>
                        <option value="4" <?php echo ($datos_alumno['condicion_materia_idcondicion_materia'] == '4') ? 'selected' : ''; ?>>Aprobado</option>
                    </select>
                </td>
                <td><input type="number" name="Mesa_final" value="<?php echo $datos_alumno['mesa_final'] ?>"></td>
            </tr>
        <?php
        }
        ?>
    </table>
    
    <button type="submit" name="enviar">Enviar</button>
</form>




</body>
</html>





<?php

<?php

session_start();
if (empty($_SESSION["id"])){header('Location: ../login/login.php');}
?>
<?php
include'../conexion/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGPM-Libro de Tema</title>
    <link rel="stylesheet" type="text/css" href="../../../normalize.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>

</head>
<body>
   <?php
// Consulta para obtener las materias y sus carreras asociadas
$sql = "SELECT c.idCarrera, c.nombre_carrera, m.idMaterias, m.Nombre
        FROM materias m
        INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
        INNER JOIN profesor p ON m.profesor_idProrfesor = p.idProrfesor
        WHERE p.idProrfesor = '{$_SESSION['id']}'";

$query = mysqli_query($conexion, $sql);

// Arrays para almacenar los datos de materias y carreras
$materias = [];
while ($row = mysqli_fetch_assoc($query)) {
    $materias[] = $row;
}
?>
Libro de Tema
<form action="guardar_libro_tema.php" method="post">
    <input type="hidden" name="profesor" value="<?php echo $_SESSION['id']; ?>">
    
    <select name="materia" id="materia" onchange="actualizarCarrera()">
        <option value="">Seleccione una materia</option>
        <?php
        // Consulta para obtener las materias y sus carreras asociadas
        $sql = "SELECT c.idCarrera, c.nombre_carrera, m.idMaterias, m.Nombre
                FROM materias m
                INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
                INNER JOIN profesor p ON m.profesor_idProrfesor = p.idProrfesor
                WHERE p.idProrfesor = '{$_SESSION['id']}'";
        
        $query = mysqli_query($conexion, $sql);

        // Iterar sobre los resultados con while en lugar de foreach
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<option value=\"{$row['idMaterias']}\" data-carrera-id=\"{$row['idCarrera']}\">{$row['Nombre']} / {$row['nombre_carrera']}</option>";
        }
        ?>
    </select>
    
    <input type="hidden" name="carrera" id="carrera">
    
    <input type="text" name="capacidades" placeholder="Capacidades">
    <input type="text" name="contenidos" placeholder="Contenidos">
    <input type="text" name="evaluacion" placeholder="Evaluación">
    <input type="date" name="fecha">
    
    <input type="submit" name="enviar" value="Enviar">
</form>

<script>
function actualizarCarrera() {
    var materiaSelect = document.getElementById('materia');
    var carreraInput = document.getElementById('carrera');
    
    var selectedOption = materiaSelect.options[materiaSelect.selectedIndex];
    var carreraId = selectedOption.getAttribute('data-carrera-id');
    
    carreraInput.value = carreraId || '';
}
</script>



</body>
</html>
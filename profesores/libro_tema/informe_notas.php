<?php
session_start();
if (empty($_SESSION["id"])) {
    header('Location: ../../login/login.php');
    exit(); // Es buena práctica agregar exit después de header para detener la ejecución del script.
}
?>

<?php
include'../../conexion/conexion.php';
if ($conexion) {
    echo ""; // Considera eliminar este echo si no es necesario.
} else {
    echo "conexion not connected";
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGPM-Docentes</title>
    <link rel="stylesheet" type="text/css" href="../../../normalize.css">
    <link rel="stylesheet" type="text/css" href="./estilos_profesores.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    
</head>
<body>
    <?php $sql="SELECT m.Nombre AS nombre_materia, c.nombre_carrera, p.nombre_profe, p.apellido_profe, m.idMaterias, c.idCarrera 
                FROM materias m  
                INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
                INNER JOIN profesor p ON m.profesor_idProrfesor = p.idProrfesor
                WHERE p.idProrfesor = '{$_SESSION["id"]}'";
    $query=mysqli_query($conexion,$sql);
     ?>
    <select name="materias" id="">
        <?php while($row=mysqli_fetch_assoc($query)){ ?>
    <option value="<?php echo $row['idMaterias'] ?>"> Carrera :  <?php echo $row['nombre_carrera'] ?> Materia :  <?php echo $row['nombre_materia'] ?> </option>
    <?php } ?>
    </select>
    <select name="cuatrimestre" id="">
        <option value="1">1er Cuatrimestre</option>
        <option value="2">2do Cuatrimestre</option>
    </select>

</body>

</html>
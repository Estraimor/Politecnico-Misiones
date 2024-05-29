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
    <title>SGPM-Docentes</title>
    <link rel="stylesheet" type="text/css" href="../../../normalize.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>

</head>
<?php
$sql="SELECT   c.idCarrera ,m.idMaterias,m.Nombre,c.nombre_carrera
FROM materias m  
INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
INNER JOIN profesor p ON m.profesor_idProrfesor = p.idProrfesor
WHERE p.idProrfesor = '{$_SESSION["id"]}'";
$query=mysqli_query($conexion,$sql);
 ?>
<body>
<form action="" method="post">
<input type="text" name="profesor" value="" hidden >
<select name="carrera" id="">
<?php
while ($row=mysqli_fetch_assoc($query)) {
 ?>
 <option value="<?php echo $row['idCarrera'] ?>"> <?php echo $row['nombre_carrera'] ?> </option>
 <?php } ?>
</select>
<select name="materia" id="">
<?php
while ($row2=mysqli_fetch_assoc($query)) {
 ?>
 <option value="<?php echo $row2['idMaterias'] ?>"> <?php echo $row2['Nombre'] ?> </option>
 <?php } ?>
</select>
<input type="text" name="capacidades" >
<input type="text" name="contenidos" >
<input type="text" name="evaluacion" >
<input type="datetime" name="fecha" >

</form>

</body>
</html>
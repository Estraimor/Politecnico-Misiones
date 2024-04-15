<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../../login/login.php');}
?>
<?php include'../conexion/conexion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Excel de Asistencias</title>
</head>
<body>
    <h2>Informe de Estudiantes</h2>
    <form action="./generar_exel_alumnos.php" method="post">
        <?php
       $sql_mater="select * from preceptores p 
       INNER JOIN carreras c on c.idCarrera = p.carreras_idCarrera
       WHERE p.profesor_idProrfesor = {$_SESSION["id"]} ";
       $peticion=mysqli_query($conexion,$sql_mater);
       ?>      
      <select name="carrera" class="form-container__input"> 
        <option hidden >Selecciona una carrera </option>
        <?php while($informacion=mysqli_fetch_assoc($peticion)){ ?>
          <option value="<?php echo $informacion['idCarrera'] ?>"><?php echo $informacion['nombre_carrera'] ?></option>
          <?php }?>
      </select>

    
        <input type="submit" value="Generar Lista de Estudiantes">
    </form>
</body>
</html>

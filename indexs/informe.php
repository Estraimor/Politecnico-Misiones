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
    <h2>Generar Excel de Asistencias</h2>
    <form action="generar_excel.php" method="post">
        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio">
        <br><br>
        <label for="fecha_fin">Fecha de fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin">
        <br><br>

        <?php
       $sql_mater="select * from carreras c ";
       $peticion=mysqli_query($conexion,$sql_mater);
       ?>      
      <select name="carrera" class="form-container__input"> 
        <option hidden >Selecciona una carrera </option>
        <?php while($informacion=mysqli_fetch_assoc($peticion)){ ?>
          <option value="<?php echo $informacion['idCarrera'] ?>"><?php echo $informacion['nombre_carrera'] ?></option>
          <?php }?>
      </select>
<br><br>
            <input type="submit" value="Generar Excel">
    </form>
</body>
</html>

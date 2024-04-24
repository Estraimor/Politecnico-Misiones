<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../login/login.php');}

// Set inactivity limit in seconds
$inactivity_limit = 1200;

// Check if the user has been inactive for too long
if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > $inactivity_limit)) {
    // User has been inactive, so destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: ../login/login.php");
    exit; // Terminar el script después de redireccionar
} else {
    // Update the session time to the current time
    $_SESSION['time'] = time();
}
?>
<?php include'./conexion/conexion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="./guardar_alumnofp.php" method="post">
    <input type="number" name="legajo"><br>
    <input type="text" name="nombre" id=""><br>
    <input type="text" name="apellido" id=""><br>
    <input type="number" name="dni" id=""><br>
    <input type="number" name="celular" id=""><br>
    <input type="text" name="observaciones" id=""><br>
    <input type="text" name="trabaja" id="">
    <?php
    $sql_mater = "SELECT * FROM carreras c";
    $peticion = mysqli_query($conexion, $sql_mater);
    $carreras = array(); // Almacenar las carreras en un array

    while ($informacion = mysqli_fetch_assoc($peticion)) {
        $carreras[] = $informacion; // Añadir cada carrera al array
    }
?>

<select name="FP1" class="">
    <option hidden>Selecciona una carrera</option>
    <?php foreach ($carreras as $carrera) { ?>
        <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
    <?php } ?>
</select><br>
<select name="FP2" class="">
    <option hidden>Selecciona una carrera</option>
    <?php foreach ($carreras as $carrera) { ?>
        <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
    <?php } ?>
</select>
<select name="FP3" class="">
    <option hidden>Selecciona una carrera</option>
    <?php foreach ($carreras as $carrera) { ?>
        <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
    <?php } ?>
</select>
<select name="FP4" class="">
    <option hidden>Selecciona una carrera</option>
    <?php foreach ($carreras as $carrera) { ?>
        <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
    <?php } ?>
</select>
<input type="submit" name="enviar" value="enviar">
</form>


</body>
</html>
<?php
session_start();
if (empty($_SESSION["id"])) {
    header('Location: login.php');
    exit;
}
?>
<?php include '../../conexion/conexion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../nav/pruebah.css">
</head>
<body>
<header class="header">
		<div class="container">
		<div class="btn-menu">
			<label for="btn-menu">☰</label>
		</div>
			
			<nav class="menu">
				
                <a href="../asistencia/asistencia.php">Asistencia</a>
                <a href="#">Ver Asistencia</a>
                <a class="no_ver" href=""></a>
                <a href="../../login/cerrar_sesion.php">Cerrar sesion</a>
			</nav>
		</div>
	</header>
	<div class="capa"></div>
<!--	--------------->
<input type="checkbox" id="btn-menu">
<div class="container-menu">
	<div class="cont-menu">
		<nav>
        <div class="logo">
            <img src="./imagenes/politecnico.jpg" alt="">
			</div>
            <a class="no_ver" href=""></a>
                <a class="no_ver"href=""></a>
                <a class="no_ver" href=""></a>
                <a href="../index_profe.php">Inicio</a>
			    <a href="../asignatura/alta_materia.php">Alta Materia</a>
				<a href="../estudiante/alta_estudiante.php">Alta Estudiante</a>
				<a href="../asignatura/inscripcionMateria/inscripcion_materia.php">Inscripcion a Materias</a>
                <a href="../asistencia/asistencia.php">Asistencia</a>
                <a href="#">Ver Asistencia</a>
                <a href="../../login/cerrar_sesion.php">Cerrar sesion</a>
		</nav>
		<label for="btn-menu">✖️</label>
	</div>
</div>
    <br><br><br><br>
    <a class="btn" href="../../login/cerrar_sesion.php"><button>Cerrar sesión</button></a>
</header>
<br><br><br>

<form action="./guardar_modificacion.php" method="post">
    <?php
    $id = $_GET["id"];
    $sql = "select a.idAlumno ,a.nombre_alumno ,a.apellido_alumno ,	a.dni_alumno ,a.celular 
    from alumno a 
    where a.idAlumno = '$id'";
    $query = mysqli_query($conexion, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <label for="inputOculto"></label>
        <input type="text" name="idalumno" value="<?php echo $id; ?>" id="inputOculto" style="display: none;">
        <input type="text" name="nombre_alu" value="<?php echo $row['nombre_alumno']; ?>">
        <input type="text" name="apellido_alu" value="<?php echo $row['apellido_alumno']; ?>">
        <input type="text" name="dni" value="<?php echo $row['dni_alumno']; ?>">
        <input type="text" name="celular" value="<?php echo $row['celular']; ?>">

    <?php } ?>
    

    <input type="submit" name="enviar" value="Enviar">
</form>
</body>
</html>
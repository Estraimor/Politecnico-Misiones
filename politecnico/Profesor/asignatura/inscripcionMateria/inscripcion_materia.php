<?php
session_start();
if (empty($_SESSION["id"])) {
    header('Location: login.php');
}
include'../../../conexion/conexion.php';

// Obtén la lista de asignaturas
$sql1 = "SELECT * FROM materia";
$query1 = mysqli_query($conexion, $sql1);
$asignaturas = mysqli_fetch_all($query1, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../../nav/pruebah.css">
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>

</head>
<body>
<header class="header">
		<div class="container">
		<div class="btn-menu">
			<label for="btn-menu">☰</label>
		</div>
			
			<nav class="menu">
				
                <a href="../../asistencia/asistencia.php">Asistencia</a>
                <a href="../../verAsistencia/ver_asistencia.php">Ver Asistencia</a>
                <a class="no_ver" href=""></a>
                <a href="../../../login/cerrar_sesion.php">Cerrar sesion</a>
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
            <img src="../../imagenes/politecnico.jpg" alt="">
			</div>
            <a class="no_ver" href=""></a>
                <a class="no_ver"href=""></a>
                <a class="no_ver" href=""></a>
                <a href="../../index_profe.php">Inicio</a>
			    <a href="../../asignatura/alta_materia.php">Alta Materia</a>
				<a href="../../estudiante/alta_estudiante.php">Alta Estudiante</a>
				<a href="../alta_materia.php">Inscripcion a Materias</a>
                <a href="../../asistencia/asistencia.php">Asistencia</a>
                <a href="../../verAsistencia/ver_asistencia.php">Ver Asistencia</a>
                <a href="../../../login/cerrar_sesion.php">Cerrar sesion</a>
		</nav>
		<label for="btn-menu">✖️</label>
	</div>
</div>
<br><br><br><br><br><br>
    <form action="" method="post">
        <?php include'./guardar_inscripcion.php'; ?>
        <table id="tabla" class="table table-dark table-striped" >
            <thead>
                <tr>
                    <th>Nombre -- Apellido</th>
                    <th>Asignatura</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT a.idAlumno, a.nombre_alumno, a.apellido_alumno, ia.materia_idMateria FROM inscripcion_asignatura ia 
                RIGHT JOIN alumno a ON ia.alumno_idAlumno = a.idAlumno
                group by a.nombre_alumno,a.apellido_alumno";
                $query = mysqli_query($conexion, $sql);

                while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td>
                            <input type="hidden" name="alumno_id[]" value="<?php echo $row['idAlumno']?>">
                            <?php echo $row['nombre_alumno']?>  <?php echo $row['apellido_alumno']?>  
                        </td>
                        <td>
                            <select name="materia[]">
                                <option hidden>Selecciona la asignatura</option>
                                <?php foreach ($asignaturas as $asignatura) { ?>
                                    <option value="<?php echo $asignatura['idMateria']; ?>"><?php echo $asignatura['nombre_materia']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tr>
                    <th>Nombre -- Apellido</th>
                    <th>Asignatura</th>
                </tr>
        </table>
        <input type="submit" name="enviar" value="Enviar">
    </form>
    <script>
        var tabla =document.querySelector("#tabla");
        var dataTable = new DataTable(tabla);
    </script>

</body>
</html>
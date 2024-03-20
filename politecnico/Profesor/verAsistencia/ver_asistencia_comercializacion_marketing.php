<?php
session_start();
if (empty($_SESSION["id"])) {
    header('Location: login.php');
    exit;
}
include '../../conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">    <link rel="stylesheet" href="../nav/pruebah.css">
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <title>Document</title>
</head>
<body>
<header class="header">
		<div class="container">
		<div class="btn-menu">
			<label for="btn-menu">☰</label>
		</div>
			
			<nav class="menu">
				
                <a href="../asistencia/asistencia.php">Asistencia</a>
                <a href="../verAsistencia/ver_asistencia.php">Ver Asistencia</a>
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
                <a href="./asistencia.php">Asistencia</a>
                <a href="#">Ver Asistencia</a>
                <a href="../../login/cerrar_sesion.php">Cerrar sesion</a>
		</nav>
		<label for="btn-menu">✖️</label>
	</div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<br><br>
    <table id="tabla" class="table table-dark table-striped">
        <?php
        $fecha=$_GET["fecha"];
        ?>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Presente</th>
                <th>Tardanza</th>
                <th>Justificada</th>
                <th>Ausente</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "select a2.nombre_alumno ,a2.apellido_alumno ,a.presente,a.tardanza ,a.falta_justificada , a.ausente,a.fecha  from asistencia a 
            left join alumno a2 on a.inscripcion_asignatura_alumno_idAlumno = a2.idAlumno 
            where a.inscripcion_asignatura_materia_idMateria = '13' and a.fecha = '$fecha'";
            $query = mysqli_query($conexion, $sql);
            while ($datos = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo $datos['nombre_alumno']; ?></td>
                    <td><?php echo $datos['apellido_alumno']; ?></td>
                    <td><?php echo $datos['presente']; ?></td>
                    <td><?php echo $datos['tardanza']; ?></td>
                    <td><?php echo $datos['falta_justificada']; ?></td>
                    <td><?php echo $datos['ausente']; ?></td>
                    <td><?php echo $datos['fecha']; ?></td>
                    
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
            <?php $sql2="SELECT
  COUNT(a.presente) AS total_presentes,
  ROUND((COUNT(a.presente) / COUNT(*)) * 100, 2) AS porcentaje_presentes,
  a.fecha
FROM
  asistencia a
LEFT JOIN
  alumno a2 ON a.inscripcion_asignatura_alumno_idAlumno = a2.idAlumno
WHERE
  a.inscripcion_asignatura_materia_idMateria = '13'
  AND a.fecha = '$fecha';";
  $sql3="SELECT
  COUNT(a.tardanza) AS Total_tardanza,
  ROUND((COUNT(a.tardanza) / COUNT(*)) * 100, 2) AS porcentaje_tardanza,
  a.fecha
FROM
  asistencia a
LEFT JOIN
  alumno a2 ON a.inscripcion_asignatura_alumno_idAlumno = a2.idAlumno
WHERE
  a.inscripcion_asignatura_materia_idMateria = '13'
  AND a.fecha = '$fecha';";


  $sql4="SELECT
  COUNT(a.falta_justificada) AS Total_Justificada,
  ROUND((COUNT(a.falta_justificada) / COUNT(*)) * 100, 2) AS porcentaje_justificada,
  a.fecha
FROM
  asistencia a
LEFT JOIN
  alumno a2 ON a.inscripcion_asignatura_alumno_idAlumno = a2.idAlumno
WHERE
  a.inscripcion_asignatura_materia_idMateria = '13'
  AND a.fecha = '$fecha';";


  $sql5="SELECT
  COUNT(a.ausente) AS Total_ausente,
  ROUND((COUNT(a.ausente) / COUNT(*)) * 100, 2) AS porcentaje_ausente,
  a.fecha
FROM
  asistencia a
LEFT JOIN
  alumno a2 ON a.inscripcion_asignatura_alumno_idAlumno = a2.idAlumno
WHERE
  a.inscripcion_asignatura_materia_idMateria = '13'
  AND a.fecha = '$fecha';";
                    $query2 = mysqli_query($conexion,$sql2);
                     $row1= mysqli_fetch_assoc($query2);
                     $query3 = mysqli_query($conexion,$sql3);
                     $row2= mysqli_fetch_assoc($query3);
                     $query4 = mysqli_query($conexion,$sql4);
                     $row3= mysqli_fetch_assoc($query4);
                     $query5 = mysqli_query($conexion,$sql5);
                     $row4= mysqli_fetch_assoc($query5);
                         ?>
                        <h2 style="color:#ffff;">Porcentaje de presentes: <?php echo $row1['porcentaje_presentes'];?>%,El total de presentes : <?php echo $row1['total_presentes'];?> </h2>
                        <h2 style="color:#ffff;">Porcentaje de Tardanza: <?php echo $row2['porcentaje_tardanza'];?>%,El total de Tardanza : <?php echo $row2['Total_tardanza'];?> </h2>
                        <h2 style="color:#ffff;">Porcentaje de FJustificada: <?php echo $row3['porcentaje_justificada'];?>%,El total de FJustificada : <?php echo $row3['Total_Justificada'];?> </h2>
                        <h2 style="color:#ffff;">Porcentaje de Ausentes: <?php echo $row4['porcentaje_ausente'];?>%,El total de Ausentes : <?php echo $row4['Total_ausente'];?> </h2>
                        <?php ?>
<script>
    var tabla = document.querySelector("#tabla");
    var dataTable = new DataTable(tabla);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>
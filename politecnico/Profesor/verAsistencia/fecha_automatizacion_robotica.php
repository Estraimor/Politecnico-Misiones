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
    
    <style>
        /* Estilos para el input de tipo "date" */
input[type="date"] {
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #ccc;
  font-size: 16px;
}

/* Estilos para el botón de enviar */
input[type="submit"] {
  padding: 10px 20px;
  border-radius: 4px;
  background-color: #4CAF50;
  color: #fff;
  font-size: 18px;
  border: none;
  cursor: pointer;
}

/* Estilos adicionales para espaciado */
br {
  margin-bottom: 10px;
}

    </style>
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
<br><br><br><br><br><br><br>

<br><br>
<center>
<form action="./ver_asistencia_automatizacion_robotica.php" method="get">
    <input type="date" name="fecha" required > <br> <br>
    <input type="submit" value="Enviar" name="enviar">
</form>
</center>
   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>
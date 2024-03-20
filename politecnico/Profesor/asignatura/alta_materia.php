<?php
session_start();
if (empty($_SESSION["id"])){header('Location: login.php');}
?>
<?php include'../../conexion/conexion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../nav/pruebah.css">
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
            <img src="../../imagenes/politecnico.jpg" alt="">
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
<br><br><br><br><br><br>
<center>
<form action="" method="post">
        <?php include'./guardar_materia.php'; ?>    
        <?php
        $sql="select * from profesor";
        $query=mysqli_query($conexion,$sql);
        ?>
    <input  name="nombre" type="text" placeholder="Ingrese el nombre de la Materia">
    <select name="profe" > <?php while($row=mysqli_fetch_assoc($query)){ ?>
    <option hidden>Profesores</option>
        <option value="<?php echo $row['idProrfesor']; ?>"> <?php echo $row['nombre_profe'] ?> -- <?php echo $row['apellido_profe'] ?>  </option>
        <?php }?>
    </select>
    <input type="submit" name="enviar" value="Enviar-Datos">
    </form>
</center>
    
    <br><br><br><br>
    <div class="container-tabla" >
        <table id="tabla" class="table">
            <caption> Asignaturas </caption>
            <thead>
                    <th >Asignatura</th>
                    <th >Nombre - apellido</th>
                    <th> Acciones </th>
            </thead>

            <tbody>
                <?php
                $sql="select m.idMateria  ,m.nombre_materia ,p.nombre_profe ,p.apellido_profe  from materia m 
                inner join profesor p on m.profesor_idProrfesor = p.idProrfesor ";
                $query=mysqli_query($conexion,$sql);
                while ($row=mysqli_fetch_assoc($query)){
                 ?>
                <tr>
                    <td> <?php echo $row['nombre_materia']; ?></td>
                    <td><?php echo $row['nombre_profe']; ?> <?php echo $row['apellido_profe']; ?></td>
                    <td> <a href="./modificar_asignatura.php?id=<?php echo $row['idMateria']; ?>">Modificar</a> --- <a href="./delete_asignatura.php?id=<?php echo $row['idMateria']; ?>">Borrar</a></td>
                    <?php } ?>
                </tr>
            </tbody>

                    <th >Asignatura</th>
                    <th >Nombre - apellido</th>
                    <th> Acciones </th>
        </table>
    </div>

        <script>
        var tabla =document.querySelector("#tabla");
        var dataTable = new DataTable(tabla);
    </script>
</body>
</html>
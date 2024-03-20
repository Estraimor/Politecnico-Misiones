<?php
//session_start();
//if (empty($_SESSION["id"])) {
  //  header('Location: login.php');
    //exit;
//}
include '../../conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../normalize.css">
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../../estilos.css">
    <link rel="stylesheet" type="text/css" href="../../normalize.css">
</head>
<body>
<div class="background">
    <nav class="navbar">
    
    <div class="nav-left">
      <button class="btn-new-member" id="btn-new-member">Nuevo Estudiante</button>
      <button class="btn-new-materia">Nueva Materia</button>
    </div>
    <ul class="nav-options">
      <li class="dropdown">
        <a href="#" class="dropbtn">Enfermeria</a>
        <div class="dropdown-content">
          <a href="#">Primer Año</a>
          <a href="#">Segundo Año</a>
          <a href="#">Tercer Año</a>
        </div>
      </li>
      <li class="dropdown">
        <a href="#" class="dropbtn">Acompañamiento Terapeutico</a>
        <div class="dropdown-content">
          <a href="#">Primer Año</a>
          <a href="#">Segundo Año</a>
          <a href="#">Tercer Año</a>
        </div>
      </li>
      <li class="dropdown">
        <a href="#" class="dropbtn">Comercialización y Marketing</a>
        <div class="dropdown-content">
          <a href="#">Primer Año</a>
          <a href="#">Segundo Año</a>
          <a href="#">Tercer Año</a>
        </div>
      </li>
      <li class="dropdown">
        <a href="#" class="dropbtn">Automatización y Robótica</a>
        <div class="dropdown-content">
          <a href="#">Primer Año</a>
          <a href="#">Segundo Año</a>
          <a href="#">Tercer Año</a>
        </div>
      </li>
      <li class="dropdown">
      <a href="#" class="dropbtn">FP-Programación Web</a>
      </li>
      <li class="dropdown">
      <a href="#" class="dropbtn">FP-Marketing y Venta Digital</a>
      </li>
      <li class="dropdown">
      <a href="#" class="dropbtn">FP-Redes Informáticas</a>
      </li>
    </ul>
  </nav>
</div>


<!--	--------------->

<br>
<br><br><br><br><br>    
<div class="form-container">
    <?php include './guardar_estudiante.php'; ?>
    <h2 class="form-container__h2">Registro de Estudiante</h2>
    <form action="" method="post">
      <input type="text" class="form-container__input" name="nombre_alu" placeholder="Ingrese el nombre" required >
      <input type="text" class="form-container__input" name="apellido_alu" placeholder="Ingrese el apellido" required>
      <input type="number" class="form-container__input" name="dni_alu" placeholder="Ingrese el DNI" required>
      <input type="number" class="form-container__input" name="celular" placeholder="Ingrese el celular" required>
      <input type="number" class="form-container__input" name="legajo" placeholder="Ingrese el número de legajo" required>
      <input type="submit" class="form-container__input" name="enviar" value="Enviar">
    </form>
  </div>


<br><br><br><br>
<button id="btnMostrarEstudiantes">Mostrar Estudiantes Cargados</button>

<div id="tablaContainer" style="display: none;">
    <table id="tabla" class="table table-dark table-striped">
        <thead>
            <tr>
                <th># ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Celular</th>
                <th>Legajo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql1 = "select *
            from alumno a 
            where a.estado = '1'";
            $query1 = mysqli_query($conexion, $sql1);
            while ($datos = mysqli_fetch_assoc($query1)) {
                ?>
                <tr>
                    <td><?php echo $datos['idAlumno']; ?></td>
                    <td><?php echo $datos['nombre_alumno']; ?></td>
                    <td><?php echo $datos['apellido_alumno']; ?></td>
                    <td><?php echo $datos['dni_alumno']; ?></td>
                    <td><?php echo $datos['celular']; ?></td>
                    <td><?php echo $datos['legajo']; ?></td>
                    <td><a href="./modificar_alumno.php?id=<?php echo $datos['idAlumno']; ?>">Modificar</a> -- <a href="./borrado_logico_alumno.php?id=<?php echo $datos['idAlumno']; ?>">Borrar</a></td>

                </tr>
                <?php
            }
            ?>
        </tbody>
        <thead>
            <tr>
                <th># ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Celular</th>
                <th>Legajo</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    var btnMostrarEstudiantes = document.getElementById("btnMostrarEstudiantes");
    var tablaContainer = document.getElementById("tablaContainer");

    btnMostrarEstudiantes.addEventListener("click", function() {
        if (tablaContainer.style.display === "none") {
            tablaContainer.style.display = "block";
        } else {
            tablaContainer.style.display = "none";
        }
    });
</script>
</body>
</html>
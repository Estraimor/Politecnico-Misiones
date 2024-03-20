<?php
session_start();
if (empty($_SESSION["id"])) {
    header('Location: login.php');
    exit;
}
include '../../../conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../stilos_botones.css">
    <link rel="stylesheet" href="../../stilos_nav.css">
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <title>Document</title>
</head>
<body>
<header class="header">
    <div class="logo">
        <a href="../../index_profe.php"><img src="../../../imagenes/politecnico.jpg" alt=""></a>
    </div>
    <nav>
        <ul class="nav-links">
            <li class="submenu">
                <a href="#">Asignatura</a>
                <ul class="sub-menu">
                    <li><a href="../../asignatura/alta_materia.php">Alta Materia</a></li>
                    <li><a href="../../asignatura/inscripcionMateria/inscripcion_materia.php">Inscripcion a Materias</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#">Estudiante</a>
                <ul class="sub-menu">
                    <li><a href="../../estudiante/alta_estudiante.php">Alta Estudiante</a></li>
                </ul>
            </li>
            <li><a href="../asistencia.php">Asistencia</a></li>
        </ul>
    </nav>
    <br><br><br><br>
    <a class="btn" href="../../../login/cerrar_sesion.php"><button>Cerrar sesión</button></a>
</header>
<br><br><br><br>
<center>
    <a href="#" class="btn btn-3">Acompañante terapéutico
        <span></span>
        <span></span>
    </a>
</center>
<br><br>
    <table id="tabla" class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Presente</th>
                <th>Ausente</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "select a2.nombre_alumno ,a2.apellido_alumno ,a.presente, a.ausente,a.fecha  from asistencia a 
            left join alumno a2 on a.inscripcion_asignatura_alumno_idAlumno = a2.idAlumno 
            where a.inscripcion_asignatura_materia_idMateria = '15'";
            $query = mysqli_query($conexion, $sql);
            while ($datos = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo $datos['nombre_alumno']; ?></td>
                    <td><?php echo $datos['apellido_alumno']; ?></td>
                    <td><?php echo $datos['presente']; ?></td>
                    <td><?php echo $datos['ausente']; ?></td>
                    <td><?php echo $datos['fecha']; ?></td>
                    
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
<script>
    var tabla = document.querySelector("#tabla");
    var dataTable = new DataTable(tabla);
</script>
</body>
</html>
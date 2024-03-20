<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../../login/login.php');}
?>
<?php
$server='localhost';
$user='root';
$pass='';
$bd='politecnico';
$conexion=mysqli_connect($server,$user,$pass,$bd, '3306');

if ($conexion) { echo ""; } else { echo "conexion not connected"; }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enfermeria 1ro</title>
    <link rel="stylesheet" type="text/css" href="../../estilos.css">
    <link rel="stylesheet" type="text/css" href="../../normalize.css">
    <link rel="icon" href="../../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>

</head>
<body>

<div class="background">

  <button class="toggle-menu-button" onclick="toggleMenu()">☰</button>
  <nav class="navbar">
    <div class="nav-left">  
    <a href=".././index.php" class="home-button">Inicio</a>
      <button class="btn-new-member" id="btn-new-member">Nuevo Estudiante</button>
      <button class="btn-new-materia" onclick="openMateriaModal()">Nueva Materia</button>
      </div>
    
    
      <ul class="nav-options">
  <li class="dropdown">
  <a href="#" class="dropbtn"> Elegir carrera  <i class="fas fa-chevron-down"></i></a>
    <div class="dropdown-content">
      <div class="submenu">
        <a href="#" class="submenu-trigger">Enfermeria <i class="fas fa-chevron-right"></i></a>
        <div class="sub-dropdown-content">
          <a href="./asistencia_enfermeria.php">Primer Año</a>
          <a href="./asistencia_enfermeria2año.php">Segundo Año</a>
          <a href="./asistencia_enfermeria3año.php">Tercer Año</a>
        </div>
      </div>
      <div class="submenu">
      <a href="#" class="submenu-trigger">Acompañamiento Terapeutico <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
          <a href="./asistencia_acompañante_terapeutico1año.php">Primer Año</a>
          <a href="./asistencia_acompañante_terapeutico2año.php">Segundo Año</a>
          <a href="./asistencia_acompañante_terapeutico3año.php">Tercer Año</a>
        </div>
      </div>
      <div class="submenu">
      <a href="#" class="submenu-trigger">Comercialización y Marketing <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
          <a href="./asistencia_comercializacion_marketing1año.php">Primer Año</a>
          <a href="./asistencia_comercializacion_marketing2año.php">Segundo Año</a>
          <a href="./asistencia_comercializacion_marketing3año.php">Tercer Año</a>
        </div>
      </div>
      <div class="submenu">
      <a href="#" class="submenu-trigger">Automatización y Robótica  <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
          <a href="./asistencia_automatizacion_robotica1año.php">Primer Año</a>
          <a href="./asistencia_automatizacion_robotica2año.php">Segundo Año</a>
          <a href="./asistencia_automatizacion_robotica3año.php">Tercer Año</a>
        </div>
      </div>
      <a href="./asistencia_programacion_web.php" class="submenu-trigger">FP-Programación Web</a>
      <div class="sub-dropdown-content">
        <!-- <a href="./asistencia_programacion_web.php">Primer Año</a> -->
        <!-- <a href="#">Segundo Año</a> -->
      </div>
      <a href="./asistencia_marketing_venta_digital.php" class="submenu-trigger">FP-Marketing y Venta Digital</a>
      <div class="sub-dropdown-content">
        <!-- <a href="./asistencia_marketing_venta_digital.php">Primer Año</a> -->
        <!-- <a href="#">Segundo Año</a> -->
      </div>
      <a href="./asistencia_instalador_redes.php" class="submenu-trigger">FP-Redes Informáticas</a>
      <div class="sub-dropdown-content">
        <!-- <a href="./asistencia_instalador_redes.php">Primer Año</a> -->
        <!-- <a href="#">Segundo Año</a> -->
      </div>
    </div>
  </li>
</ul>
  </nav>
<br><br><br>
<form id="miFormulario" action="./guardar_notas_finales.php" method="post">
    <!-- Inputs para filtrar por nombre, apellido o legajo y por nombre o ID de materia -->
    <input type="text" name="filtroAlumno" id="filtroAlumno" placeholder="Filtrar por nombre, apellido o legajo de alumno">
    <input type="text" name="filtroMateria" id="filtroMateria" placeholder="Filtrar por nombre o ID de materia">

    <!-- Selects para mostrar los resultados -->
    <select name="selectAlumno" id="selectAlumno">
        <option value="">Seleccionar alumno</option>
    </select>

    <select name="selectMateria" id="selectMateria">
        <option value="">Seleccionar materia</option>
    </select>
    <?php
    $sql="select cm.idcondicion_materia , cm.nombre_condicion  from condicion_materia cm "  ;
    $query=mysqli_query($conexion,$sql);?>
<select name="condicion">
<?php while ($datos=mysqli_fetch_assoc($query)){
     ?>
  <option hidden>Selecciona Condicion</option>
  <option value="<?php echo $datos['idcondicion_materia'] ?>"> <?php echo $datos['nombre_condicion'] ?> </option>
  <?php } ?>
  <input type="number" name="nota" placeholder="Ingrese la nota" >
</select>
    <input type="submit" value="Enviar">
</form>
<br><br><br><br>
<table class="table-comision-a" id="tabla" >
                        <thead>
               
                        
            <tr>

                <th>Nombre</th>
                <th>Apellido</th>
                <th>Materia</th>
                <th>Condicion</th>
                <th>Nota Final</th>
            </tr>
                        </thead>
                        <tbody>
    <?php
    $sql = "select a.nombre_alumno , a.apellido_alumno , m.Nombre ,cm.nombre_condicion ,nota  from finales f 
    inner join alumno a on f.alumno_legajo = a.legajo 
    inner join materias m on f.materias_idMaterias = m.idMaterias 
    inner join condicion_materia cm on f.condicion_materia_idcondicion_materia = cm.idcondicion_materia 
    inner join inscripcion_asignatura ia on ia.alumno_legajo = a.legajo ";
    $query = mysqli_query($conexion, $sql);
    while ($datos = mysqli_fetch_assoc($query)) {
        ?>
        
        <tr>
    <td><?php echo $datos['nombre_alumno']; ?></td>
    <td><?php echo $datos['apellido_alumno']; ?></td>
    <td><?php echo $datos['Nombre']; ?></td>
    <td><?php echo $datos['nombre_condicion']; ?></td>
    <td><?php echo $datos['nota']; ?></td>
    
  
 
</tr>

        <?php
    }
    ?>
</tbody>
        
        </table>
<script>
$(document).ready(function() {
    // Función para actualizar el selector de alumnos
    function actualizarSelectAlumnos(alumnos) {
        var selectAlumno = $('#selectAlumno');
        selectAlumno.empty(); // Vaciar el select para llenarlo de nuevo

        // Agregar una opción por cada alumno recibido
        alumnos.forEach(function(alumno) {
            var option = $('<option>', {
                value: alumno.legajo, // Utilizamos el legajo del alumno como valor
                text: alumno.nombre_alumno + ' ' + alumno.apellido_alumno + ' (' + alumno.legajo + ')'
            });
            selectAlumno.append(option);
        });
    }

    // Llamada inicial para llenar el selector de alumnos
    $.ajax({
        url: 'backend.php',
        method: 'POST',
        data: {},
        dataType: 'json', // Especificar que esperamos datos JSON en la respuesta
        success: function(response) {
            actualizarSelectAlumnos(response.alumnos);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    // Función para filtrar los selectores al escribir en los inputs
    $('#filtroAlumno, #filtroMateria').on('input', function() {
        var alumno = $('#filtroAlumno').val();
        var materia = $('#filtroMateria').val();

        // Llamar a la función para actualizar los selectores
        actualizarSelects(alumno, materia);
    });

    function actualizarSelects(alumno, materia) {
        $.ajax({
            url: 'backend.php',
            method: 'POST',
            data: { alumno: alumno, materia: materia },
            dataType: 'json', // Especificar que esperamos datos JSON en la respuesta
            success: function(response) {
                actualizarSelectAlumnos(response.alumnos);

                // Limpiar y llenar select de materia
                var selectMateria = $('#selectMateria');
                selectMateria.empty(); // Vaciar el select para llenarlo de nuevo

                // Agregar una opción por cada materia recibida
                response.materias.forEach(function(materia) {
                    var option = $('<option>', {
                        value: materia.idMaterias,
                        text: materia.Nombre + ' (' + materia.idMaterias + ')'
                    });
                    selectMateria.append(option);
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Interceptamos el envío del formulario para cambiar los valores de los selectores por los IDs
    $('#miFormulario').submit(function() {
        var alumnoSeleccionado = $('#selectAlumno').val();
        var materiaSeleccionada = $('#selectMateria').val();

        // Actualizamos los valores de los selectores por los IDs
        $('#selectAlumno').val(alumnoSeleccionado);
        // El valor de la materia ya es el ID, no es necesario cambiarlo
    });
});
</script>



    
</body>
</html>

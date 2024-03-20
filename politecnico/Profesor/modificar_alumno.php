<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../login/login.php');}
?>
<?php include'../conexion/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencias Politécnico</title>
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link rel="stylesheet" type="text/css" href="../normalize.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>

</head>
<body>
<div id="success-message" class="success-message" style="display: none;"></div>
<div class="background">

<button class="toggle-menu-button" id="toggle-menu-button" onclick="toggleMenu()">
  <span id="toggle-menu-icon">☰</span>
</button>
    <nav class="navbar">
      
    
    



    <div class="nav-right">
    <a href="index.php" class="home-button">Inicio</a>
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
<?php
if (isset($_GET['legajo'])) {
    $legajo = $_GET['legajo'];
    $sql = "select * from alumno a where legajo = '$legajo'";
    $query = mysqli_query($conexion, $sql);?>

<?php while ($datos = mysqli_fetch_assoc($query)) { ?>
    <form action="guardar_modificacion_alumno.php" method="post">
        <input type="text" name="nombre_alumno" value="<?php echo $datos['nombre_alumno']; ?>"><br>
        <input type="text" name="apellido_alumno" value="<?php echo $datos['apellido_alumno']; ?>"><br>
        <input type="number" name="dni_alumno" value="<?php echo $datos['dni_alumno']; ?>"><br>
        <input type="number" name="celular" value="<?php echo $datos['celular']; ?>"><br>
        <input type="text" name="legajo" value="<?php echo $datos['legajo']; ?>"><br>
        <input type="date" name="edad" value="<?php echo $datos['edad']; ?>"><br>
        <input type="text" name="formacion_previa" value="<?php echo $datos['formacion_previa']; ?>"><br>
        <input type="text" name="Trabaja_Horario" value="<?php echo $datos['Trabaja_Horario']; ?>"><br>
        <select id="carreras" name="carreras" required>
            <?php
            


            // Consulta SQL para obtener todas las carreras
            $sql_carreras = "SELECT idCarrera, nombre_carrera FROM carreras";
            $result_carreras = $conexion->query($sql_carreras);

            // Mostrar las opciones del select
            if ($result_carreras->num_rows > 0) {
                while($row_carrera = $result_carreras->fetch_assoc()) {
                    $selected = ""; // Inicialmente ninguna carrera está seleccionada

                    // Verificar si esta carrera está inscrita por el legajo proporcionado
                    $sql_inscripcion = "SELECT 1 FROM inscripcion_asignatura WHERE carreras_idCarrera = ".$row_carrera["idCarrera"]." AND alumno_legajo = '$legajo'";
                    $result_inscripcion = $conexion->query($sql_inscripcion);

                    if ($result_inscripcion->num_rows > 0) {
                        $selected = "selected"; // Marcar como seleccionada si el alumno está inscrito en esta carrera
                    }

                    echo "<option value='".$row_carrera["idCarrera"]."' $selected>".$row_carrera["nombre_carrera"]."</option>";
                }
            } else {
                echo "<option value=''>No se encontraron carreras</option>";
            }

            ?>
        </select><br><br>
        <input type="submit" value="Enviar" name="Enviar" >
    </form>
<?php } ?>

  
<?php

try {
  $html = '<table border="1">
              <tr>
                  <th>Carrera</th>
                  <th>Porcentaje Presente (1er Horario)</th>
                  <th>Porcentaje Ausente (1er Horario)</th>
                  <th>Porcentaje Falta Justificada (1er Horario)</th>
                  <th>Porcentaje Presente (2do Horario)</th>
                  <th>Porcentaje Ausente (2do Horario)</th>
                  <th>Porcentaje Falta Justificada (2do Horario)</th>
              </tr>';

  // Obtener los ID de carrera asociados al alumno
  $sql_id_carrera = "SELECT DISTINCT inscripcion_asignatura_carreras_idCarrera , c.nombre_carrera 
  FROM asistencia a
  inner join carreras c on a.inscripcion_asignatura_carreras_idCarrera = c.idCarrera 
  WHERE inscripcion_asignatura_alumno_legajo = '$legajo'
";
  $query_id_carrera = mysqli_query($conexion, $sql_id_carrera);

  if (!$query_id_carrera) {
      throw new Exception("Error al obtener los ID de carrera: " . mysqli_error($conexion));
  }

  while ($row_id_carrera = mysqli_fetch_assoc($query_id_carrera)) {
      $id_carrera = $row_id_carrera['inscripcion_asignatura_carreras_idCarrera'];
      $carrea=$row_id_carrera['nombre_carrera'];

      // Consulta para calcular el porcentaje de presentes para cada ID de carrera y cada horario
      $sql_porcentaje_presentes = "SELECT 
                                      (SUM(1_Horario = 'Presente') / COUNT(1_Horario)) * 100 AS porcentaje_presentes_1er_horario,
                                      (SUM(2_Horario = 'Presente') / COUNT(2_Horario)) * 100 AS porcentaje_presentes_2do_horario
                                  FROM asistencia 
                                  WHERE 
                                      inscripcion_asignatura_alumno_legajo = '$legajo'
                                      AND inscripcion_asignatura_carreras_idCarrera = '$id_carrera'";
      $query_porcentaje_presentes = mysqli_query($conexion, $sql_porcentaje_presentes);

      if (!$query_porcentaje_presentes) {
          throw new Exception("Error al calcular el porcentaje de presentes: " . mysqli_error($conexion));
      }

      $row_porcentaje_presentes = mysqli_fetch_assoc($query_porcentaje_presentes);
      $porcentaje_presentes_1er_horario = $row_porcentaje_presentes['porcentaje_presentes_1er_horario'];
      $porcentaje_presentes_2do_horario = $row_porcentaje_presentes['porcentaje_presentes_2do_horario'];

      // Consulta para calcular el porcentaje de ausentes y justificados para cada ID de carrera y cada horario
      $sql_porcentaje_ausentes_y_justificados = "SELECT 
                                                      (SUM(1_Horario = 'ausente') / COUNT(1_Horario)) * 100 AS porcentaje_ausentes_1er_horario,
                                                      (SUM(1_Horario = 'justificada') / COUNT(1_Horario)) * 100 AS porcentaje_justificados_1er_horario,
                                                      (SUM(2_Horario = 'ausente') / COUNT(2_Horario)) * 100 AS porcentaje_ausentes_2do_horario,
                                                      (SUM(2_Horario = 'justificada') / COUNT(2_Horario)) * 100 AS porcentaje_justificados_2do_horario
                                                  FROM asistencia 
                                                  WHERE 
                                                      inscripcion_asignatura_alumno_legajo = '$legajo'
                                                      AND inscripcion_asignatura_carreras_idCarrera = '$id_carrera'";
      $query_porcentaje_ausentes_y_justificados = mysqli_query($conexion, $sql_porcentaje_ausentes_y_justificados);

      if (!$query_porcentaje_ausentes_y_justificados) {
          throw new Exception("Error al calcular el porcentaje de ausentes y justificados: " . mysqli_error($conexion));
      }

      $row_porcentaje_ausentes_y_justificados = mysqli_fetch_assoc($query_porcentaje_ausentes_y_justificados);
      $porcentaje_ausentes_1er_horario = $row_porcentaje_ausentes_y_justificados['porcentaje_ausentes_1er_horario'];
      $porcentaje_justificados_1er_horario = $row_porcentaje_ausentes_y_justificados['porcentaje_justificados_1er_horario'];
      $porcentaje_ausentes_2do_horario = $row_porcentaje_ausentes_y_justificados['porcentaje_ausentes_2do_horario'];
      $porcentaje_justificados_2do_horario = $row_porcentaje_ausentes_y_justificados['porcentaje_justificados_2do_horario'];

      // Agregar los resultados a la tabla HTML
      $html .= "<tr>
                  <td>$carrea</td>
                  <td>$porcentaje_presentes_1er_horario%</td>
                  <td>$porcentaje_ausentes_1er_horario%</td>
                  <td>$porcentaje_justificados_1er_horario%</td>
                  <td>$porcentaje_presentes_2do_horario%</td>
                  <td>$porcentaje_ausentes_2do_horario%</td>
                  <td>$porcentaje_justificados_2do_horario%</td>
              </tr>";
  }

  $html .= '</table>';

  echo $html;
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

} else {
    // Manejo de error o redirección si no se proporciona el ID del alumno
    echo "Error: ID de alumno no proporcionado.";
    // Puedes redirigir al usuario o hacer alguna otra acción en caso de error.
}


?>



 

<script>


  function toggleMenu() {
      const navbar = document.querySelector(".navbar");
      navbar.classList.toggle("show-menu");
    }
  // Función para abrir la ventana emergente
  function openModal() {
    var modal = document.getElementById("modal");
    modal.style.display = "block";
    if (window.innerWidth <= 768) {
      toggleMenu(); // Oculta el menú cuando se abre la ventana emergente en modo responsivo
    }
    setTimeout(function() {
    modal.classList.add("show"); // Agrega la clase show para mostrar el modal con animación
  }, 10); 
  
  var welcomeBox = document.querySelector(".welcome-box");
  welcomeBox.style.display = "none"; // Oculta el welcome-box
  setTimeout(function() {
    modal.classList.add("show");
  }, 10);
  } 

  // Función para cerrar la ventana emergente
  function closeModal() {
    var modal = document.getElementById("modal");
  modal.classList.remove("show"); // Remueve la clase show para ocultar el modal con animación
  setTimeout(function() {
    modal.style.display = "none"; // Oculta el modal después de la animación
  }, 300);
  var welcomeBox = document.querySelector(".welcome-box");
  welcomeBox.style.display = "block";
}
  
  document.getElementById("btn-new-member").onclick = function() {
      openModal();
};
    
   function mostrarAlertaExitosa() {
  var successMessage = document.getElementById("success-message");
  successMessage.style.display = "block"; // Muestra el mensaje de éxito

  
}
function closeSuccessMessage() {
  var successMessage = document.getElementById("success-message");
  successMessage.style.display = "none"; // Oculta el mensaje de éxito
}
// Función para abrir el modal de materia
function openMateriaModal() {
  var materiaModal = document.getElementById("materia-modal");
  materiaModal.style.display = "block";
  if (window.innerWidth <= 768) {
    toggleMenu(); // Cierra el menú si se abre en dispositivos móviles
  }
  setTimeout(function () {
    materiaModal.classList.add("show");
  }, 10);

  // Ocultar la caja de bienvenida con una transición
  var welcomeBox = document.getElementById("welcome-box");
  welcomeBox.style.opacity = "0";
  setTimeout(function () {
    welcomeBox.style.display = "none";
  }, 300);
}

// Función para cerrar el modal de materia
function closeMateriaModal() {
  var materiaModal = document.getElementById("materia-modal");
  materiaModal.classList.remove("show");
  setTimeout(function () {
    materiaModal.style.display = "none";
  }, 300);

  // Muestra el mensaje de bienvenida
  var welcomeBox = document.getElementById("welcome-box");
  welcomeBox.style.display = "block";
}
// Escucha el evento 'keydown' en el documento
document.addEventListener('keydown', function (event) {
  if (event.key === 'Escape') {
    // Cierra el modal de Nuevo Estudiante si está abierto
    var estudianteModal = document.getElementById('modal');
    if (estudianteModal.style.display === 'block') {
      closeModal(); // Llama a tu función closeModal para cerrar el modal de Nuevo Estudiante
    }

    // Cierra el modal de Nueva Materia si está abierto
    var materiaModal = document.getElementById('materia-modal');
    if (materiaModal.style.display === 'block') {
      closeMateriaModal(); // Llama a tu función closeMateriaModal para cerrar el modal de Nueva Materia
    }
  }
});

document.addEventListener("DOMContentLoaded", function() {
  console.log("Script cargado");

  // Agrega el evento submit después de que el DOM esté completamente cargado
  var tuFormulario = document.getElementById("tu-formulario");

  if (tuFormulario) {
    // Verifica que el elemento con el ID "tu-formulario" existe
    tuFormulario.addEventListener("submit", function (event) {
      event.preventDefault();

      // Aquí va tu lógica de procesamiento del formulario.

      var envioExitoso = true; 

      if (envioExitoso) {
        document.getElementById("envio-exitoso").value = "1";
      }

      if (envioExitoso) {
        var successMessage = document.getElementById("success-message");
        successMessage.textContent = "Los datos se enviaron correctamente.";
        successMessage.style.display = "block";
      }
    });
  }

  // Resto de tu código JavaScript aquí...

  var btnMostrarEstudiantes = document.getElementById("btnMostrarEstudiantes");
  var estudiantesModal = document.getElementById("estudiantesModal");
  var closeEstudiantesModal = document.getElementById("closeEstudiantesModal");

  btnMostrarEstudiantes.addEventListener("click", function() {
    console.log("Botón clickeado");
    estudiantesModal.style.display = "block";
  });

  closeEstudiantesModal.addEventListener("click", function() {
    estudiantesModal.style.display = "none";
  });

  window.addEventListener("click", function(event) {
    if (event.target === estudiantesModal) {
      estudiantesModal.style.display = "none";
    }
  });
});

// dataTables de Alumnos //
var myTable = document.querySelector("#tabla");
var dataTable = new DataTable(tabla);
  
</script>
</body>
</html>
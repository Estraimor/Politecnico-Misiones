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
<?php include'../conexion/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGPM</title>
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link rel="stylesheet" type="text/css" href="../normalize.css">
    <link rel="stylesheet" type="text/css" href="./estilos_porcentajes.css">
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
      
    <div class="nav-left">  
    <a href="controlador_preceptormodificar.php" class="home-button">Inicio</a>
      
     
      </div>
      
    
    <ul class="nav-options">
  
    
  
  
</ul>

 <div class="nav-right">
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
  
  
   <?php



$legajo = $_GET['legajo'];

?>
<a href="imprimir_alumno.php?legajo=<?php echo $legajo; ?>" class="accion-button"><i class="fa-solid fa-print"></i></a>
<br>
<br>
<?php
try {
    $html_datos_alumno = '<h2 style="color:white; text-shadow: 2px 1px 2px black;">Datos del alumno</h2><br>';
    // Generar tabla de datos del alumno
    $html_datos_alumno .= '<table border="1">
                            <tr>
                                <th>Apellido</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Legajo</th>
                                <th>Edad</th>
                                <th>Observaciones</th>
                                <th>Trabajo</th>
                                <th>Celular</th>
                                <th>Carrera</th>
                            </tr>';

    // Consulta para obtener datos del alumno
    $sql_datos_alumno = "SELECT *
                            FROM alumno a
                            INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.legajo
                            INNER JOIN carreras c ON c.idCarrera = ia.carreras_idCarrera 
                        WHERE legajo = '$legajo'";
    $query_datos_alumno = mysqli_query($conexion, $sql_datos_alumno);

    if (!$query_datos_alumno) {
        throw new Exception("Error al obtener los datos del alumno: " . mysqli_error($conexion));
    }

    $row_datos_alumno = mysqli_fetch_assoc($query_datos_alumno);

    // Agregar los datos del alumno a la tabla HTML
    $html_datos_alumno .= "<tr>
                            <td>{$row_datos_alumno['apellido_alumno']}</td>
                            <td>{$row_datos_alumno['nombre_alumno']}</td>
                            <td>{$row_datos_alumno['dni_alumno']}</td>
                            <td>$legajo</td>
                            <td>{$row_datos_alumno['edad']}</td>
                            <td>{$row_datos_alumno['observaciones']}</td>
                            <td>{$row_datos_alumno['Trabaja_Horario']}</td>
                            <td>{$row_datos_alumno['celular']}</td>
                            <td>{$row_datos_alumno['nombre_carrera']}</td>
                          </tr>";

    $html_datos_alumno .= '</table>';

    // Imprimir tabla de datos del alumno
    echo $html_datos_alumno;

    // Generar tabla de asistencias
$html_asistencias = '<br><h2 style="color:white; text-shadow: 2px 1px 2px black;">Asistencias</h2><br>';
$html_asistencias .= '<table border="1">
                        <tr>
                            <th>Materia</th>
                            <th>Porcentaje Presente</th>
                            <th>Porcentaje Ausente</th>
                        </tr>';

// Obtener los datos de asistencia combinando ambos horarios
$sql_asistencias = "SELECT 
                        m.Nombre,
                        (SUM(CASE WHEN a.1_Horario = 'Presente' OR a.2_Horario = 'Presente' THEN 1 ELSE 0 END) + SUM(CASE WHEN a.1_Horario = 'Presente' AND a.2_Horario = 'Presente' THEN 1 ELSE 0 END)) AS asistencias,
                        (SUM(CASE WHEN a.1_Horario = 'Ausente' OR a.2_Horario = 'Ausente' THEN 1 ELSE 0 END) + SUM(CASE WHEN a.1_Horario = 'Ausente' AND a.2_Horario = 'Ausente' THEN 1 ELSE 0 END)) AS ausencias,
                        COUNT(*) AS total_clases
                    FROM 
                        asistencia a
                    INNER JOIN 
                        materias m ON a.materias_idMaterias = m.idMaterias
                    WHERE 
                        a.inscripcion_asignatura_alumno_legajo = '$legajo'
                    GROUP BY 
                        m.Nombre";

$query_asistencias = mysqli_query($conexion, $sql_asistencias);

if (!$query_asistencias) {
    throw new Exception("Error al obtener las asistencias: " . mysqli_error($conexion));
}

while ($row_asistencias = mysqli_fetch_assoc($query_asistencias)) {
    // Calcular porcentaje de asistencia y ausencia
    $porcentaje_asistencia = $row_asistencias['asistencias'] * 100.0 / $row_asistencias['total_clases'];
    $porcentaje_ausencia = $row_asistencias['ausencias'] * 100.0 / $row_asistencias['total_clases'];

    // Agregar fila a la tabla de asistencias
    $html_asistencias .= "
                        <tr>
                            <td>{$row_asistencias['Nombre']}</td>
                            <td>{$porcentaje_asistencia}</td>
                            <td>{$porcentaje_ausencia}</td>
                        </tr>";
}

$html_asistencias .= '</table>';

// Imprimir tabla de asistencias
echo $html_asistencias;


    // Generar tabla de justificaciones del alumno
    $html_justificaciones = '<br><h2 style="color:white; text-shadow: 2px 1px 2px black;">Justificaciones</h2><br>';
    $html_justificaciones .= '<table border="1">
                                <tr>
                                    <th>Materia</th>
                                    <th>Materia2</th>
                                    <th>Motivo</th>
                                    <th>Fecha</th>
                                </tr>';

    // Consulta para obtener las justificaciones del alumno
    $sql_justificaciones = "SELECT 
                                c.nombre_carrera,
                                a2.nombre_alumno,
                                a2.apellido_alumno,
                                m.Nombre AS materia,
                                m.Nombre AS materia2,
                                a.Motivo,
                                a.fecha 
                            FROM 
                                alumnos_justificados a
                            INNER JOIN 
                                carreras c ON c.idCarrera = a.inscripcion_asignatura_carreras_idCarrera
                            INNER JOIN 
                                alumno a2 ON a.inscripcion_asignatura_alumno_legajo = a2.legajo
                            INNER JOIN 
                                materias m ON m.idMaterias = a.materias_idMaterias
                            WHERE 
                                a.inscripcion_asignatura_alumno_legajo = '$legajo'";

    $query_justificaciones = mysqli_query($conexion, $sql_justificaciones);

    if (!$query_justificaciones) {
        throw new Exception("Error al obtener las justificaciones: " . mysqli_error($conexion));
    }

    while ($row_justificacion = mysqli_fetch_assoc($query_justificaciones)) {
        // Agregar fila a la tabla de justificaciones
        $html_justificaciones .= "<tr>
                                    <td>{$row_justificacion['materia']}</td>
                                    <td>{$row_justificacion['materia2']}</td>
                                    <td>{$row_justificacion['Motivo']}</td>
                                    <td>{$row_justificacion['fecha']}</td>
                                </tr>";
    }

    $html_justificaciones .= '</table>';

    // Imprimir tabla de justificaciones
    echo $html_justificaciones;

    // Generar tabla de ratificaciones del alumno
    $html_ratificaciones = '<br><h2 style="color:white; text-shadow: 2px 1px 2px black;">Días que se retiró antes de tiempo</h2><br>';
    $html_ratificaciones .= '<table border="1">
                            <tr>
                                <th>Materia</th>
                                <th>Motivo</th>
                                <th>Fecha</th>
                            </tr>';

    // Consulta para obtener las ratificaciones del alumno
    $sql_ratificaciones = "SELECT 
                                a2.legajo, 
                                a2.apellido_alumno,
                                a2.nombre_alumno,
                                c.nombre_carrera,
                                m.Nombre AS materia,
                                p.nombre_profe,
                                a.motivo,
                                a.fecha 
                            FROM 
                                alumnos_rat a
                            INNER JOIN 
                                alumno a2 ON a.alumno_legajo = a2.legajo
                            INNER JOIN 
                                carreras c ON a.carreras_idCarrera = c.idCarrera
                            INNER JOIN 
                                materias m ON a.materias_idMaterias = m.idMaterias
                            INNER JOIN 
                                profesor p ON a.profesor_idProrfesor = p.idProrfesor
                            WHERE 
                                a.alumno_legajo = '$legajo'";

    $query_ratificaciones = mysqli_query($conexion, $sql_ratificaciones);

    if (!$query_ratificaciones) {
        throw new Exception("Error al obtener las ratificaciones: " . mysqli_error($conexion));
    }

    while ($row_ratificacion = mysqli_fetch_assoc($query_ratificaciones)) {
        // Agregar fila a la tabla de ratificaciones
        $html_ratificaciones .= "<tr>
                                    <td>{$row_ratificacion['materia']}</td>
                                    <td>{$row_ratificacion['motivo']}</td>
                                    <td>{$row_ratificacion['fecha']}</td>
                                </tr>";
    }

    $html_ratificaciones .= '</table>';

    // Imprimir tabla de ratificaciones
    echo $html_ratificaciones;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
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
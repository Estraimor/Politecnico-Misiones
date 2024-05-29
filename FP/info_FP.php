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
    <title>SGPM</title>
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link rel="stylesheet" type="text/css" href="../normalize.css">
    <link rel="stylesheet" type="text/css" href="../Profesor/estilos_porcentajes.css">
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
    <a href="../Profesor/controlador_preceptormodificar.php" class="home-button">Inicio</a>
      
     
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
$html_datos_alumno .= '<table border="1">
                            <tr>
                                <th>Apellido</th>
                                <th>Nombre</th>
                                <th>DNI</th>
                                <th>Legajo</th>
                                <th>Observaciones</th>
                                <th>Trabajo</th>
                                <th>Celular</th>
                                <th>Carrera1</th>
                                <th>Carrera2</th>
                                <th>Carrera3</th>
                                <th>Carrera4</th>
                            </tr>';

$sql_datos_alumno = "SELECT *, 
    c1.nombre_carrera AS nombre_carrera1, 
    c2.nombre_carrera AS nombre_carrera2, 
    c3.nombre_carrera AS nombre_carrera3, 
    c4.nombre_carrera AS nombre_carrera4
FROM alumnos_fp af
LEFT JOIN carreras c1 ON af.carreras_idCarrera = c1.idCarrera
LEFT JOIN carreras c2 ON af.carreras_idCarrera1 = c2.idCarrera
LEFT JOIN carreras c3 ON af.carreras_idCarrera2 = c3.idCarrera
LEFT JOIN carreras c4 ON af.carreras_idCarrera3 = c4.idCarrera
WHERE legajo_afp  = '$legajo';";
$query_datos_alumno = mysqli_query($conexion, $sql_datos_alumno);

if (!$query_datos_alumno) {
    throw new Exception("Error al obtener los datos del alumno: " . mysqli_error($conexion));
}

$row_datos_alumno = mysqli_fetch_assoc($query_datos_alumno);

$html_datos_alumno .= "<tr>
                            <td>{$row_datos_alumno['apellido_afp']}</td>
                            <td>{$row_datos_alumno['nombre_afp']}</td>
                            <td>{$row_datos_alumno['dni_afp']}</td>
                            <td>$legajo</td>
                            <td>{$row_datos_alumno['observaciones_afp']}</td>
                            <td>{$row_datos_alumno['trabaja_fp']}</td>
                            <td>{$row_datos_alumno['celular_afp']}</td>
                            <td>{$row_datos_alumno['nombre_carrera1']}</td>
                            <td>{$row_datos_alumno['nombre_carrera2']}</td>
                            <td>{$row_datos_alumno['nombre_carrera3']}</td>
                            <td>{$row_datos_alumno['nombre_carrera4']}</td>
                          </tr>";

$html_datos_alumno .= '</table>';

// Imprimir tabla de datos del alumno
echo $html_datos_alumno;


    // Generar tabla de asistencias
    $html_asistencias = '<br><h2 style="color:white; text-shadow: 2px 1px 2px black;">Asistencias</h2><br>';
    $html_asistencias .= '<table border="1">
                            <tr>
                                <th>Materia</th>
                                <th>Porcentaje Presente (1er Horario)</th>
                                <th>Porcentaje Ausente (1er Horario)</th>
                            </tr>';

    // Obtener los ID de carrera asociados al alumno
    $sql_id_carrera = "SELECT 
    afp.carreras_idCarrera,
    c.nombre_carrera,
    m.Nombre,
    SUM(CASE WHEN afp.1_horario = 'Presente' THEN 1 ELSE 0 END) AS asistencias_1er_horario,
    SUM(CASE WHEN afp.1_horario = 'Ausente' THEN 1 ELSE 0 END) AS ausencias_1er_horario,
    COUNT(*) AS total_clases
FROM 
    asistencia_FP afp
INNER JOIN 
    carreras c ON afp.carreras_idCarrera = c.idCarrera
INNER JOIN 
    materias m ON afp.materias_idMaterias = m.idMaterias
WHERE 
     afp.alumnos_fp_legajo_afp = '$legajo'
GROUP BY 
    afp.carreras_idCarrera, c.nombre_carrera, m.Nombre;";

    $query_id_carrera = mysqli_query($conexion, $sql_id_carrera);

    if (!$query_id_carrera) {
        throw new Exception("Error al obtener los ID de carrera: " . mysqli_error($conexion));
    }

    while ($row_id_carrera = mysqli_fetch_assoc($query_id_carrera)) {
        // Calcular porcentaje de asistencia y ausencia para cada horario
        $porcentaje_asistencia_1er_horario = $row_id_carrera['asistencias_1er_horario'] * 100.0 / $row_id_carrera['total_clases'];
        $porcentaje_ausencia_1er_horario = $row_id_carrera['ausencias_1er_horario'] * 100.0 / $row_id_carrera['total_clases'];
        

        // Agregar fila a la tabla de asistencias
        $html_asistencias .= "
                            <tr>
                                <td>{$row_id_carrera['Nombre']}</td>
                                <td>{$porcentaje_asistencia_1er_horario}</td>
                                <td>{$porcentaje_ausencia_1er_horario}</td>
                            </tr>";
    }

    $html_asistencias .= '</table>';

    // Imprimir tabla de asistencias
    echo $html_asistencias;

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
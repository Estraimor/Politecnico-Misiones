<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../../login/login.php');}

// Set inactivity limit in seconds
$inactivity_limit = 1200;

// Check if the user has been inactive for too long
if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > $inactivity_limit)) {
    // User has been inactive, so destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: ../../login/login.php");
    exit; // Terminar el script después de redireccionar
} else {
    // Update the session time to the current time
    $_SESSION['time'] = time();
}
?>
<?php include'../../conexion/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencias Politécnico</title>
    <link rel="stylesheet" type="text/css" href="../../estilos.css">
    <link rel="stylesheet" type="text/css" href="../../Profesor/estilos_modificar_estudiante.css">
    <link rel="stylesheet" type="text/css" href="../../normalize.css">
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
    <a href="../../Profesor/controlador_preceptormodificar.php" class="home-button">Inicio</a>
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
  <?php
include '../../conexion/conexion.php';

if (isset($_GET['legajo'])) {
    $legajo = $_GET['legajo'];
    $sql = "SELECT * FROM alumnos_fp WHERE legajo_afp = '$legajo'";
    $query = mysqli_query($conexion, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $datos = mysqli_fetch_assoc($query);
        ?>

        <form action="guardar_modificacionFP.php" method="post" class="formulario">
            <input type="text" class="form-container__input" name="nombre_alumno" placeholder="Nombre" value="<?php echo $datos['nombre_afp']; ?>" class="input-text"><br>
            <input type="text" class="form-container__input" name="apellido_alumno" placeholder="Apellido" value="<?php echo $datos['apellido_afp']; ?>" class="input-text"><br>
            <input type="number" class="form-container__input" name="dni_alumno" placeholder="DNI (sin puntos)" value="<?php echo $datos['dni_afp']; ?>" class="input-text"><br>
            <input type="number" class="form-container__input" name="celular" placeholder="Celular" value="<?php echo $datos['celular_afp']; ?>" class="input-text"><br>
            <input type="text" class="form-container__input" name="legajo" placeholder="N° Legajo" value="<?php echo $datos['legajo_afp']; ?>" class="input-text" readonly><br>
            <input type="text" class="form-container__input" name="observaciones" placeholder="Observaciones" value="<?php echo $datos['observaciones_afp']; ?>" class="input-text"><br>
            <input type="text" class="form-container__input" name="Trabaja_Horario" placeholder="Trabaja_Horario" value="<?php echo $datos['trabaja_fp']; ?>" class="input-text"><br>

            <?php
            // Consulta para obtener las carreras del alumno
            $sql_carreras_alumno = "SELECT carreras_idCarrera FROM alumnos_fp_has_carreras WHERE alumnos_fp_legajo_afp = '$legajo'";
            $result_carreras_alumno = mysqli_query($conexion, $sql_carreras_alumno);
            $carreras_alumno = array();
            while ($row = mysqli_fetch_assoc($result_carreras_alumno)) {
                $carreras_alumno[] = $row['carreras_idCarrera'];
            }

            // Consulta para obtener todas las carreras
            $sql_carreras = "SELECT idCarrera, nombre_carrera FROM carreras c
                              WHERE c.idCarrera in('8','14','15','64','65')";
            $result_carreras = mysqli_query($conexion, $sql_carreras);

            // Mostrar los selects con las carreras inscritas y la opción de seleccionar carrera
            for ($i = 1; $i <= 4; $i++) {
                echo '<select name="carreras_' . $i . '" class="input-text">';
                if (isset($carreras_alumno[$i - 1])) {
                    // Mostrar la carrera en la que está inscrito
                    while ($row_carrera = mysqli_fetch_assoc($result_carreras)) {
                        $selected = $row_carrera['idCarrera'] == $carreras_alumno[$i - 1] ? 'selected' : '';
                        echo '<option value="' . $row_carrera['idCarrera'] . '" ' . $selected . '>' . $row_carrera['nombre_carrera'] . '</option>';
                    }
                } else {
                    // Mostrar la opción de seleccionar carrera
                    echo '<option value="" hidden selected>Selecciona una carrera</option>';
                    while ($row_carrera = mysqli_fetch_assoc($result_carreras)) {
                        echo '<option value="' . $row_carrera['idCarrera'] . '">' . $row_carrera['nombre_carrera'] . '</option>';
                    }
                }
                mysqli_data_seek($result_carreras, 0); // Resetear el puntero de resultados
                echo '</select><br>';
            }
            ?>

            <input type="submit" value="Enviar" name="Enviar" class="form-container__input" class="btn-enviar">
        </form>

        <?php
    } else {
        echo "Error: No se encontró al alumno con el legajo proporcionado.";
    }
} else {
    echo "Error: ID de alumno no proporcionado.";
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
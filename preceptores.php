<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ./login/login.php');}

// Set inactivity limit in seconds
$inactivity_limit = 1200;

// Check if the user has been inactive for too long
if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > $inactivity_limit)) {
    // User has been inactive, so destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: ./login/login.php");
    exit; // Terminar el script después de redireccionar
} else {
    // Update the session time to the current time
    $_SESSION['time'] = time();
}
?>
<?php include'./conexion/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGPM-Preceptores</title>
    <link rel="stylesheet" type="text/css" href="./estilos.css">
    <link rel="stylesheet" type="text/css" href="./normalize.css">
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
            <a href="index.php" class="home-button">Inicio</a>
            <button class="btn-new-member" id="btn-new-member">Nuevo Estudiante</button>
            <button class="btn-situacion-academica">
              <a href="../proximamente/proximamente.php" class="btn-link">Situación Académica</a>
            </button>
          
          </div>

   
    <div class="nav-right">
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
    
    
    
</nav>
 
  <div id="modal" class="modal">
  <div class="modal-content">
  <span class="close" onclick="closeModal()">&times;</span>
  <?php include'./Profesor/estudiante/guardar_estudiante.php'; ?>
    <h2 class="form-container__h2">Registro de Estudiante</h2>
    <form action="" method="post">
      <input type="text" class="form-container__input" name="nombre_alu" placeholder="Ingrese el nombre" autocomplete="off" required>
      <input type="text" class="form-container__input" name="apellido_alu" placeholder="Ingrese el apellido" autocomplete="off" required>
      <input type="number" class="form-container__input" name="dni_alu" placeholder="Ingrese el DNI" autocomplete="off" required>
      <input type="number" class="form-container__input" name="celular" placeholder="Ingrese el celular" autocomplete="off" >
      <input type="number" class="form-container__input" name="legajo" placeholder="Ingrese el número de legajo" autocomplete="off" required>
      <input type="date" class="form-container__input" name="edad" placeholder="Ingrese fecha de nacimiento" autocomplete="off" >
      <input type="text" class="form-container__input" name="observaciones" placeholder="Observaciones" autocomplete="off" required>
      <input type="text" class="form-container__input" name="Trabajo_Horario" placeholder="Trabajo / Horario" autocomplete="off" required>
            <!-- php para la recorrida de las carreras del select -->
      <?php
       $sql_mater="select * from carreras c ";
       $peticion=mysqli_query($conexion,$sql_mater);
       ?>      
      <select name="inscripcion_carrera" class="form-container__input"> 
        <option hidden >Selecciona una carrera </option>
        <?php while($informacion=mysqli_fetch_assoc($peticion)){ ?>
          <option value="<?php echo $informacion['idCarrera'] ?>"><?php echo $informacion['nombre_carrera'] ?></option>
          <?php }?>
      </select>

      <input type="submit" class="form-container__input" name="enviar" value="Enviar" onclick="mostrarAlertaExitosa(); closeSuccessMessage();">
    </form>
    
  </div>
</div>

<br>
<br>
<br>
        <div class="preceptores">
            <button>
                <a href="./indexs/preceptor_1.php" class="preceptores_botones">Manuel Salas</a>
            </button>
            <button>
                <a href="./indexs/preceptor_2.php" class="preceptores_botones">Mariela Nasadyk</a>
            </button>
            <button>
                <a href="./indexs/preceptor_3.php" class="preceptores_botones">Carla Kansel</a>
            </button>
            <button>
                <a href="./indexs/preceptor_4.php" class="preceptores_botones">Jorge Torales</a>
            </button>
            <button>
                <a href="./indexs/preceptor_5.php" class="preceptores_botones">Carla Gimenez</a>
            </button>
            <button>
                <a href="./indexs/preceptor_6.php" class="preceptores_botones">Luciano Barros</a>
            </button>
        </div>
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
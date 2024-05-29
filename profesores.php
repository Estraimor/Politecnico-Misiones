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
    <title>SGPM-Profesores</title>
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
            <a href="./Profesores/controlador_preceptormodificar.php" class="home-button">Inicio</a>
            <button class="btn-new-member" id="btn-new-member">Nuevo Estudiante</button>
            <button class="btn-situacion-academica">
              <a href="./Profesor/notas/login_notas/index_notas.php" class="btn-link">Situación Académica</a>
            </button>
            <button class="btn-preceptores">
              <a href="#">Preceptores</a>
            </button>
          </div>

    <ul class="nav-options">
      <li class="dropdown">
        <a href="#" class="dropbtn"> Elegir carrera <i class="fas fa-chevron-down"></i></a>
          <div class="dropdown-content">
              <div class="submenu">
                <a href="#" class="submenu-trigger">Enfermeria <i class="fas fa-chevron-right"></i></a>
                  <div class="sub-dropdown-content">
                    <a href="./Profesor/asistencia/asistencia_enfermeria.php">Primer Año</a>
                    <a href="./Profesor/asistencia/asistencia_enfermeria2ano.php">Segundo Año</a>
                    <a href="./Profesor/asistencia/asistencia_enfermeria3ano.php">Tercer Año</a>
                  </div>
              </div>
              <div class="submenu">
                <a href="#" class="submenu-trigger">Acompañamiento Terapeutico <i class="fas fa-chevron-right"></i></a>
                  <div class="sub-dropdown-content">
                    <a href="./Profesor/asistencia/asistencia_acompanante_terapeutico1ano.php">Primer Año</a>
                    <a href="./Profesor/asistencia/asistencia_acompanante_terapeutico2ano.php">Segundo Año</a>
                    <a href="./Profesor/asistencia/asistencia_acompanante_terapeutico1ano.php">Tercer Año</a>
                  </div>
              </div>
              <div class="submenu">
                <a href="#" class="submenu-trigger">Comercialización y Marketing <i class="fas fa-chevron-right"></i></a>
                  <div class="sub-dropdown-content">
                    <a href="./Profesor/asistencia/asistencia_comercializacion_marketing1ano.php">Primer Año</a>
                    <a href="./Profesor/asistencia/asistencia_comercializacion_marketing2ano.php">Segundo Año</a>
                    <a href="./Profesor/asistencia/asistencia_comercializacion_marketing3ano.php">Tercer Año</a>
                  </div>
              </div>
              <div class="submenu">
                <a href="#" class="submenu-trigger">Automatización y Robótica  <i class="fas fa-chevron-right"></i></a>
                  <div class="sub-dropdown-content">
                    <a href="./Profesor/asistencia/asistencia_automatizacion_robotica1ano.php">Primer Año</a>
                    <a href="./Profesor/asistencia/asistencia_automatizacion_robotica2ano.php  ">Segundo Año</a>
                    <a href="#">Tercer Año</a>
                  </div>
              </div>
                    <a href="asistencia_programacion_web.php" class="submenu-trigger">FP-Programación Web</a>
                    <a href="#" class="submenu-trigger">FP-Marketing y Venta Digital</a>
                    <a href="#" class="submenu-trigger">FP-Redes Informáticas</a>
 
      </li>
    </ul>
    <div class="nav-right">
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
    
    
    
</nav>
  <button id="btnMostrarEstudiantes">Estudiantes</button>
   <!-- Modal para la tabla de estudiantes -->
   <div id="estudiantesModal" class="estudiantes-modal">
    <div class="modal-content-estudiantes">
    <span class="modal-close-estudiantes close-modal-button" id="closeEstudiantesModal">&times; Cerrar</span>
        <div id="tablaContainerEstudiantes">
            <table id="tabla">
        <thead>
            <tr>
                <th>Legajo</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Celular</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql1 = "select *
            from alumno 
            where estado = '1'";
            $query1 = mysqli_query($conexion, $sql1);
            while ($datos = mysqli_fetch_assoc($query1)) {
                ?>
                <tr>
                    <td><?php echo $datos['legajo']; ?></td>
                    <td><?php echo $datos['apellido_alumno']; ?></td>
                    <td><?php echo $datos['nombre_alumno']; ?></td>
                    <td><?php echo $datos['dni_alumno']; ?></td>
                    <td><?php echo $datos['celular']; ?></td>
                    <td><a href="./Profesor/modificar_alumno.php?legajo=<?php echo $datos['legajo']; ?>" class="modificar-button"><i class="fas fa-pencil-alt"></i></a>
                   <a href="./Profesor/borrado_logico_alumno.php?legajo=<?php echo $datos['legajo']; ?>" class="borrar-button"><i class="fas fa-trash-alt"></i></a>
                   <a href="./Profesor/porcentajes_de_asistencia.php?legajo=<?php echo $datos['legajo']; ?>" class="accion-button"><i class="fas fa-exclamation"></i></a></td>



                </tr>
                <?php
            }
            ?>
        </tbody>
        
    </table>
            </div>
        </div>
    </div>
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
                <a href="./profesores_notas/BUSTAMANTE_MARIELA_ANDREA.php" class="preceptores_botones">Bustamante Mariela</a>
            </button>
            <button>
                <a href="./indexs/preceptor_2.php" class="preceptores_botones">2</a>
            </button>
            <button>
                <a href="./indexs/preceptor_3.php" class="preceptores_botones">3</a>
            </button>
            <button>
                <a href="./indexs/preceptor_4.php" class="preceptores_botones">4</a>
            </button>
            <button>
                <a href="./indexs/preceptor_5.php" class="preceptores_botones">5</a>
            </button>
            <button>
                <a href="./indexs/preceptor_6.php" class="preceptores_botones">6</a>
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
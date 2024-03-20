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
      
    <div class="nav-left">  
    <a href="index.php" class="home-button">Inicio</a>
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
          <a href="./asistencia/asistencia_enfermeria.php">Primer Año</a>
          <a href="./asistencia/asistencia_enfermeria2año.php">Segundo Año</a>
          <a href="./asistencia/asistencia_enfermeria3año.php">Tercer Año</a>
        </div>
      </div>
      <div class="submenu">
      <a href="#" class="submenu-trigger">Acompañamiento Terapeutico <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
          <a href="./asistencia/asistencia_acompañante_terapeutico1año.php">Primer Año</a>
          <a href="./asistencia/asistencia_acompañante_terapeutico2año.php">Segundo Año</a>
          <a href="./asistencia/asistencia_acompañante_terapeutico3año.php">Tercer Año</a>
        </div>
      </div>
      <div class="submenu">
      <a href="#" class="submenu-trigger">Comercialización y Marketing <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
          <a href="./asistencia/asistencia_comercializacion_marketing1año.php">Primer Año</a>
          <a href="./asistencia/asistencia_comercializacion_marketing2año.php">Segundo Año</a>
          <a href="./asistencia/asistencia_comercializacion_marketing3año.php">Tercer Año</a>
        </div>
      </div>
      <div class="submenu">
      <a href="#" class="submenu-trigger">Automatización y Robótica  <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
          <a href="./asistencia/asistencia_automatizacion_robotica1año.php">Primer Año</a>
          <a href="./asistencia/asistencia_automatizacion_robotica2año.php  ">Segundo Año</a>
          <a href="#">Tercer Año</a>
        </div>
      </div>
      <a href="#" class="submenu-trigger">FP-Programación Web</a>
      <div class="sub-dropdown-content">
        <a href="#">Primer Año</a>
        <a href="#">Segundo Año</a>
      </div>
      <a href="#" class="submenu-trigger">FP-Marketing y Venta Digital</a>
      <div class="sub-dropdown-content">
        <a href="#">Primer Año</a>
        <a href="#">Segundo Año</a>
      </div>
      <a href="#" class="submenu-trigger">FP-Redes Informáticas</a>
      <div class="sub-dropdown-content">
        <a href="#">Primer Año</a>
        <a href="#">Segundo Año</a>
      </div>
      
    </div>
    
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
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Celular</th>
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
                    <td><?php echo $datos['legajo']; ?></td>
                    <td><?php echo $datos['nombre_alumno']; ?></td>
                    <td><?php echo $datos['apellido_alumno']; ?></td>
                    <td><?php echo $datos['dni_alumno']; ?></td>
                    <td><?php echo $datos['celular']; ?></td>
                    <td><a href="./modificar_alumno.php?legajo=<?php echo $datos['legajo']; ?>" class="modificar-button"><i class="fas fa-pencil-alt"></i></a>
                   <a href="./borrado_logico_alumno.php?legajo=<?php echo $datos['legajo']; ?>" class="borrar-button"><i class="fas fa-trash-alt"></i></a></td>



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
  <?php include'./estudiante/guardar_estudiante.php'; ?>
    <h2 class="form-container__h2">Registro de Estudiante</h2>
    <form action="" method="post">
      <input type="text" class="form-container__input" name="nombre_alu" placeholder="Ingrese el nombre" autocomplete="off" required>
      <input type="text" class="form-container__input" name="apellido_alu" placeholder="Ingrese el apellido" autocomplete="off" required>
      <input type="number" class="form-container__input" name="dni_alu" placeholder="Ingrese el DNI" autocomplete="off" required>
      <input type="number" class="form-container__input" name="celular" placeholder="Ingrese el celular" autocomplete="off" required>
      <input type="number" class="form-container__input" name="legajo" placeholder="Ingrese el número de legajo" autocomplete="off" required>
      <input type="date" class="form-container__input" name="edad" placeholder="Ingrese fecha de nacimiento" autocomplete="off" required>
      <input type="text" class="form-container__input" name="informacion_previa" placeholder="Ingrese formación previa" autocomplete="off" required>
      <input type="text" class="form-container__input" name="Trabajo_Horario" placeholder="Trabajo / Horario" autocomplete="off" required>
            <!-- php para la recorrida de las carreras del select -->
      <?php
       $sql_mater="select * from carreras c ";
       $peticion=mysqli_query($conexion,$sql_mater);
       ?>      
      <select name="inscripcion_carrera"> 
        <option hidden >Selecciona una carrera </option>
        <?php while($informacion=mysqli_fetch_assoc($peticion)){ ?>
          <option value="<?php echo $informacion['idCarrera'] ?>"><?php echo $informacion['nombre_carrera'] ?></option>
          <?php }?>
      </select>

      <input type="submit" class="form-container__input" name="enviar" value="Enviar" onclick="mostrarAlertaExitosa(); closeSuccessMessage();">
    </form>
    
  </div>
</div>
<div id="materia-modal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeMateriaModal()">&times;</span>
    <!-- Tu formulario de materia aquí -->
    <form action="" method="post">
      <?php include './asignatura/guardar_materia.php'; ?>    
      <?php
      $sql = "select * from profesor";
      $query = mysqli_query($conexion, $sql);
      ?>
      <input name="nombre" type="text" placeholder="Ingrese el nombre de la Materia" autocomplete="off">
      <select name="profe1">
        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
          <option hidden>Profesores</option>
          <option value="<?php echo $row['idProrfesor']; ?>"> <?php echo ucwords($row['nombre_profe']) ?> <?php echo ucwords($row['apellido_profe']) ?>  </option>
        <?php } ?>
      </select>
      <select name="profe2">
    <?php mysqli_data_seek($query, 0); // Reiniciar el puntero del resultado ?>
    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
      <option hidden>Profesores</option>
      <option value="<?php echo $row['idProrfesor']; ?>"> <?php echo ucwords($row['nombre_profe']) ?> <?php echo ucwords($row['apellido_profe']) ?>  </option>
    <?php } ?>
  </select>
      <input type="submit" name="enviar" value="Enviar-Datos">
    </form>
  </div>
</div>

<div class="nav-welcome-container">

<div id="welcome-box" class="welcome-box">
  <h1 class="welcome-box__h1">Bienvenido/a</h1>
  <p class="welcome-box__p">¡Selecciona una carrera para tomar asistencia!</p>
</div>
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
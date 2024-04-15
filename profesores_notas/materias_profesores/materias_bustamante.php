<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../login/login.php');}
?>
<?php include'../../../../conexion/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGPM-Bustamante Mariela</title>
    <link rel="stylesheet" type="text/css" href="../../../../estilos.css">
    <link rel="stylesheet" type="text/css" href="../../../../normalize.css">
    <link rel="stylesheet" type="text/css" href="../../../estilos_porcentajes.css">
    <link rel="icon" href="../../../../politecnico.ico">
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
    <a href="../BUSTAMANTE_MARIELA_ANDREA.PHP" class="home-button">Inicio</a>
      
     
      </div>
      
    
    <ul class="nav-options">
  
    
  
  
</ul>
 <div class="nav-right">
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
  
  <div class="contenedor">
        <h1>Enfermeria 1er Año</h1>
        <div class="hilera">
            <h2>Comisión A</h2>
            <button class="boton"><a href="../prueba_tabla.php?materia=286&carrera=27"> Taller de Oralidad </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=287&carrera=27"> Biología Humana </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=288&carrera=27"> Introducción a la investigación en salud </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=289&carrera=27"> Fundamentos de la Psicología general y de la intervención </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=290&carrera=27"> Introducción al Campo de la Salud </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=291&carrera=27"> Practicas Profesionalizantes I </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=309&carrera=27"> Seminario I: Tecnología de la Información y la Comunicación </a></button>
           
        </div>
         <div class="hilera">
            <h2>Comisión B</h2>
            <button class="boton"><a href="../prueba_tabla.php?materia=304&carrera=40">Modalidades de Intervención en el Acompañante Terapéutico</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=305&carrera=40">Dinámica Grupal</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=306&carrera=40">Teoría Psicosocial y Comunitaria</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=307&carrera=40">Psicología Evolutiva</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=308&carrera=40">>Psicopatología</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=310&carrera=40">Práctica Profesionalizantes II</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=311&carrera=40">Seminario II: Sistemas Familiares</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=312&carrera=40">Seminario III: Trastornos crónicos y Degenerativos</a></button>
            
        </div>
        <div class="hilera">
            <h2>Comisión C</h2>
            <button class="boton"><a href="../prueba_tabla.php?materia=331&carrera=43">Ética y Deontología Profesional</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=332&carrera=43">Corrientes Psicológicas Contemporáneas</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=333&carrera=43">Principios Médicos y de Psicofarmacología</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=334&carrera=43">Acompañamiento Terapéutico en la Niñez y la Adolescencia</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=335&carrera=43">Acompañamiento Terapéutico del Adulto y Adulto Mayor</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=336&carrera=43">Práctica Profesionalizantes III</a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=337&carrera=43">Seminario IV: Integración Escolar</a></button>
          
            
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
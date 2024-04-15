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
    <title>Enfermería C-A</title>
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
    <a href="../../../../profesores_notas/notas_generales.php" class="home-button">Inicio</a>
      
     
      </div>
      
    
    <ul class="nav-options">
  
    
  
  
</ul>
 <div class="nav-right">
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
  
  <div class="contenedor">
        <h1>Eliga una Materia para asignar las notas</h1>
        <div class="hilera">
            <h2>1er año</h2>
            <button class="boton"><a href="../prueba_tabla.php?materia=139&carrera=18"> EDI I </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=140&carrera=18"> Comunicación en Salud </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=141&carrera=18"> Lengua Extranjera: portugués </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=142&carrera=18"> Anatomía y Fisiología </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=143&carrera=18"> Salud Pública </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=144&carrera=18"> Fisicoquímica </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=145&carrera=18"> Ciencias Psicosociales </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=146&carrera=18"> Nutrición </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=147&carrera=18"> Fundamentos de la Enfermería </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=148&carrera=18"> Práctica Profesionalizante I </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=149&carrera=18"> Tecnología de la Información y la Comunicación </a></button>
           
        </div>
        <div class="hilera">
            <h2>2do Año</h2>
            <button class="boton"><a href="../prueba_tabla.php?materia=172&carrera=33"> Lengua Extranjera: inglés </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=173&carrera=33"> EDI II </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=174&carrera=33"> Microbiología y Parasitología </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=175&carrera=33"> Cuidados de Enfermería a la Familia, al Niño y Adolescente </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=176&carrera=33"> Cuidados de Enfermería Comunitaria </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=177&carrera=33"> Farmacología </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=178&carrera=33"> Práctica Profesionalizante II </a></button>
            
        </div>
        <div class="hilera">
            <h2>3er año</h2>
            <button class="boton"><a href="../prueba_tabla.php?materia=193&carrera=36"> Ética y Deontología </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=194&carrera=36"> EDI III </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=195&carrera=36"> Principios de la Administración en Enfermería </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=196&carrera=36"> Metodología de la Investigación </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=197&carrera=36"> Lengua Extranjera: Inglés Técnico </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=198&carrera=36"> Cuidados en Enfermería a los Adultos y Ancianos </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=199&carrera=36"> Cuidados de Enfermería en Salud Mental </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=200&carrera=36"> Práctica Profesionalizante III </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=201&carrera=36"> Residencia </a></button>
            
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
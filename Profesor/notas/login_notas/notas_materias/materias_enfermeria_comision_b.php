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
    <title>Enfermería C-B</title>
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
    <a href="../index_notas.php" class="home-button">Inicio</a>
      
     
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
            <button class="boton"><a href="../prueba_tabla.php?materia=408&carrera=19"> EDI I </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=409&carrera=19"> Comunicación en Salud </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=410&carrera=19"> Lengua Extranjera: portugués </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=411&carrera=19"> Anatomía y Fisiología </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=412&carrera=19"> Salud Pública </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=413&carrera=19"> Fisicoquímica </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=414&carrera=19"> Ciencias Psicosociales </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=415&carrera=19"> Nutrición </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=416&carrera=19"> Fundamentos de la Enfermería </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=417&carrera=19"> Práctica Profesionalizante I </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=418&carrera=19"> Tecnología de la Información y la Comunicación </a></button>
           
        </div>
        <div class="hilera">
            <h2>2do Año</h2>
            <button class="boton"><a href="../prueba_tabla.php?materia=430&carrera=34"> Lengua Extranjera: inglés </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=431&carrera=34"> EDI II </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=432&carrera=34"> Microbiología y Parasitología </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=433&carrera=34"> Cuidados de Enfermería a la Familia, al Niño y Adolescente </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=434&carrera=34"> Cuidados de Enfermería Comunitaria </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=435&carrera=34"> Farmacología </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=436&carrera=34"> Práctica Profesionalizante II </a></button>
            
        </div>
        <div class="hilera">
            <h2>3er año</h2>
            <button class="boton"><a href="../prueba_tabla.php?materia=444&carrera=37"> Ética y Deontología </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=445&carrera=37"> EDI III </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=446&carrera=37"> Principios de la Administración en Enfermería </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=447&carrera=37"> Metodología de la Investigación </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=448&carrera=37"> Lengua Extranjera: Inglés Técnico </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=449&carrera=37"> Cuidados en Enfermería a los Adultos y Ancianos </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=450&carrera=37"> Cuidados de Enfermería en Salud Mental </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=451&carrera=37"> Práctica Profesionalizante III </a></button>
            <button class="boton"><a href="../prueba_tabla.php?materia=452&carrera=37"> Residencia </a></button>
            
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
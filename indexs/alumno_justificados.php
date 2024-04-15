<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ./login/login.php');}
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
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


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
            <button class="btn-new-member" id="btn-new-member">Justificar Falta</button>
            <button class="btn-situacion-academica">
              <a href="../Profesor/notas/login_notas/index_notas.php" class="btn-link">Situación Académica</a>
            </button>
            <button class="btn-preceptores">
              <a href="../preceptores.php">Preceptores</a>
            </button>
          </div>

    <ul class="nav-options">
      <li class="dropdown">
        <a href="#" class="dropbtn"> Elegir carrera <i class="fas fa-chevron-down"></i></a>
          <div class="dropdown-content">
              <div class="submenu">
                <a href="#" class="submenu-trigger">Enfermeria <i class="fas fa-chevron-right"></i></a>
                  <div class="sub-dropdown-content">
                    <a href="../Profesor/asistencia/asistencia_enfermeria.php">Primer Año</a>
                    <a href="../Profesor/asistencia/asistencia_enfermeria2ano.php">Segundo Año</a>
                    <a href="../Profesor/asistencia/asistencia_enfermeria3ano.php">Tercer Año</a>
                  </div>
              </div>
              <div class="submenu">
                <a href="#" class="submenu-trigger">Acompañamiento Terapeutico <i class="fas fa-chevron-right"></i></a>
                  <div class="sub-dropdown-content">
                    <a href="../Profesor/asistencia/asistencia_acompanante_terapeutico1ano.php">Primer Año</a>
                    <a href="../Profesor/asistencia/asistencia_acompanante_terapeutico2ano.php">Segundo Año</a>
                    <a href="../Profesor/asistencia/asistencia_acompanante_terapeutico1ano.php">Tercer Año</a>
                  </div>
              </div>
              <div class="submenu">
                <a href="#" class="submenu-trigger">Comercialización y Marketing <i class="fas fa-chevron-right"></i></a>
                  <div class="sub-dropdown-content">
                    <a href="../Profesor/asistencia/asistencia_comercializacion_marketing1ano.php">Primer Año</a>
                    <a href="../Profesor/asistencia/asistencia_comercializacion_marketing2ano.php">Segundo Año</a>
                    <a href="../Profesor/asistencia/asistencia_comercializacion_marketing3ano.php">Tercer Año</a>
                  </div>
              </div>
              <div class="submenu">
                <a href="#" class="submenu-trigger">Automatización y Robótica  <i class="fas fa-chevron-right"></i></a>
                  <div class="sub-dropdown-content">
                    <a href="../Profesor/asistencia/asistencia_automatizacion_robotica1ano.php">Primer Año</a>
                    <a href="../Profesor/asistencia/asistencia_automatizacion_robotica2ano.php  ">Segundo Año</a>
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
  <button id="btnMostrarEstudiantes">Justificar Flata</button>
   <!-- Modal para la tabla de estudiantes -->
   <div id="estudiantesModal" class="estudiantes-modal">
    <div class="modal-content-estudiantes">
    <span class="modal-close-estudiantes close-modal-button" id="closeEstudiantesModal">&times; Cerrar</span>
        <div id="tablaContainerEstudiantes">
            <table id="tabla">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Legajo</th>
                <th>Preceptor</th>
                <th>Carrera</th>
                <th>Motivo</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
              $sql1 = "SELECT a2.nombre_alumno,a2.apellido_alumno,a2.legajo,p.nombre_profe,c.nombre_carrera,a.fecha,a.motivo
              FROM alumnos_rat a
              INNER JOIN alumno a2 on a2.legajo = a.alumno_legajo
              INNER JOIN profesor p on p.idProrfesor = a.profesor_idProrfesor
              INNER JOIN carreras c on c.idCarrera = a.carreras_idCarrera";
            $query1 = mysqli_query($conexion, $sql1);
            while ($datos = mysqli_fetch_assoc($query1)) {
                ?>
                <tr>
                    <td><?php echo $datos['nombre_alumno']; ?></td>
                    <td><?php echo $datos['apellido_alumno']; ?></td>
                    <td><?php echo $datos['legajo']; ?></td>
                    <td><?php echo $datos['nombre_profe']; ?></td>
                    <td><?php echo $datos['nombre_carrera']; ?></td>
                    <td><?php echo $datos['motivo']; ?></td>
                    <td><?php echo $datos['fecha']; ?></td>



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
<?php
  $sql_carreras="SELECT c.nombre_carrera,p.carreras_idCarrera 
  FROM preceptores p 
  INNER JOIN carreras c on p.carreras_idCarrera = c.idCarrera 
  WHERE p.profesor_idProrfesor = '{$_SESSION["id"]}';";
  $query_carrera=mysqli_query($conexion,$sql_carreras);
  ?>

    <h2 class="form-container__h2">Justificar Falta</h2>
    <form action="./guardar_falta_justificada.php" id="miFormulario" method="post">
      
            
    <input type="text" name="filtroAlumno" id="filtroAlumno" placeholder="Filtrar por nombre, apellido o legajo de alumno">
    <select name="selectAlumno" id="selectAlumno">
        <option value="">Seleccionar alumno</option>
    </select>
    <input type="hidden" id="carrera" name="carrera" value="">
    <select id="selectMateria" name="materia">
      <option value="">Seleccione Materia</option>
    </select>
     <input type="text" name="motivo" placeholder="Motivo de Falta" >
              <input type="date" name="fecha" id="">
      <input type="submit" class="form-container__input" name="enviar" value="Enviar" onclick="mostrarAlertaExitosa(); closeSuccessMessage();">
    </form>
    
  </div>
</div>


<div class="nav-welcome-container">

<div id="welcome-box" class="welcome-box">
  <h1 class="welcome-box__h1">Bienvenido/a</h1>
  <p class="welcome-box__p">¡Selecciona una carrera para tomar asistencia!</p>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    

//---------------------------------- Filtro Alumnos ---------------------------------//

$(document).ready(function() {
    // Función para actualizar el selector de alumnos
    function actualizarSelectAlumnos(alumnos) {
        var selectAlumno = $('#selectAlumno');
        selectAlumno.empty(); // Vaciar el select para llenarlo de nuevo

        // Agregar una opción por cada alumno recibido
        alumnos.forEach(function(alumno) {
            var option = $('<option>', {
                value: alumno.legajo, // Utilizamos el legajo del alumno como valor
                text: alumno.nombre_alumno + ' ' + alumno.apellido_alumno + ' (' + alumno.legajo + ')'
            });
            selectAlumno.append(option);
        });
    }

    // Llamada inicial para llenar el selector de alumnos
    $.ajax({
        url: 'obtener_opciones.php',
        method: 'POST',
        data: {},
        dataType: 'json', // Especificar que esperamos datos JSON en la respuesta
        success: function(response) {
            actualizarSelectAlumnos(response.alumnos);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    // Función para filtrar los selectores al escribir en los inputs
    $('#filtroAlumno').on('input', function() {
        var alumno = $('#filtroAlumno').val();

        // Llamar a la función para actualizar los selectores
        actualizarSelects(alumno);
    });

    function actualizarSelects(alumno) {
        $.ajax({
            url: 'obtener_opciones.php',
            method: 'POST',
            data: { alumno: alumno },
            dataType: 'json', // Especificar que esperamos datos JSON en la respuesta
            success: function(response) {
                actualizarSelectAlumnos(response.alumnos);

                // Actualizar el valor del input hidden con el id de la carrera del primer alumno
                var carreraHidden = $('#carrera');
                if (response.alumnos.length > 0) {
                    carreraHidden.val(response.alumnos[0].carreras_idCarrera);
                } else {
                    carreraHidden.val(''); // Si no hay alumnos, vaciar el valor del input hidden
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Interceptamos el envío del formulario para cambiar los valores de los selectores por los IDs
    $('#miFormulario').submit(function() {
        var alumnoSeleccionado = $('#selectAlumno').val();

        // Actualizamos los valores de los selectores por los IDs
        $('#selectAlumno').val(alumnoSeleccionado);
        // El valor de la materia ya es el ID, no es necesario cambiarlo
    });

    // Evento change para el select de alumno
    $('#selectAlumno').change(function() {
        // Obtener el valor seleccionado en el select de alumno
        var legajoAlumno = $(this).val();

        // Enviar una solicitud AJAX para obtener la carrera del alumno
        $.ajax({
            url: 'obtener_carrera.php', // Ruta al script PHP que obtiene la carrera
            method: 'POST',
            data: { legajo: legajoAlumno }, // Datos a enviar al servidor
            dataType: 'json', // Especificar que esperamos datos JSON en la respuesta
            success: function(response) {
                // Rellenar el campo de carrera con el valor obtenido
                $('#carrera').val(response.carrera);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});


// Evento change para el input hidden de carrera
$('#carrera').change(function() {
    // Obtener el valor del input de carrera
    var idCarrera = $(this).val();
    
    // Verificar si el ID de la carrera no está vacío
    if (idCarrera) {
        // Enviar una solicitud AJAX para obtener las materias relacionadas con la carrera seleccionada
        $.ajax({
            url: 'obtener_materias.php', // Ruta al script PHP que obtiene las materias
            method: 'POST',
            data: { carrera: idCarrera }, // Datos a enviar al servidor (el ID de la carrera)
            dataType: 'json', // Especificar que esperamos datos JSON en la respuesta
            success: function(response) {
                // Limpiar el select de materias
                $('#selectMateria').empty();
                // Agregar una opción por cada materia recibida
                response.materias.forEach(function(materia) {
                    var option = $('<option>', {
                        value: materia.idMaterias,
                        text: materia.Nombre
                    });
                    $('#selectMateria').append(option);
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    } else {
        // Si el ID de la carrera está vacío, limpiar el select de materias
        $('#selectMateria').empty();
    }
});

// Evento change para el select de alumno
$('#selectAlumno').change(function() {
    // Obtener el valor seleccionado en el select de alumno
    var legajoAlumno = $(this).val();
    
    // Enviar una solicitud AJAX para obtener la carrera del alumno
    $.ajax({
        url: 'obtener_carrera.php', // Ruta al script PHP que obtiene la carrera
        method: 'POST',
        data: { legajo: legajoAlumno }, // Datos a enviar al servidor
        dataType: 'json', // Especificar que esperamos datos JSON en la respuesta
        success: function(response) {
            // Rellenar el campo de carrera con el valor obtenido
            $('#carrera').val(response.carrera).change(); // Disparar el evento change del input hidden de carrera
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});




</script>
</body>
</html>
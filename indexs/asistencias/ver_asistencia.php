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
    <title>AT 1ro</title>
    <link rel="stylesheet" type="text/css" href="../../estilos.css">
    <link rel="stylesheet" type="text/css" href="../../normalize.css">
    <link rel="icon" href="../../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="background">

  <button class="toggle-menu-button" onclick="toggleMenu()">☰</button>
  <nav class="navbar">
      
    <div class="nav-left">  
    <a href="../controlador_preceptor.php" class="home-button">Menu Principal</a>

      
      </div>
      
    
    



    <div class="nav-right">
        <a href="../../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
  

  <?php
   $curso=$_GET['id_curso'];
   $carrera=$_GET['id_carrera'];
   $comision=$_GET['id_comision']; 
   $sql_4="SELECT c.nombre_curso,c2.nombre_carrera,cm.N_comicion FROM inscripcion_asignatura ia
INNER JOIN cursos c on ia.cursos_idcursos = c.idcursos
INNER JOIN materias m on ia.materias_idMaterias = m.idMaterias
INNER JOIN carreras c2 on m.carreras_idCarrera = c2.idCarrera
INNER JOIN comisiones cm on ia.comisiones_idComisiones = cm.idComisiones
WHERE c.idcursos = '$curso' AND C2.idCarrera = '$carrera' AND CM.idComisiones = '$comision'";
$query4=mysqli_query($conexion,$sql_4);
$datos=mysqli_fetch_array($query4);
   ?>
   
  <h1>Asistencia de <?php echo $datos['nombre_carrera'] . $datos['nombre_curso'] ; ?> Comision : <?php echo $datos['N_comicion']; ?> </h1>
  
        <input type="hidden" id="carrera" value="<?php echo $carrera ?>">
        <input type="hidden" id="comision" value="<?php echo $comision ?>">
        <input type="hidden" id="curso" value="<?php echo $curso ?>"> 
        <div class="date-picker">
            <label for="fecha">Selecciona una fecha:</label>
            <input type="date" id="fecha" name="fecha" onchange="showAsistencia()">
            
        </div>
        <div class="table-responsive">
            <table class="table-comision-a">
                <thead>
                    <tr>
                        <th rowspan="2">N°</th>
                        <th rowspan="2">Apellido</th>
                        <th rowspan="2">Nombre</th>
                        <th rowspan="2">Asistencia</th>
                        <th colspan="4">Fecha</th>
                    </tr>
                </thead>
                <tbody id="asistenciaBody">
                    <!-- Aquí se mostrará la asistencia cargada mediante Ajax -->
                </tbody>
                <?php
                
                
                 ?>
            </table>
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
    toggleMenu();
  }
  setTimeout(function() {
    modal.classList.add("show");
  }, 10);

  var welcomeBox = document.querySelector(".welcome-box");
  welcomeBox.style.display = "none";
  setTimeout(function() {
    modal.classList.add("show");
  }, 10);
}

// Función para cerrar la ventana emergente
function closeModal() {
  var modal = document.getElementById("modal");
  modal.classList.remove("show");
  setTimeout(function() {
    modal.style.display = "none";
  }, 300);
  var welcomeBox = document.querySelector(".welcome-box");
  welcomeBox.style.display = "block";
}

document.getElementById("btn-new-member").onclick = function() {
  openModal();
};

function mostrarAlertaExitosa() {
  var successMessage = document.getElementById("success-message");
  successMessage.style.display = "block";
}

function closeSuccessMessage() {
  var successMessage = document.getElementById("success-message");
  successMessage.style.display = "none";
}



// Escucha el evento 'keydown' en el documento
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    // Cierra el modal de Nuevo Estudiante si está abierto
    var estudianteModal = document.getElementById('modal');
    if (estudianteModal && estudianteModal.style.display === 'block') {
      closeModal();
    }
  }
});



// Función para abrir el modal de asistencia
function openAttendanceModal() {
  var attendanceModal = document.getElementById("attendance-modal-asistencia");
  attendanceModal.style.display = "block";
}

// Función para cerrar el modal de tomar asistencia
function closeAttendanceModaltomarasistencia() {
  var attendanceModal = document.getElementById("attendance-modal-asistencia");
  attendanceModal.style.display = "none";
}
// Función para abrir el modal de ver asistencia 
function openAttendanceModalasistencia() {
  var attendanceModalasistencia = document.getElementById("attendance-modal-asistencia");
  openAttendanceModalasistencia.style.display = "block";
}

// Función para cerrar el modal de ver asistencia
function closeAttendanceModal() {
  var attendanceModal = document.getElementById("attendance-modal-asistencia");
  attendanceModal.style.display = "none";
}

// Funciones para abrir y cerrar el modal de Comisión A
function openModalComisionA() {
  // Cierra el modal de asistencia
  closeAttendanceModal();

  var modalComisionA = document.getElementById("asistenciamodalComisionA");
  modalComisionA.style.display = 'block';
}

function closeModalComisionA() {
  var modalComisionA = document.getElementById('asistenciamodalComisionA');
  modalComisionA.style.display = 'none';
}
// comision B

function openModalComisionB() {
  // Cierra el modal de asistencia
  closeAttendanceModal();

  var modalComisionB = document.getElementById("asistenciamodalComisionB");
  modalComisionB.style.display = 'block';
}

function closeModalComisionB() {
  var modalComisionB = document.getElementById('asistenciamodalComisionB');
  modalComisionB.style.display = 'none';
}
// comision c

function openModalComisionC() {
  // Cierra el modal de asistencia
  closeAttendanceModal();

  var modalComisionC = document.getElementById("asistenciamodalComisionC");
  modalComisionC.style.display = 'block';
}

function closeModalComisionC() {
  var modalComisionC = document.getElementById('asistenciamodalComisionC');
  modalComisionC.style.display = 'none';
}


//__________________________ver asistencia ____________________________

// Función para abrir el modal de asistencia
function openAttendanceModalverasistencia() {
  var attendanceModal = document.getElementById("attendance-modal");
  attendanceModal.style.display = "block";
}

// Función para cerrar el modal de asistencia
function closeAttendanceModalverasistencia() {
  var attendanceModal = document.getElementById("attendance-modal");
  attendanceModal.style.display = "none";
}
// Función para abrir el modal de ver asistencia 
function openAttendanceModalasistencia() {
  var attendanceModalasistencia = document.getElementById("attendance-modal");
  openAttendanceModalasistencia.style.display = "block";
}

// Función para cerrar el modal de ver asistencia
function closeAttendanceModal() {
  var attendanceModal = document.getElementById("attendance-modal");
  attendanceModal.style.display = "none";
}

// Funciones para abrir y cerrar el modal de Comisión A
function openModalComisionAverasistencia() {
  // Cierra el modal de asistencia
  closeAttendanceModal();

  var modalComisionA = document.getElementById("modalComisionAverasistencia");
  modalComisionA.style.display = 'block';
}

function closeModalComisionAverasistencia() {
  var modalComisionA = document.getElementById('modalComisionAverasistencia');
  modalComisionA.style.display = 'none';
}


// comision B

function openModalComisionBverasistencia() {
  // Cierra el modal de asistencia
  closeAttendanceModal();

  var modalComisionB = document.getElementById("modalComisionBverasistencia");
  modalComisionB.style.display = 'block';
}

function closeModalComisionBverasistencia() {
  var modalComisionB = document.getElementById('modalComisionBverasistencia');
  modalComisionB.style.display = 'none';
}
// comision c

function openModalComisionCverasistencia() {
  // Cierra el modal de asistencia
  closeAttendanceModal();

  var modalComisionC = document.getElementById("modalComisionCverasistencia");
  modalComisionC.style.display = 'block';
}

function closeModalComisionCverasistencia() {
  var modalComisionC = document.getElementById('modalComisionCverasistencia');
  modalComisionC.style.display = 'none';
}









function showModalMessage() {
    alert('¡Los datos se han enviado satisfactoriamente!');
}
function showDatePicker() {
    const fechaInput = document.getElementById("fecha");
    const fechaSeleccionada = fechaInput.value;
    const fechaMostrada = document.getElementById("fecha-seleccionada");

    fechaMostrada.textContent = "Fecha seleccionada: " + fechaSeleccionada;
}
const tableRows = document.querySelectorAll('.table-comision-a tbody tr');



// ajax para recargar la fecha en el mismo modal (Comisión A)
function showAsistencia() {
        var carrera = $("#carrera").val();
        var comision = $("#comision").val();
        var curso = $("#curso").val();
        var selectedDate = $("#fecha").val();

        $.ajax({
            type: "GET",
            url: "obtener_asistencia_ajax.php",
            data: { carrera: carrera,
                  fecha: selectedDate,
                comision: comision,
              curso: curso,
             },
            success: function (response) {
                $("#asistenciaBody").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud Ajax: " + xhr.responseText);
            }
        });
    }

    
// Esperar a que el contenido del DOM se cargue completamente.
document.addEventListener('DOMContentLoaded', function() {
    // Crear un nuevo objeto de fecha para obtener la fecha actual.
    var today = new Date();
    // Obtener el año, mes y día de la fecha actual.
    var year = today.getFullYear();
    var month = ('0' + (today.getMonth() + 1)).slice(-2); // Añade un cero si es necesario (formato MM).
    var day = ('0' + today.getDate()).slice(-2); // Añade un cero si es necesario (formato DD).
    // Formatear la fecha al formato aceptado por el input de tipo fecha (YYYY-MM-DD).
    var formattedDate = year + '-' + month + '-' + day;
    // Establecer el valor del input de fecha al día actual.
    document.getElementById('fecha').value = formattedDate;
  });
 
 





document.addEventListener('DOMContentLoaded', () => {
    // Selecciona todos los checkboxes
    const checkboxes = document.querySelectorAll('.table-comision-a tbody .checkbox-cell input[type="checkbox"]');

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            // Encuentra todos los checkboxes en la misma fila
            const rowCheckboxes = Array.from(this.closest('tr').querySelectorAll('.checkbox-cell input[type="checkbox"]'));
            // Cuenta cuántos checkboxes en la misma fila están marcados
            const checkedCount = rowCheckboxes.filter(cb => cb.checked).length;

            // Si hay más de 2 checkboxes marcados, desmarca el actual
            if (checkedCount > 2) {
                this.checked = false;
                alert('Solo puedes seleccionar hasta 2 opciones por fila.');
            }
        });
    });
});
</script>
</body>
</html>

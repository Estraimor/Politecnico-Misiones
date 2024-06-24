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
  


<br>
<br>




  
 
        
<form action="../../Profesor/asistencia/guardar_asistencia_enfermeria.php" method="post" onsubmit="showModalMessage()">
        <div class="table-responsive">
      
                <?php

                $curso=$_GET['id_curso'];
                $carrera=$_GET['id_carrera'];
                $comision=$_GET['id_comision'];
      $sql_materias="SELECT * FROM cursos_has_materias cm
INNER JOIN materias m on cm.materias_idMaterias = m.idMaterias
INNER JOIN carreras c on c.idCarrera = m.carreras_idCarrera
WHERE cm.cursos_idcursos = '$curso' and m.carreras_idCarrera = '$carrera'
      ";
      $query_materias=mysqli_query($conexion,$sql_materias); 
       ?>
                <table class="table-comision-a">
                        <thead>
                        <?php $materias = array();
while ($materia = mysqli_fetch_assoc($query_materias)) {
    $materias[] = $materia;
}
?>
<tr>
<th rowspan="2">N°</th>
<th rowspan="2">Apellido</th>
    <th rowspan="2">Nombre</th>
    <th colspan="2">
        <select name="materia1" id="" class="form-container__input">
            <option hidden>Primera Materia</option>
            <?php foreach ($materias as $materia) { ?>
                <option value="<?php echo $materia['idMaterias']; ?>"><?php echo $materia['Nombre']; ?></option>
            <?php } ?>
        </select>
    </th>
    <th colspan="2">
        <select name="materia2" id="" class="form-container__input">
            <option hidden>Segunda Materia</option>
            <?php foreach ($materias as $materia) { ?>
                <option value="<?php echo $materia['idMaterias']; ?>"><?php echo $materia['Nombre']; ?></option>
            <?php } ?>
        </select>
    </th>
</tr>
                        
            <tr>
                <th>Presente</th>
                <th>Ausente</th>
                
                <th>Presente</th>
                <th>Ausente</th>
              
            </tr>
            
                        </thead>
                        <tbody>
    <?php
    $contador = 1;
    $sql = "SELECT a.nombre_alumno,a.apellido_alumno,a.legajo 
    FROM inscripcion_asignatura ia
INNER JOIN alumno a on ia.alumno_legajo = a.legajo
INNER JOIN materias m on ia.materias_idMaterias = m.idMaterias
INNER JOIN carreras c on m.carreras_idCarrera = c.idCarrera
WHERE ia.cursos_idcursos = '$curso' and ia.comisiones_idComisiones = '$comision' and m.carreras_idCarrera = '$carrera' 
GROUP BY a.legajo";
    $query = mysqli_query($conexion, $sql);
    while ($datos = mysqli_fetch_assoc($query)) {
        ?>
        
        <tr>
        <td><?php echo $contador++; ?></td>
        <td><?php echo $datos['apellido_alumno']; ?></td>
        <td><?php echo $datos['nombre_alumno']; ?></td>
    
    
    <!-- Primera hora -->
    <td class="checkbox-cell">
        <input type="checkbox" name="presentePrimera[]" value="<?php echo $datos['legajo']; ?>">
    </td>

    <td class="checkbox-cell">
    <input type="checkbox" name="ausentePrimera[]" value="<?php echo $datos['legajo']; ?>" >
    </td>

   

    <!-- Segunda hora -->
    <td class="checkbox-cell">
        <input type="checkbox" name="presenteSegunda[]" value="<?php echo $datos['legajo']; ?>">
    </td>

    <td class="checkbox-cell">
    <input type="checkbox" name="ausenteSegunda[]" value="<?php echo $datos['legajo']; ?>" >
    </td>

    
</tr>




        <?php
    }
    ?>
</tbody>
        
        </table>
        <form id="justificadoForm" action="justificados.php" method="post">
    <input type="hidden" id="legajo" name="legajo" value="">
    <input type="hidden" id="materia" name="materia" value="">
    <input type="hidden" id="carrera" name="carrera" value="">
    <input type="hidden" id="fecha" name="fecha" value="">
    <input type="hidden" id="motivo" name="motivo" value="">
</form>

        <input type="hidden" name="idcarrera" value="<?php echo $carrera; ?>">
        <input type="hidden" name="comision" value="<?php echo $comision; ?>">
        <input type="hidden" name="curso" value="<?php echo $curso; ?>">
        <input type="submit" name="Enviar" value="Confirmar" class="btn-enviar">
            </form>

    
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
        var comisionId = $("#comisionId").val();
        var selectedDate = $("#fecha").val();

        $.ajax({
            type: "GET",
            url: "obtener_asistencia_ajax.php",
            data: { comisionId: comisionId, fecha: selectedDate },
            success: function (response) {
                $("#asistenciaBody").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud Ajax: " + xhr.responseText);
            }
        });
    }

    // ajax para recargar la fecha en el mismo modal (Comisión B)
    function showAsistenciaComisionB() {
    var comisionId = $("#comisionIdB").val();
    var selectedDate = $("#fechaB").val(); // Cambiado el ID a fechaB

    $.ajax({
        type: "GET",
        url: "obtener_asistencia_ajax.php",
        data: { comisionId: comisionId, fecha: selectedDate },
        success: function (response) {
            console.log("Respuesta del servidor:", response);
            $("#asistenciaBodyB").html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud Ajax:", status, error);
        }
    });
}

 // ajax para recargar la fecha en el mismo modal (Comisión C)
function showAsistenciaComisionC() {
    var comisionId = $("#comisionIdC").val();
    var selectedDate = $("#fechaC").val();

    $.ajax({
        type: "GET",
        url: "obtener_asistencia_ajax.php",
        data: { comisionId: comisionId, fecha: selectedDate },
        success: function (response) {
            console.log("Respuesta del servidor:", response);
            $("#asistenciaBodyC").html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud Ajax:", status, error);
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

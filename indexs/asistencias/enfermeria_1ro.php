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
    <title>Enfermeria 1ro</title>
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
    <a href="../preceptor_1.php" class="home-button">Inicio</a>
 
      
      </div>
      
    
    <ul class="nav-options">
  <li class="dropdown">
  <a href="#" class="dropbtn"> Elegir carrera <i class="fas fa-chevron-down"></i></a>
    <div class="dropdown-content">
      <div class="submenu">
        <a href="#" class="submenu-trigger">Enfermeria <i class="fas fa-chevron-right"></i></a>
        <div class="sub-dropdown-content">
          <a href="#">Primer Año</a>
        </div>
      </div>
      
      <div class="submenu">
        <a href="#" class="submenu-trigger">Comercialización y Marketing <i class="fas fa-chevron-right"></i></a>
        <div class="sub-dropdown-content">
          <a href="./Profesor/asistencia/asistencia_comercializacion_marketing2ano.php">Segundo Año</a> 
        </div>
      </div>
    </div>
    
  </li>
  
</ul>



    <div class="nav-right">
        <a href="../../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
  <div id="modal" class="modal">
  <div class="modal-content">
    <span class="close-estudiante" onclick="closeModal()">&times;</span>
    <?php include '../../estudiante/guardar_estudiante.php'; ?>
    <h2 class="form-container__h2">Registro de Estudiante</h2>
    <form action="" method="post">
      <input type="text" class="form-container__input" name="nombre_alu"  placeholder="Ingrese el nombre" autocomplete="off" required>
      <input type="text" class="form-container__input" name="apellido_alu" placeholder="Ingrese el apellido"autocomplete="off" required>
      <input type="number" class="form-container__input" name="dni_alu" placeholder="Ingrese el DNI" autocomplete="off" required>
      <input type="number" class="form-container__input" name="celular" placeholder="Ingrese el celular" autocomplete="off" required>
      <input type="number" class="form-container__input" name="legajo" placeholder="Ingrese el número de legajo" autocomplete="off" required>
      <input type="date" class="form-container__input" name="edad" placeholder="Ingrese fecha de nacimiento" autocomplete="off" required>
      <input type="text" class="form-container__input" name="informacion_previa" placeholder="Ingrese formación previa" autocomplete="off" required>
      <input type="text" class="form-container__input" name="Trabajo_Horario" placeholder="Trabajo / Horario" autocomplete="off" required>
      <input type="submit" class="form-container__input" name="enviar" value="Enviar" onclick="mostrarAlertaExitosa(); closeSuccessMessage();">
    </form>
    
  </div>
</div>

<button id="open-attendance-button" onclick="openAttendanceModalverasistencia()">Ver asistencia</button>


  <div id="attendance-modal" class="attendance-modal" style="display: none;">
  <div class="modal-content">
  <span class="close-attendance" onclick="closeAttendanceModalverasistencia()">&times;</span>
  
  <h2>Elige la Comisión Deseada:</h2>
  <button class="comission-button" onclick="openModalComisionBverasistencia()">Comisión B</button>
  </div>
    </div>

<!-- Modal de Comisión B -->
<div id="modalComisionBverasistencia" class="modal-comision-b">
    <div class="modal-content-comision-a">
        <span id="closeComisionB" class="close-comision-b" onclick="closeModalComisionBverasistencia()">&times;</span>
          <h1>Comisión B</h1>
        <input type="hidden" id="comisionIdB" value="19"> <!-- Cambiado el ID a comisionIdB -->
        <div class="date-picker">
          <label for="fechaB">Selecciona una fecha:</label>
            <input type="date" id="fechaB" name="fecha" onchange="showAsistenciaComisionB()">
            
        </div>
        <div class="table-responsive">
            <table class="table-comision-a">
                <thead>
                    <tr>
                        <th rowspan="2">Nombre</th>
                        <th rowspan="2">Apellido</th>
                        <th rowspan="2">Primera Hora</th>
                        <th rowspan="2">Segunda Hora</th>
                        <th colspan="4">Fecha</th>
                    </tr>
                </thead>
                <tbody id="asistenciaBodyB">
                    <!-- Aquí se mostrará la asistencia cargada mediante Ajax -->
                </tbody>
            </table>
        </div>
    </div>
</div>











<br>
<br>


<button id="open-attendance-button"  onclick="openAttendanceModal()">Tomar Asistencia de 1er Año</button>


  <div id="attendance-modal-asistencia" class="attendance-modal" style="display: none;">
  <div class="modal-content">
  <span class="close-attendance"  onclick="closeAttendanceModaltomarasistencia()">&times;</span>
  
  <h2>Elige la Comisión Deseada:</h2>
  <button class="comission-button" onclick="openModalComisionB()">Comisión B</button>
  </div>
    </div>
        

<!-- Modal de Comisión B -->
<div id="asistenciamodalComisionB" class="modal-comision-b">
    <div class="modal-content-comision-a">
    <span id="closeComisionB" class="close-comision-b" onclick="closeModalComisionB()">&times;</span>
    <h1>Comisión B</h1> <!-- Título "Comisión A" -->
    <form action="./guardar_asistencia_enfermeria.php" method="post" onsubmit="showModalMessage()">
        <div class="date-picker">
            <label for="fecha">Selecciona una fecha:</label>
            <input type="date" id="fecha" name="fecha">
           
        </div>
        <div class="table-responsive">
               <?php
      $sql_materias="select m.idMaterias ,m.Nombre ,c.nombre_carrera  from materias m
      inner join carreras c on m.carreras_idCarrera = c.idCarrera
      where c.idCarrera = '19'
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
    <th rowspan="2">Nombre</th>
    <th rowspan="2">Apellido</th>
    <th colspan="3">
        <select name="materia1" id="" class="form-container__input">
            <option hidden>Primera Materia</option>
            <?php foreach ($materias as $materia) { ?>
                <option value="<?php echo $materia['idMaterias']; ?>"><?php echo $materia['Nombre']; ?></option>
            <?php } ?>
        </select>
    </th>
    <th colspan="3">
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
                <th>Justificado</th>
                <th>Presente</th>
                <th>Ausente</th>
                <th>Justificado</th>
            </tr>
                        </thead>
                        <tbody>
    <?php
    $sql = "SELECT ia.alumno_legajo , a2.nombre_alumno, a2.apellido_alumno, a2.dni_alumno
    FROM asistencia a 
    RIGHT JOIN inscripcion_asignatura ia ON a.inscripcion_asignatura_idinscripcion_asignatura = ia.idinscripcion_asignatura 
    INNER JOIN alumno a2 ON ia.alumno_legajo = a2.legajo  
    WHERE ia.carreras_idCarrera = '19'";
    $query = mysqli_query($conexion, $sql);
    while ($datos = mysqli_fetch_assoc($query)) {
        ?>
        
       <tr>
    <td><?php echo $datos['nombre_alumno']; ?></td>
    <td><?php echo $datos['apellido_alumno']; ?></td>
    
    <!-- Primera hora -->
    <td class="checkbox-cell">
        <input type="checkbox" name="presentePrimera[]" value="<?php echo $datos['alumno_legajo']; ?>">
    </td>

    <td class="checkbox-cell">
        <input type="checkbox" name="ausentePrimera[]" value="<?php echo $datos['alumno_legajo']; ?>">
    </td>

    <td class="checkbox-cell">
        <input type="checkbox" name="justificadaPrimera[]" value="<?php echo $datos['alumno_legajo']; ?>">
    </td>

    <!-- Segunda hora -->
    <td class="checkbox-cell">
        <input type="checkbox" name="presenteSegunda[]" value="<?php echo $datos['alumno_legajo']; ?>">
    </td>

    <td class="checkbox-cell">
        <input type="checkbox" name="ausenteSegunda[]" value="<?php echo $datos['alumno_legajo']; ?>">
    </td>
      
    <td class="checkbox-cell">
        <input type="checkbox" name="justificadaSegunda[]" value="<?php echo $datos['alumno_legajo']; ?>">
    </td>
</tr>
        <?php
    }
    ?>
</tbody>
        
        </table>
        <input type="hidden" name="idcarrera" value="19">
        <input type="submit" name="Enviar" value="Enviar" class="btn-enviar">
            </form>
        </div>
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

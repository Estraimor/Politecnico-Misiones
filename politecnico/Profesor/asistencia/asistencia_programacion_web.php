<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../../login/login.php');}
?>
<?php
$server='localhost';
$user='root';
$pass='';
$bd='politecnico';
$conexion=mysqli_connect($server,$user,$pass,$bd, '3306');

if ($conexion) { echo ""; } else { echo "conexion not connected"; }
?>


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
    <a href=".././index.php" class="home-button">Inicio</a>
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
          <a href="./asistencia_enfermeria.php">Primer Año</a>
          <a href="./asistencia_enfermeria2año.php">Segundo Año</a>
          <a href="./asistencia_enfermeria3año.php">Tercer Año</a>
        </div>
      </div>
      <div class="submenu">
      <a href="#" class="submenu-trigger">Acompañamiento Terapeutico <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
          <a href="./asistencia_acompañante_terapeutico1año.php">Primer Año</a>
          <a href="./asistencia_acompañante_terapeutico2año.php">Segundo Año</a>
          <a href="./asistencia_acompañante_terapeutico3año.php">Tercer Año</a>
        </div>
      </div>
      <div class="submenu">
      <a href="#" class="submenu-trigger">Comercialización y Marketing <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
          <a href="./asistencia_comercializacion_marketing1año.php">Primer Año</a>
          <a href="./asistencia_comercializacion_marketing2año.php">Segundo Año</a>
          <a href="./asistencia_comercializacion_marketing3año.php">Tercer Año</a>
        </div>
      </div>
      <div class="submenu">
      <a href="#" class="submenu-trigger">Automatización y Robótica  <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
          <a href="./asistencia_automatizacion_robotica1año.php">Primer Año</a>
          <a href="./asistencia_automatizacion_robotica2año.php">Segundo Año</a>
          <a href="./asistencia_automatizacion_robotica3año.php">Tercer Año</a>
        </div>
      </div>
      <a href="./asistencia_programacion_web.php" class="submenu-trigger">FP-Programación Web</a>
      <div class="sub-dropdown-content">
        <!-- <a href="./asistencia_programacion_web.php">Primer Año</a> -->
        <!-- <a href="#">Segundo Año</a> -->
      </div>
      <a href="./asistencia_marketing_venta_digital.php" class="submenu-trigger">FP-Marketing y Venta Digital</a>
      <div class="sub-dropdown-content">
        <!-- <a href="./asistencia_marketing_venta_digital.php">Primer Año</a> -->
        <!-- <a href="#">Segundo Año</a> -->
      </div>
      <a href="./asistencia_instalador_redes.php" class="submenu-trigger">FP-Redes Informáticas</a>
      <div class="sub-dropdown-content">
        <!-- <a href="./asistencia_instalador_redes.php">Primer Año</a> -->
        <!-- <a href="#">Segundo Año</a> -->
      </div>
    </div>
  </li>
</ul>



    <div class="nav-right">
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
  <div id="modal" class="modal">
  <div class="modal-content">
    <span class="close-estudiante" onclick="closeModal()">&times;</span>
    <?php include '../estudiante/guardar_estudiante.php'; ?>
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
<div id="materia-modal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeMateriaModal()">&times;</span>
    
    <form action="" method="post">
      <?php include '../asignatura/guardar_materia.php'; ?>    
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
    <?php mysqli_data_seek($query, 0);  ?>
    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
      <option hidden>Profesores</option>
      <option value="<?php echo $row['idProrfesor']; ?>"> <?php echo ucwords($row['nombre_profe']) ?> <?php echo ucwords($row['apellido_profe']) ?>  </option>
    <?php } ?>
  </select>
      
      <input type="submit" name="enviar" value="Enviar-Datos">
    </form>
  </div>
</div>
<button id="open-attendance-button" onclick="openAttendanceModalverasistencia()">Ver asistencia</button>


  <div id="attendance-modal" class="attendance-modal" style="display: none;">
  <div class="modal-content">
  <span class="close-attendance" onclick="closeAttendanceModalverasistencia()">&times;</span>
  
  <h2>Elige la Comisión Deseada:</h2>
 
  <button class="comission-button" onclick="openModalComisionAverasistencia()">Comisión A</button>

  </div>
    </div>
<!-- Modal de Comisión A -->
<div id="modalComisionAverasistencia" class="modal-comision-a">
    <div class="modal-content-comision-a">
        <span id="closeComisionA" class="close-comision-a" onclick="closeModalComisionAverasistencia()">&times;</span>
        <h1>Comisión A</h1>
        <input type="hidden" id="comisionId" value="8"> <!-- Aquí se almacena el ID de la comisión -->
        <div class="date-picker">
            <label for="fecha">Selecciona una fecha:</label>
            <input type="date" id="fecha" name="fecha" onchange="showAsistencia()">
            <button onclick="showDatePicker()">Seleccionar</button>
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
                <tbody id="asistenciaBody">
                    <!-- Aquí se mostrará la asistencia cargada mediante Ajax -->
                </tbody>
                <?php
                
                
                 ?>
            </table>
        </div>
    </div>
</div>










<button id="open-attendance-button" onclick="openAttendanceModal()">Abrir Asistencia de 1er Año</button>


  <div id="attendance-modal-asistencia" class="attendance-modal" style="display: none;">
  <div class="modal-content">
  <span class="close-attendance"  onclick="closeAttendanceModaltomarasistencia()">&times;</span>
  
  <h2>Elige la Comisión Deseada:</h2>
 
  <button class="comission-button" onclick="openModalComisionA()">Comisión A</button>
  
  </div>
    </div>
        
<!-- Modal de Comisión A -->
<div id="asistenciamodalComisionA" class="modal-comision-a">
    <div class="modal-content-comision-a">
    <span id="closeComisionA" class="close-comision-a" onclick="closeModalComisionA()">&times;</span>
    <h1>Comisión A</h1> <!-- Título "Comisión A" -->
    <!-- form lo movi un poco mas arrinba encapsulando la fecha -->
    <form action="./guardar_asistencia_enfermeria" method="post" onsubmit="showModalMessage()">
        <div class="date-picker">
            <label for="fecha">Selecciona una fecha:</label>
            <input type="date" id="fecha" name="fecha">
            <button onclick="showDatePicker()">Seleccionar</button>
        </div>
        <div class="table-responsive">
      
                <table class="table-comision-a">
                        <thead>
                        <tr>
                <th rowspan="2">Nombre</th>
                <th rowspan="2">Apellido</th>
                <th colspan="3">Primera Hora</th>
                <th colspan="3">Segunda Hora</th>
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
    WHERE ia.carreras_idCarrera = '8'";
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
        <input type="hidden" name="idcarrera" value="8">
        <input type="submit" name="Enviar" value="Enviar" class="btn-enviar">
            </form>
        </div>
    </div>
</div>

    
<script>
    var tabla = document.querySelector("#tabla");
    var dataTable = new DataTable(tabla);
</script>
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

// Función para abrir el modal de materia
function openMateriaModal() {
  var materiaModal = document.getElementById("materia-modal");
  materiaModal.style.display = "block";
  if (window.innerWidth <= 768) {
    toggleMenu();
  }
  setTimeout(function() {
    materiaModal.classList.add("show");
  }, 10);

  var welcomeBox = document.getElementById("welcome-box");
  welcomeBox.style.opacity = "0";
  setTimeout(function() {
    welcomeBox.style.display = "none";
  }, 300);
}

// Función para cerrar el modal de materia
function closeMateriaModal() {
  var materiaModal = document.getElementById("materia-modal");
  materiaModal.classList.remove("show");
  setTimeout(function() {
    materiaModal.style.display = "none";
  }, 300);

  var welcomeBox = document.getElementById("welcome-box");
  welcomeBox.style.display = "block";
}

// Escucha el evento 'keydown' en el documento
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    // Cierra el modal de Nuevo Estudiante si está abierto
    var estudianteModal = document.getElementById('modal');
    if (estudianteModal && estudianteModal.style.display === 'block') {
      closeModal();
    }

    // Cierra el modal de Nueva Materia si está abierto
    var materiaModal = document.getElementById('materia-modal');
    if (materiaModal && materiaModal.style.display === 'block') {
      closeMateriaModal();
    }
  }
});

document.getElementById("tu-formulario").addEventListener("submit", function(event) {
  event.preventDefault();

  // Lógica de procesamiento del formulario.

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

tableRows.forEach(row => {
  const checkboxesInRow = row.querySelectorAll('.checkbox-cell input[type="checkbox"]');

  checkboxesInRow.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      if (this.checked) {
        // Desmarca los otros checkboxes en la misma fila
        checkboxesInRow.forEach(otherCheckbox => {
          if (otherCheckbox !== this) {
            otherCheckbox.checked = false;
          }
        });
      }
    });
  });
});

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
</script>
</body>
</html>

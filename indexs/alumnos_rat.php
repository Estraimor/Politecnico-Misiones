<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../login/login.php');}

// Set inactivity limit in seconds
$inactivity_limit = 1200;

// Check if the user has been inactive for too long
if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > $inactivity_limit)) {
    // User has been inactive, so destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: ../login/login.php");
    exit; // Terminar el script después de redireccionar
} else {
    // Update the session time to the current time
    $_SESSION['time'] = time();
}
?>
<?php include'../conexion/conexion.php'; ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AT 1ro</title>
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link rel="stylesheet" type="text/css" href="../normalize.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .form-container {
            text-align: center;
            margin-bottom: 20px;
        }

      

        .btn-enviar {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="background">

  <button class="toggle-menu-button" onclick="toggleMenu()">☰</button>
  <nav class="navbar">
      
    <div class="nav-left">  
    <a href="./controlador_preceptor.php" class="home-button">Menu Principal</a>

      
      </div>
      
    
    



    <div class="nav-right">
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
  

  <?php
// Obtener el curso, carrera y comisión desde la URL
$curso_id = $_GET['id_curso'];
$carrera_id = $_GET['id_carrera'];
$comision_id = $_GET['id_comision'];

// Obtener el listado de materias del curso y la carrera
$sql_materias = "SELECT m.idMaterias, m.Nombre 
                 FROM cursos_has_materias cm
                 INNER JOIN materias m ON cm.materias_idMaterias = m.idMaterias
                 WHERE cm.cursos_idcursos = ? AND m.carreras_idCarrera = ?";
$stmt_materias = $conexion->prepare($sql_materias);
$stmt_materias->bind_param("ii", $curso_id, $carrera_id);
$stmt_materias->execute();
$query_materias = $stmt_materias->get_result();

// Obtener los datos de los alumnos
$sql_alumnos = "SELECT a.legajo, a.nombre_alumno, a.apellido_alumno, c.nombre_carrera, c2.N_comicion
                FROM inscripcion_asignatura ia
                INNER JOIN alumno a ON ia.alumno_legajo = a.legajo
                INNER JOIN materias m ON ia.materias_idMaterias = m.idMaterias
                INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
                INNER JOIN comisiones c2 ON ia.comisiones_idComisiones = c2.idComisiones
                WHERE ia.cursos_idcursos = ? AND c.idCarrera = ? AND ia.comisiones_idComisiones = ?
                GROUP BY a.legajo";
$stmt_alumnos = $conexion->prepare($sql_alumnos);
$stmt_alumnos->bind_param("iii", $curso_id, $carrera_id, $comision_id);
$stmt_alumnos->execute();
$result_alumnos = $stmt_alumnos->get_result();
?>
   
   <form action="guardar_alumnos_rat.php" method="post">
        <div class="form-container">
            <select id="materiaSelect" name="materia" class="form-container__input" required>
                <?php while ($materia = mysqli_fetch_assoc($query_materias)) { ?>
                    <option value="<?php echo htmlspecialchars($materia['idMaterias']); ?>">
                        <?php echo htmlspecialchars($materia['Nombre']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        
        <input type="hidden" name="curso" value="<?php echo htmlspecialchars($curso_id); ?>">
        <input type="hidden" name="carrera" value="<?php echo htmlspecialchars($carrera_id); ?>">
        <input type="hidden" name="comision" value="<?php echo htmlspecialchars($comision_id); ?>">

        <div class="table-responsive">
            <table class="table-comision-a">
                <thead>
                    <tr>
                        <th>Legajo</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Carrera</th>
                        <th>Comisión</th>
                        <th>Cfolectivo</th>
                        <th>Particular</th>
                        <th>Sin Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($alumno = mysqli_fetch_assoc($result_alumnos)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($alumno['legajo']); ?></td>
                            <td><?php echo htmlspecialchars($alumno['nombre_alumno']); ?></td>
                            <td><?php echo htmlspecialchars($alumno['apellido_alumno']); ?></td>
                            <td><?php echo htmlspecialchars($alumno['nombre_carrera']); ?></td>
                            <td><?php echo htmlspecialchars($alumno['N_comicion']); ?></td>
                            <td class="checkbox-cell">
                                <input type="radio" name="motivo[<?php echo $alumno['legajo']; ?>]" value="Cfolectivo" required>
                            </td>
                            <td class="checkbox-cell">
                                <input type="radio" name="motivo[<?php echo $alumno['legajo']; ?>]" value="Particular" required>
                            </td>
                            <td class="checkbox-cell">
                                <input type="radio" name="motivo[<?php echo $alumno['legajo']; ?>]" value="Sin Motivo" required>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <input type="submit" value="Guardar" class="btn-enviar">
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

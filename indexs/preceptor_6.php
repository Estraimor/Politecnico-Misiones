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
    <title>SGPM-Carla Gimenez</title>
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link rel="stylesheet" type="text/css" href="../normalize.css">
    <link rel="stylesheet" type="text/css" href="./cssinforme.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<div id="success-message" class="success-message" style="display: none;"></div>
<div class="background">

<button class="toggle-menu-button" id="toggle-menu-button" onclick="toggleMenu()">
  <span id="toggle-menu-icon">☰</span>
</button>
    <nav class="navbar">
      
    <div class="nav-left">  
    <a href="#" class="home-button">Menu Principal</a>
      <button class="btn-new-member" id="btn-new-member">Nuevo Estudiante</button>
      <button class="btn-new-member" id="btnOpenModalRetirados">Estudiantes retirados</button>
      <button class="btn-new-member" class="btn-justificacion" onclick="abrirModalJustificacion()">Justificar Falta</button>
      
      </div>
      
    
    <ul class="nav-options">
  <li class="dropdown">
  <a href="#" class="dropbtn"> Elegir carrera <i class="fas fa-chevron-down"></i></a>
    <div class="dropdown-content">
    <div class="submenu">
      <a href="#" class="submenu-trigger">Acompañamiento Terapeutico <i class="fas fa-chevron-right"></i></a>
      <div class="sub-dropdown-content">
 
          <a href="./asistencias/at_2do_a_b.php">Segundo Año</a>
     
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
        <button id="btnMostrarInformesAsistencia" class="boton-informes-asistencia">Informes de Asistencias</button>
        <button id="btnImprimirListaEstudiantes" class="boton-informes-asistencia" >Guardar Lista de Estudiantes</button>
            <table id="tabla">
        <thead>
            <tr>
                <th>Legajo</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Celular</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql1 = "SELECT * FROM inscripcion_asignatura ia 
            INNER JOIN alumno a on ia.alumno_legajo = a.legajo 
            INNER JOIN preceptores p ON p.carreras_idCarrera = ia.carreras_idCarrera 
            WHERE p.profesor_idProrfesor = {$_SESSION["id"]} and a.estado = '1' ";
            $query1 = mysqli_query($conexion, $sql1);
            while ($datos = mysqli_fetch_assoc($query1)) {
                ?>
                <tr>
                    <td><?php echo $datos['legajo']; ?></td>
                    <td><?php echo $datos['apellido_alumno']; ?></td>
                    <td><?php echo $datos['nombre_alumno']; ?></td>
                    <td><?php echo $datos['dni_alumno']; ?></td>
                    <td><?php echo $datos['celular']; ?></td>
                    <td><a href="../Profesor/modificar_alumno.php?legajo=<?php echo $datos['legajo']; ?>" class="modificar-button"><i class="fas fa-pencil-alt"></i></a>
<a href="#" onclick="return confirmarBorrado('<?php echo $datos['legajo']; ?>')" class="borrar-button"><i class="fas fa-trash-alt"></i></a>
                   <a href="../Profesor/porcentajes_de_asistencia.php?legajo=<?php echo $datos['legajo']; ?>" class="accion-button"><i class="fas fa-exclamation"></i></a></td>



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
  <?php include'../Profesor/estudiante/guardar_estudiante.php'; ?>
    <h2 class="form-container__h2">Registro de Estudiante</h2>
    <form action="" method="post">
      <input type="text" class="form-container__input" name="nombre_alu" placeholder="Ingrese el nombre" autocomplete="off" required>
      <input type="text" class="form-container__input" name="apellido_alu" placeholder="Ingrese el apellido" autocomplete="off" required>
      <input type="number" class="form-container__input" name="dni_alu" placeholder="Ingrese el DNI" autocomplete="off" required>
      <input type="number" class="form-container__input" name="celular" placeholder="Ingrese el celular" autocomplete="off" >
      <input type="number" class="form-container__input" name="legajo" placeholder="Ingrese el número de legajo" autocomplete="off" required>
      <input type="date" class="form-container__input" name="edad" placeholder="Ingrese fecha de nacimiento" autocomplete="off" >
      <input type="text" class="form-container__input" name="observaciones" placeholder="Observaciones" autocomplete="off" required>
      <input type="text" class="form-container__input" name="Trabajo_Horario" placeholder="Trabajo / Horario" autocomplete="off" required>
            <!-- php para la recorrida de las carreras del select -->
      <?php
       $sql_mater="SELECT * 
       FROM preceptores p 
       INNER JOIN carreras c on p.carreras_idCarrera = c.idCarrera
       WHERE p.profesor_idProrfesor = '{$_SESSION["id"]}'  ";
       $peticion=mysqli_query($conexion,$sql_mater);
       ?>      
      <select name="inscripcion_carrera" class="form-container__input"> 
        <option hidden >Selecciona una carrera </option>
        <?php while($informacion=mysqli_fetch_assoc($peticion)){ ?>
          <option value="<?php echo $informacion['idCarrera'] ?>"><?php echo $informacion['nombre_carrera'] ?></option>
          <?php }?>
      </select>

      <input type="submit" class="form-container__input" name="enviar" value="Confirmar" onclick="mostrarAlertaExitosa(); closeSuccessMessage();">
    </form>
    
  </div>
</div>



<div id="modalInformesAsistencia" class="modal-informes-asistencia">
    <div class="modal-content-informes-asistencia">
    <span class="cerrar-modal-informes-asistencia">&times;</span>
        <h2>Generar Excel de Asistencias</h2>
        <br>
        <form action="generar_excel.php" method="post">
            <label for="fecha_inicio">Fecha de inicio:</label>
            <input type="date" id="fecha_inicio" class="input_fecha" name="fecha_inicio">
            <br><br>
            <label for="fecha_fin">Fecha de fin:</label>
            <input type="date" id="fecha_fin" class="input_fecha" name="fecha_fin">
            <br><br>
            <?php
       $sql_mater="select * from carreras c ";
       $peticion=mysqli_query($conexion,$sql_mater);
       ?>
            <select name="carrera" class="form-input-informes">
                <option hidden>Selecciona una carrera</option>
                <?php while($informacion=mysqli_fetch_assoc($peticion)){ ?>
          <option value="<?php echo $informacion['idCarrera'] ?>"><?php echo $informacion['nombre_carrera'] ?></option>
          <?php }?>
            </select>
            <br><br>
            <input type="submit" value="Generar Excel" class="boton-submit-informes">
        </form>
    </div>
</div>
<div id="modalRetirados" class="modal-retirados">
  <div class="modal-content-retirados">
  <span class="close" id="close-retirados">&times;</span>
  <?php
  $sql_carreras="SELECT c.nombre_carrera,p.carreras_idCarrera 
  FROM preceptores p 
  INNER JOIN carreras c on p.carreras_idCarrera = c.idCarrera 
  WHERE p.profesor_idProrfesor = '{$_SESSION["id"]}';";
  $query_carrera=mysqli_query($conexion,$sql_carreras);
  ?>
    <h2 class="form-container__h2">Estudiante retirado antes de Tiempo</h2>
    <form action="guardar_alumnos_rat.php" id="miFormularioRetirados" method="post">
      <input type="text" name="filtroAlumno" id="filtroAlumno" placeholder="Filtrar por nombre, apellido o legajo de alumno">
      <select name="selectAlumno" id="selectAlumno">
          <option value="">Seleccionar alumno</option>
      </select>
      <select id="selectMateria" name="materia">
      <option value="">Seleccione Materia</option>
    </select>
      <input type="hidden" id="carrera" name="carrera" value="">
      <input hidden name="profesor" value="<?php echo $_SESSION["id"]; ?>">
      <input type="text" name="motivo" placeholder="Motivo de Retirado">
      <input type="date" name="fecha" id="fechaRetirados">
      <input type="submit" class="form-container__input" name="enviar" value="Confirmar">
    </form>
  </div>
</div>



<button id="btnOpenModalRetiradosTiempo">Estudiantes Retirados antes de tiempo</button>
<!-- Modal para la tabla de estudiantes -->
<div id="modalRetiradosTiempo" class="modal-retirados-tiempo">
    <div class="modal-content-retirados-tiempo">
        <span class="close" id="closeRetiradosTiempo">&times;</span>
        <div id="modalBodyRetiradosTiempo">
            <table id="tablaRetiradosTiempo">
                <thead>
                    <tr>
                      <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Legajo</th>
                        <th>Preceptor</th>
                        <th>Carrera</th>
                        <th>Materia</th>
                        <th>Motivo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                <?php
              $sql1 = "SELECT a2.nombre_alumno,a2.apellido_alumno,a2.legajo,p.nombre_profe,c.nombre_carrera,m.Nombre,fecha,a.motivo
              FROM alumnos_rat a
              INNER JOIN alumno a2 on a2.legajo = a.alumno_legajo
              INNER JOIN carreras c on c.idCarrera = a.carreras_idCarrera
              INNER JOIN profesor p on a.profesor_idProrfesor = p.idProrfesor
              INNER JOIN materias m on  a.materias_idMaterias = m.idMaterias
              where p.idProrfesor = {$_SESSION["id"]}";
            $query1 = mysqli_query($conexion, $sql1);
            while ($datos = mysqli_fetch_assoc($query1)) {
                ?>
                <tr>
                    <td><?php echo $datos['apellido_alumno']; ?></td>
                    <td><?php echo $datos['nombre_alumno']; ?></td>
                    <td><?php echo $datos['legajo']; ?></td>
                    <td><?php echo $datos['nombre_profe']; ?></td>
                    <td><?php echo $datos['nombre_carrera']; ?></td>
                    <td><?php echo $datos['Nombre']; ?></td>
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


<!-- Nuevo Modal para Imprimir Lista de Estudiantes -->
<div id="modal-lista-estudiantes" class="modal-lista-estudiantes" style="display: none; position: fixed; z-index: 55555555555555; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content-lista-estudiantes" style="background-color: rgba(255, 255, 255, 0.9);z-index: 55555555; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);">
        <span class="close-modal-button" id="closeListaEstudiantesModal" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
        <h2>Informe de Estudiantes</h2>
        <form action="./generar_exel_alumnos.php" method="post">
            <?php
            $sql_mater = "select * from preceptores p 
            INNER JOIN carreras c on c.idCarrera = p.carreras_idCarrera
            WHERE p.profesor_idProrfesor = {$_SESSION["id"]} ";
            $peticion = mysqli_query($conexion, $sql_mater);
            ?>      
            <select name="carrera" class="form-container__input"> 
                <option hidden>Selecciona una carrera</option>
                <?php while ($informacion = mysqli_fetch_assoc($peticion)) { ?>
                    <option value="<?php echo $informacion['idCarrera'] ?>"><?php echo $informacion['nombre_carrera'] ?></option>
                <?php } ?>
            </select>
            <input type="submit" value="Generar Lista de Estudiantes" style="background-color: red; color: white; padding: 10px 20px; margin: 8px 0; border: none; cursor: pointer; width: 100%;">
        </form>
    </div>
</div>

<div class="modal-justificacion">
  <div class="modal-content-justificacion">
    <span class="close-justificacion" onclick="cerrarModalJustificacion()">×</span>
    
    <?php
  $sql_carreras="SELECT c.nombre_carrera,p.carreras_idCarrera 
  FROM preceptores p 
  INNER JOIN carreras c on p.carreras_idCarrera = c.idCarrera 
  WHERE p.profesor_idProrfesor = '{$_SESSION["id"]}';";
  $query_carrera=mysqli_query($conexion,$sql_carreras);
  ?>
    <h2 class="form-container__h2">Justificar Falta</h2>
    
   <form action="guardar_falta_justificada.php" id="miFormularioRetirados" method="post">
      <input type="text" name="filtroAlumno" id="filtroAlumno" placeholder="Filtrar por nombre, apellido o legajo de alumno">
      <select name="selectAlumno" id="selectAlumno">
          <option value="">Seleccionar alumno</option>
      </select>
      <select id="selectMateria" name="materia">
      <option value="">Seleccione Materia</option>
    </select>
      <input type="hidden" id="carrera" name="carrera" value="">
      <input hidden name="profesor" value="<?php echo $_SESSION["id"]; ?>">
      <input type="text" name="motivo" placeholder="Motivo de Retirado">
      <input type="date" name="fecha" id="fechaRetirados">
      <input type="submit" class="form-container__input" name="enviar" value="Confirmar">
    </form>
  </div>
</div>


<div class="nav-welcome-container">

<div id="welcome-box" class="welcome-box">
  <h1 class="welcome-box__h1">¡Bienvenido!</h1>
  <p class="welcome-box__p">Prec. y Programador Luciano Barros</p>
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
  
  function confirmarBorrado(legajo) {
    var respuesta = confirm("¿Estás seguro de que quieres borrar este alumno?");
    if (respuesta) {
        // Realizar el borrado lógico directamente sin redirección previa
        window.location.href = "./Profesor/Borrado_logico_alumno.php?legajo=" + legajo;
    }
    return false; // Evita que el navegador siga el enlace en caso de cancelar la confirmación
}







document.addEventListener('DOMContentLoaded', function () {
    var btnMostrarInformesAsistencia = document.getElementById('btnMostrarInformesAsistencia');
    var modalInformesAsistencia = document.getElementById('modalInformesAsistencia');
    var cerrarModalInformesAsistencia = document.getElementsByClassName('cerrar-modal-informes-asistencia')[0];
    // Referencias adicionales
    var welcomeBox = document.getElementById('welcome-box');
    var estudiantesModal = document.getElementById('estudiantesModal'); // Referencia al modal de estudiantes para poder cerrarlo

    btnMostrarInformesAsistencia.onclick = function() {
        modalInformesAsistencia.style.display = "block";
        // Oculta el welcome-box y el modal de estudiantes
        welcomeBox.style.display = "none";
        estudiantesModal.style.display = "none";
    }

    cerrarModalInformesAsistencia.onclick = function() {
        modalInformesAsistencia.style.display = "none";
        // Muestra el welcome-box cuando se cierra el modal de informes
        welcomeBox.style.display = "block";
    }

    window.onclick = function(event) {
        if (event.target == modalInformesAsistencia) {
            modalInformesAsistencia.style.display = "none";
            // Asegúrate de que el welcome-box también se muestre cuando se cierra el modal haciendo clic fuera de él
            welcomeBox.style.display = "block";
        }
    }
});


// Obtener el modal
var modal = document.getElementById("modalRetirados");

// Obtener el botón que abre el modal
var btn = document.getElementById("btnOpenModalRetirados");

// Obtener el elemento que cierra el modal
var span = document.getElementById("close-retirados");

// Cuando el usuario hace clic en el botón, abrir el modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// Cuando el usuario hace clic en (x), cierra el modal
span.onclick = function() {
  modal.style.display = "none";
}

// También cierra el modal si el usuario hace clic fuera de él
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


// Obtener el modal
var modalTiempo = document.getElementById("modalRetiradosTiempo");

// Obtener el botón que abre el modal
var btnTiempo = document.getElementById("btnOpenModalRetiradosTiempo");

// Obtener el elemento <span> que cierra el modal
var spanTiempo = document.getElementById("closeRetiradosTiempo");

// Al hacer clic en el botón, abrir el modal
btnTiempo.onclick = function() {
  modalTiempo.style.display = "block";
}

// Al hacer clic en <span> (x), cerrar el modal
spanTiempo.onclick = function() {
  modalTiempo.style.display = "none";
}

// También cierra el modal si el usuario hace clic fuera de él
window.onclick = function(event) {
  if (event.target == modalTiempo) {
    modalTiempo.style.display = "none";
  }
}

// JavaScript para manejar la apertura y cierre de modales
document.addEventListener('DOMContentLoaded', function() {
    var modalEstudiantes = document.getElementById('estudiantesModal');
    var btnImprimirListaEstudiantes = document.getElementById('btnImprimirListaEstudiantes');
    var modalListaEstudiantes = document.getElementById('modal-lista-estudiantes');
    var closeListaEstudiantesModal = document.getElementById('closeListaEstudiantesModal');

    // Abrir el modal de lista de estudiantes
    btnImprimirListaEstudiantes.onclick = function() {
        modalEstudiantes.style.display = "none";
        modalListaEstudiantes.style.display = "block";
    }

    // Cerrar el modal de lista de estudiantes
    closeListaEstudiantesModal.onclick = function() {
        modalListaEstudiantes.style.display = "none";
    }

    // Cerrar modal si se hace clic fuera de él
    window.onclick = function(event) {
        if (event.target == modalListaEstudiantes) {
            modalListaEstudiantes.style.display = "none";
        }
    }
});
 $(document).ready(function() {
    // Función para actualizar el selector de alumnos
    function actualizarSelectAlumnos(alumnos) {
        var selectAlumno = $('.modal-content-retirados #selectAlumno, .modal-content-justificacion #selectAlumno');
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
    $('.modal-content-retirados #filtroAlumno, .modal-content-justificacion #filtroAlumno').on('input', function() {
        var alumno = $(this).val();

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
                var carreraHidden = $('.modal-content-retirados #carrera, .modal-content-justificacion #carrera');
                if (response.alumnos.length > 0) {
                    carreraHidden.val(response.alumnos[0].carreras_idCarrera);
                    // Llamar a la función para actualizar el selector de materias
                    actualizarSelectMaterias(response.alumnos[0].carreras_idCarrera);
                } else {
                    carreraHidden.val(''); // Si no hay alumnos, vaciar el valor del input hidden
                    // Limpiar el selector de materias
                    limpiarSelectMaterias();
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Función para actualizar el selector de materias
    function actualizarSelectMaterias(idCarrera) {
        $.ajax({
            url: 'obtener_materias.php',
            method: 'POST',
            data: { carrera: idCarrera },
            dataType: 'json',
            success: function(response) {
                var selectMateria = $('.modal-content-retirados #selectMateria, .modal-content-justificacion #selectMateria');
                selectMateria.empty(); // Vaciar el select para llenarlo de nuevo

                // Agregar una opción por cada materia recibida
                response.materias.forEach(function(materia) {
                    var option = $('<option>', {
                        value: materia.idMaterias,
                        text: materia.Nombre
                    });
                    selectMateria.append(option);
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Función para limpiar el selector de materias
    function limpiarSelectMaterias() {
        var selectMateria = $('.modal-content-retirados #selectMateria, .modal-content-justificacion #selectMateria');
        selectMateria.empty(); // Vaciar el select
        selectMateria.append('<option value="">Seleccione Materia</option>'); // Agregar la opción por defecto
    }

    // Interceptamos el envío del formulario para cambiar los valores de los selectores por los IDs
    $('#miFormularioRetirados').submit(function() {
        var alumnoSeleccionado = $('.modal-content-retirados #selectAlumno, .modal-content-justificacion #selectAlumno').val();

        // Actualizamos los valores de los selectores por los IDs
        $('.modal-content-retirados #selectAlumno, .modal-content-justificacion #selectAlumno').val(alumnoSeleccionado);
        // El valor de la materia ya es el ID, no es necesario cambiarlo
    });

    // Evento change para el select de alumno
    $('.modal-content-retirados #selectAlumno, .modal-content-justificacion #selectAlumno').change(function() {
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
                $('.modal-content-retirados #carrera, .modal-content-justificacion #carrera').val(response.carrera);
                // Llamar a la función para actualizar el selector de materias
                actualizarSelectMaterias(response.carrera);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

  // Función para cerrar el modal
  function closeModal() {
    var modal = document.getElementById('modal');
    modal.style.display = 'none';
  }


  
  // Función para abrir el modal
function abrirModalJustificacion() {
  document.getElementsByClassName("modal-justificacion")[0].style.display = "block";
}

// Función para cerrar el modal
function cerrarModalJustificacion() {
  document.getElementsByClassName("modal-justificacion")[0].style.display = "none";
}



</script>
</body>
</html>
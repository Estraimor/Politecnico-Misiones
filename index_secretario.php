<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ./login/login.php');}

// Set inactivity limit in seconds
$inactivity_limit = 1200;

// Check if the user has been inactive for too long
if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > $inactivity_limit)) {
    // User has been inactive, so destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: ./login/login.php");
    exit; // Terminar el script después de redireccionar
} else {
    // Update the session time to the current time
    $_SESSION['time'] = time();
}
?>
<?php include'./conexion/conexion.php'; ?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGPM</title>
    <link rel="stylesheet" type="text/css" href="./estilos.css">
    <link rel="stylesheet" type="text/css" href="./normalize.css">
    <link rel="icon" href="./politecnico.ico">
    <link rel="stylesheet" type="text/css" href="./indexs/cssinforme.css">
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
            <a href="index_bruno.php" class="home-button">Inicio</a>
            <button class="btn-new-member" id="btn-new-member">Nuevo Estudiante</button>
            <button class="btn-new-member" id="btnOpenNewStudentFP">Nuevo Estudiante FP</button>
            <button class="btn-situacion-academica">
              <a href="../proximamente/proximamente.php" class="btn-link">Situación Académica</a>
            </button>
            <button class="btn-preceptores">
              <a href="./preceptores.php">Preceptores</a>
            </button>
            <button class="btn-preceptores">
              <a href="../proximamente/proximamente.php">Profesores</a>
            </button>
          </div>


    <div class="nav-right">
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
    
    
    
</nav>
  <button id="btnMostrarEstudiantes">Estudiantes</button>
<!-- Modal para la tabla de estudiantes -->
<div id="estudiantesModal" class="estudiantes-modal">
  <div class="modal-content-estudiantes">
    <span class="modal-close-estudiantes close-modal-button" id="closeEstudiantesModal">&times; Cerrar</span>
    <button id="btnMostrarInformesAsistencia" class="boton-informes-asistencia">Informes de Asistencias</button>
    <button id="modallistaestudiantestecnicaturas" class="boton-informes-asistencia">Generar Informe estudiantes</button>
    <div id="tablaContainerEstudiantes">
      <table id="tabla">
        <thead>
          <tr>
            <th>Legajo</th>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>DNI</th>
            <th>Celular</th>
            <th>Carrera</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
            <?php
            $sql1 = "SELECT * FROM inscripcion_asignatura ia 
            INNER JOIN alumno a on ia.alumno_legajo = a.legajo 
            INNER JOIN preceptores p ON p.carreras_idCarrera = ia.carreras_idCarrera 
            INNER JOIN carreras c on ia.carreras_idCarrera = c.idCarrera
             WHERE  a.estado = '1'";
            $query1 = mysqli_query($conexion, $sql1);
            while ($datos = mysqli_fetch_assoc($query1)) {
                ?>
                <tr>
                    <td><?php echo $datos['legajo']; ?></td>
                    <td><?php echo $datos['apellido_alumno']; ?></td>
                    <td><?php echo $datos['nombre_alumno']; ?></td>
                    <td><?php echo $datos['dni_alumno']; ?></td>
                    <td><?php echo $datos['celular']; ?></td>
                    <td><?php echo $datos['nombre_carrera']; ?></td>
                    <td><a href="./Profesor/modificar_alumno.php?legajo=<?php echo $datos['legajo']; ?>" class="modificar-button"><i class="fas fa-pencil-alt"></i></a>
                        <a href="#" onclick="return confirmarBorrado('<?php echo $datos['legajo']; ?>')" class="borrar-button"><i class="fas fa-trash-alt"></i></a>
                        <a href="./Profesor/porcentajes_de_asistencia.php?legajo=<?php echo $datos['legajo']; ?>" class="accion-button"><i class="fas fa-exclamation"></i></a></td>
                        


                </tr>
                <?php
            }
            ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
   
   <button id="btnMostrarEstudiantesFP">EstudiantesFP</button>
<!-- Modal para la tabla de estudiantes -->
<div id="estudiantesModalFP" class="estudiantes-modal">
  <div class="modal-content-estudiantes-FP">
    <span class="modal-close-estudiantes close-modal-button" id="closeEstudiantesModalFP">&times; Cerrar</span>
    <button id="btnMostrarInformesAsistenciaFP" class="boton-informes-asistencia">Informes de Asistencias</button>
    <button id="abrirInformeFP" class="boton-informes-asistencia">Generar Informe estudiantes</button>
    <div id="tablaContainerEstudiantesFP">
      <table id="tablaFP">
        <thead>
          <tr>
            <th class="legajo">Legajo</th>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>DNI</th>
            <th>Celular</th>
            <th class="ths">Carrera1</th>
            <th class="ths">Carrera2</th>
            <th class="ths">Carrera3</th>
            <th class="ths">Carrera4</th>
            <th class="ths">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql1 = "SELECT af.nombre_afp, af.apellido_afp, af.legajo_afp, af.dni_afp, af.celular_afp, 
                           c1.nombre_carrera AS nombre_carrera1, 
                           c2.nombre_carrera AS nombre_carrera2, 
                           c3.nombre_carrera AS nombre_carrera3, 
                           c4.nombre_carrera AS nombre_carrera4
                    FROM alumnos_fp af
                    LEFT JOIN carreras c1 ON af.carreras_idCarrera = c1.idCarrera
                    LEFT JOIN carreras c2 ON af.carreras_idCarrera1 = c2.idCarrera
                    LEFT JOIN carreras c3 ON af.carreras_idCarrera2 = c3.idCarrera
                    LEFT JOIN carreras c4 ON af.carreras_idCarrera3 = c4.idCarrera
                    WHERE af.estado = '1';";
          $query1 = mysqli_query($conexion, $sql1);
          while ($datos = mysqli_fetch_assoc($query1)) {
          ?>
            <tr>
              <td><?php echo $datos['legajo_afp']; ?></td>
              <td><?php echo $datos['apellido_afp']; ?></td>
              <td><?php echo $datos['nombre_afp']; ?></td>
              <td><?php echo $datos['dni_afp']; ?></td>
              <td><?php echo $datos['celular_afp']; ?></td>
              <td><?php echo $datos['nombre_carrera1']; ?></td>
              <td><?php echo $datos['nombre_carrera2']; ?></td>
              <td><?php echo $datos['nombre_carrera3']; ?></td>
              <td><?php echo $datos['nombre_carrera4']; ?></td>
              <td>
                <a href="./FP/ABM_FP/modificar_alumnoFP.php?legajo=<?php echo $datos['legajo_afp']; ?>" class="modificar-button"><i class="fas fa-pencil-alt"></i></a>
                <a href="#" onclick="return nombreNuevo('<?php echo $datos['legajo_afp']; ?>')" class="borrar-button"><i class="fas fa-trash-alt"></i></a>
                <a href="./FP/info_FP.php?legajo=<?php echo $datos['legajo_afp']; ?>" class="accion-button"><i class="fas fa-exclamation"></i></a>
              </td>
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
  <?php include'./Profesor/estudiante/guardar_estudiante.php'; ?>
    <h2 class="form-container__h2">Registro de Estudiante</h2>
    <form action="" method="post">
      <input type="text" class="form-container__input" name="nombre_alu" placeholder="Ingrese el nombre" autocomplete="off" required>
      <input type="text" class="form-container__input" name="apellido_alu" placeholder="Ingrese el apellido" autocomplete="off" required>
      <input type="number" class="form-container__input" name="dni_alu" placeholder="Ingrese el DNI" autocomplete="off" required>
      <input type="number" class="form-container__input" name="celular" placeholder="Ingrese el celular" autocomplete="off">
      
     <?php
        // Consulta para obtener el último número de legajo
        $sql_legajo = "SELECT MAX(legajo) AS max_legajo FROM alumno";
        $resultado_legajo = $conexion->query($sql_legajo);
        $fila_legajo = $resultado_legajo->fetch_assoc();
        $nuevo_legajo = $fila_legajo['max_legajo'] + 1; // Nuevo legajo es el último más uno
    ?>
    <!-- Campo de legajo con el valor obtenido de la base de datos -->
    <input type="text" name="legajo" placeholder="N° Legajo"  value="<?php echo $nuevo_legajo; ?>" class="form-container__input" >
      <input type="date" class="form-container__input" name="edad" placeholder="Ingrese fecha de nacimiento" autocomplete="off">
      <input type="text" class="form-container__input" name="observaciones" placeholder="Observaciones" autocomplete="off" required>
      <input type="text" class="form-container__input" name="Trabajo_Horario" placeholder="Trabajo / Horario" autocomplete="off" required>
      <!-- php para la recorrida de las carreras del select -->
      <?php
       $sql_mater = "SELECT * FROM carreras";
       $peticion = mysqli_query($conexion, $sql_mater);
      ?>      
      <select name="inscripcion_carrera" class="form-container__input"> 
        <option hidden>Selecciona una carrera</option>
        <?php while ($informacion = mysqli_fetch_assoc($peticion)) { ?>
          <option value="<?php echo $informacion['idCarrera'] ?>"><?php echo $informacion['nombre_carrera'] ?></option>
        <?php }?>
      </select>

      <input type="submit" class="form-container__input" name="enviar" value="Enviar" onclick="mostrarAlertaExitosa(); closeSuccessMessage();">
    </form>
    
  </div>
</div>


<div id="modalInformesAsistencia" class="modal-informes-asistencia">
    <div class="modal-content-informes-asistencia">
    <span class="cerrar-modal-informes-asistencia">&times;</span>
        <h2>Generar Excel de Asistencias</h2>
        <br>
        <form action="./indexs/generar_excel.php" method="post">
            <label for="fecha_inicio">Fecha de inicio:</label>
            <input type="date" id="fecha_inicio" class="input_fecha" name="fecha_inicio">
            <br><br>
            <label for="fecha_fin">Fecha de fin:</label>
            <input type="date" id="fecha_fin" class="input_fecha" name="fecha_fin">
            <br><br>
            <?php
       $sql_mater="SELECT * 
       FROM preceptores p 
       INNER JOIN carreras c on p.carreras_idCarrera = c.idCarrera
       -- WHERE p.profesor_idProrfesor = '{$_SESSION["id"]}'  ";
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


<div id="modal-lista-estudiantes" class="modal-lista-estudiantes" style="display: none; position: fixed; z-index: 155555555555; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content-lista-estudiantes" style="background-color: rgba(255, 255, 255, 0.9); margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);">
        <span class="close-modal-button" id="closeListaEstudiantesModal" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
        <h2>Informe de Estudiantes</h2>
        <form action="./indexs/generar_exel_alumnos.php" method="post">
            <?php
            $sql_mater = "select * from preceptores p 
            INNER JOIN carreras c on c.idCarrera = p.carreras_idCarrera
            -- WHERE p.profesor_idProrfesor = {$_SESSION["id"]} ";
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

<div id="modal-lista-estudiantes-FP" class="modal-lista-estudiantes" style="display: none; position: fixed; z-index: 155555555555; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content-lista-estudiantes" style="background-color: rgba(255, 255, 255, 0.9); margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);">
        <span class="close-modal-button" id="closeListaEstudiantesModal-FP" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
        <h2>Informe de Estudiantes</h2>
        <form action="./indexs/generar_exel_alumnos.php" method="post">
            <?php
            $sql_mater = "select * from preceptores p 
            INNER JOIN carreras c on c.idCarrera = p.carreras_idCarrera
            -- WHERE p.profesor_idProrfesor = {$_SESSION["id"]} ";
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








<div id="modalNewStudentFP" class="modal-student-fp">
  <!-- Contenido del modal -->
  <div class="modal-content-student-fp">
  
  <?php
    
    // Consulta para obtener las carreras
    $sql_carreras = "SELECT * FROM carreras c WHERE c.idCarrera IN ('8','14','15','64','65')";
    $resultado_carreras = mysqli_query($conexion, $sql_carreras);
    $carreras = array(); // Almacenar las carreras en un array

    while ($informacion_carrera = mysqli_fetch_assoc($resultado_carreras)) {
        $carreras[] = $informacion_carrera; // Añadir cada carrera al array
    }
?>
    <span class="close-student-fp">&times;</span>
    <form action="./FP/ABM_FP/guardar_alumnofp.php" method="post">
    <h2>Registro de FP</h2>
        <?php
        // Consulta para obtener el último número de legajo
        $sql_legajo = "SELECT MAX(legajo_afp) AS max_legajo FROM alumnos_fp";
        $resultado_legajo = $conexion->query($sql_legajo);
        $fila_legajo = $resultado_legajo->fetch_assoc();
        $nuevo_legajo = $fila_legajo['max_legajo'] + 1; // Nuevo legajo es el último más uno
    ?>
    <!-- Campo de legajo con el valor obtenido de la base de datos -->
    <input type="text" name="legajo" placeholder="N° Legajo"  value="<?php echo $nuevo_legajo; ?>" class="form-container__input" >
        <input type="text" name="nombre" placeholder="Nombre" class="form-container__input" autocomplete="off">
        <input type="text" name="apellido" placeholder="Apellido" class="form-container__input" autocomplete="off">
        <input type="number" name="dni" placeholder="DNI" class="form-container__input" autocomplete="off">
        <input type="number" name="celular" placeholder="Celular" class="form-container__input" autocomplete="off">
        <input type="text" name="observaciones" placeholder="Observaciones" class="form-container__input" autocomplete="off">
        <input type="text" name="trabaja" placeholder="Trabaja" class="form-container__input" autocomplete="off">
        <!-- PHP code to generate options goes here -->
        <select name="FP1" class="form-container__input">
        <?php foreach ($carreras as $carrera) { ?>
        <option value="65" hidden selected>Selecciona un curso</option>
            <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
            <?php } ?>
        </select>
        <select name="FP2" class="form-container__input">
        <?php foreach ($carreras as $carrera) { ?>
            <option value="65" hidden selected>Selecciona un curso</option>
            <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
            <?php } ?>
        </select>
        <select name="FP3" class="form-container__input">
        <?php foreach ($carreras as $carrera) { ?>
            <option value="65" hidden selected>Selecciona un curso</option>
            <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
            <?php } ?>
        </select>
        <select name="FP4" class="form-container__input">
        <?php foreach ($carreras as $carrera) { ?>
            <option value="65" hidden selected>Selecciona un curso</option>
            <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
            <?php } ?>
        </select>
        <input type="submit" name="enviar" value="Enviar" class="form-container__input">
    </form>
  </div>
</div>



<div class="nav-welcome-container">

<div id="welcome-box" class="welcome-box">
  <h1 class="welcome-box__h1">Bienvenido</h1>
  <p class="welcome-box__p">¡Secr. Mendoza Roberto!</p>
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


  
  var btnMostrarEstudiantesFP = document.getElementById("btnMostrarEstudiantesFP");
var estudiantesModalFP = document.getElementById("estudiantesModalFP");
var closeEstudiantesModalFP = document.getElementById("closeEstudiantesModalFP");

btnMostrarEstudiantesFP.addEventListener("click", function() {
  console.log("Botón EstudiantesFP clickeado");
  estudiantesModalFP.style.display = "block";
});

closeEstudiantesModalFP.addEventListener("click", function() {
  estudiantesModalFP.style.display = "none";
});

window.addEventListener("click", function(event) {
  if (event.target === estudiantesModalFP) {
    estudiantesModalFP.style.display = "none";
  }
});

// dataTables de FP //
var myTable = document.querySelector("#tablaFP");
var dataTable = new DataTable(tablaFP);
//------------------------------------------- Cierre de session automatica-------------------------------//

    function confirmarBorrado(legajo) {
    var respuesta = confirm("¿Estás seguro de que quieres borrar este alumno?");
    if (respuesta) {
        // Realizar el borrado lógico directamente sin redirección previa
        window.location.href = "./Profesor/Borrado_logico_alumno.php?legajo=" + legajo;
    }
    return false; // Evita que el navegador siga el enlace en caso de cancelar la confirmación
}

 function nombreNuevo(legajo) {
        var respuesta = confirm("¿Estás seguro de que quieres borrar este alumno?");
        if (respuesta) {
            // Realizar el borrado lógico directamente sin redirección previa
            window.location.href = "./FP/ABM_FP/Borrado_logico_AFP.php?legajo=" + legajo;
        }
        return false; // Evita que el navegador siga el enlace en caso de cancelar la confirmación
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
var modal = document.getElementById('modalNewStudentFP');

// Obtener el botón que abre el modal
var btn = document.getElementById('btnOpenNewStudentFP');

// Obtener el elemento <span> que cierra el modal
var span = document.getElementsByClassName('close-student-fp')[0];

// Cuando el usuario haga clic en el botón, abrir el modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// Cuando el usuario haga clic en <span> (x), cerrar el modal
span.onclick = function() {
    modal.style.display = "none";
}

// Cuando el usuario haga clic fuera del modal, cerrarlo
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


document.addEventListener("DOMContentLoaded", function() {
  var modal = document.getElementById("modal-lista-estudiantes-FP");
  var btnOpenModal = document.getElementById("abrirInformeFP");
  var btnCloseModal = document.getElementById("closeListaEstudiantesModal-FP");

  // Evento para abrir el modal
  btnOpenModal.addEventListener("click", function() {
      modal.style.display = "block";
  });

  // Evento para cerrar el modal
  btnCloseModal.addEventListener("click", function() {
      modal.style.display = "none";
  });

  // También cierra el modal si el usuario hace clic fuera del contenido del modal
  window.onclick = function(event) {
      if (event.target === modal) {
          modal.style.display = "none";
      }
  }
});



   // Esta función muestra el modal
   function mostrarModal() {
    var modal = document.getElementById('modal-lista-estudiantes');
    modal.style.display = 'block';
}

// Esta función oculta el modal
function cerrarModal() {
    var modal = document.getElementById('modal-lista-estudiantes');
    modal.style.display = 'none';
}

// Asignar eventos al cargar la página
window.onload = function() {
    // Asignar el evento click al botón de cierre
    var botonCierre = document.getElementById('closeListaEstudiantesModal');
    botonCierre.onclick = function() {
        cerrarModal();
    };

    // Asignar evento click al botón que abre el modal
    var botonAbrir = document.getElementById('modallistaestudiantestecnicaturas');
    botonAbrir.onclick = function() {
        mostrarModal();
    };
};

// Cerrar el modal al hacer clic fuera de su contenido
window.onclick = function(event) {
    var modal = document.getElementById('modal-lista-estudiantes');
    if (event.target == modal) {
        cerrarModal();
    }
};
</script>
</body>
</html>
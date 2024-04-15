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
  <title>Modal de Alumnos Retirados</title>
 
</head>
<body>

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
    
    <form action="./guardar_falta_justificada.php" id="miFormulario" method="post">
      
      <input class="form-container__input" type="text" name="filtroAlumno" id="filtroAlumno" placeholder="Filtrar por nombre, apellido o legajo de alumno">
      <select name="selectAlumno" id="selectAlumno" class="form-container__input">
        <option value="" >Seleccionar alumno</option>
      </select>
      <input type="hidden" id="carrera" name="carrera" value="" class="form-container__input">
      <select id="selectMateria" name="materia" class="form-container__input">
        <option value="">Seleccione Materia</option>
      </select>
      <input type="text" name="motivo" placeholder="Motivo de Falta" class="form-container__input">
      <input type="date" name="fecha" id="" class="form-container__input">
      <input type="submit" class="form-container__input" name="enviar" value="Confirmar">
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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

  // Función para cerrar el modal
  function closeModal() {
    var modal = document.getElementById('modal');
    modal.style.display = 'none';
  }
</script>

</body>
</html>

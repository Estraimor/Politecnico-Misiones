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
    <span class="user-name"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></span>
    <a href="../../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </nav>
  

  <?php
    $curso = $_GET['id_curso'];
    $carrera = $_GET['id_carrera'];
    $comision = $_GET['id_comision']; 

$sql_4 = "SELECT c.nombre_curso, c2.nombre_carrera, cm.N_comicion FROM inscripcion_asignatura ia
INNER JOIN cursos c on ia.cursos_idcursos = c.idcursos
INNER JOIN materias m on ia.materias_idMaterias = m.idMaterias
INNER JOIN carreras c2 on m.carreras_idCarrera = c2.idCarrera
INNER JOIN comisiones cm on ia.comisiones_idComisiones = cm.idComisiones
WHERE c.idcursos = '$curso' AND c2.idCarrera = '$carrera' AND cm.idComisiones = '$comision'";

    $query4 = mysqli_query($conexion, $sql_4);

    if ($query4) {
        $datos = mysqli_fetch_array($query4);
        if ($datos) {
           // Mostrar los datos solo si existen
            echo "<h1>Asistencia de " . $datos['nombre_carrera'] . " " . $datos['nombre_curso'] . " Comision : " . $datos['N_comicion'] . "</h1>";
        } else {
           // Manejar el caso en el que no se encontraron resultados
            echo "<h1>No se encontraron datos para los parámetros proporcionados.</h1>";
        }
    } else {
       // Manejar errores de consulta
        echo "<h1>Error en la consulta.</h1>";
    }
?>
<input type="hidden" id="carrera" value="<?php echo $carrera ?>">
<input type="hidden" id="comision" value="<?php echo $comision ?>">
<input type="hidden" id="curso" value="<?php echo $curso ?>"> 
<div class="date-picker">
<h2 class="invisible-title">Ver Asistencia</h2>
    <label for="fecha">Selecciona una fecha:</label>
    <input type="date" id="fecha" name="fecha" onchange="showAsistencia()">
</div>
<div class="table-responsive">
    <table class="table-comision-a">
        
        <tbody id="asistenciaBody">
            <!-- Aquí se mostrará la asistencia cargada mediante Ajax -->
        </tbody>
    </table>
</div>
    
<script>
  
  document.addEventListener('DOMContentLoaded', function() {
    // Crear un nuevo objeto de fecha para obtener la fecha actual.
    var today = new Date();
    // Obtener el año, mes y día de la fecha actual.
    var year = today.getFullYear();
    var month = ('0' + (today.getMonth() + 1)).slice(-2); // Añade un cero si es necesario (formato MM).
    var day = ('0' + today.getDate()).slice(-2); // Añade un cero si es necesario (formato DD).
    // Formatear la fecha al formato aceptado por el input de tipo fecha (YYYY-MM-DD).
    var formattedDate = year + '-' + month + '-' + day;
    // Comentamos la línea que configura el valor predeterminado:
    // document.getElementById('fecha').value = formattedDate;
});

function showModalMessage() {
    alert('¡Los datos se han enviado satisfactoriamente!');
}

function showDatePicker() {
    const fechaInput = document.getElementById("fecha");
    const fechaSeleccionada = fechaInput.value;
    const fechaMostrada = document.getElementById("fecha-seleccionada");

    fechaMostrada.textContent = "Fecha seleccionada: " + fechaSeleccionada;
}

// Ajax para recargar la fecha en el mismo modal (Comisión A)
function showAsistencia() {
    var carrera = $("#carrera").val();
    var comision = $("#comision").val();
    var curso = $("#curso").val();
    var selectedDate = $("#fecha").val();

    $.ajax({
        type: "GET",
        url: "obtener_asistencia_ajax.php",
        data: { 
            carrera: carrera,
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

</script>

<style>
    /* Contenedor del área de navegación derecha */
.nav-right {
    display: flex;
    align-items: center;
    gap: 15px; /* Espacio entre el nombre del usuario y el botón */
    font-family: Arial, sans-serif;
}

/* Estilo del nombre del usuario */
.user-name {
    font-size: 16px;
    font-weight: bold;
    color: #fff; /* Color blanco para el texto */
    text-transform: capitalize; /* Primera letra en mayúscula */
    margin-right: 10px; /* Separación adicional si es necesario */
}

/* Estilo del botón de cerrar sesión */
.btn-logout {
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    padding: 8px 15px;
    color: #fff; /* Color del texto */
    background-color: #f3545d; /* Fondo rojo */
    border-radius: 5px; /* Bordes redondeados */
    transition: all 0.3s ease; /* Transición suave */
}

/* Hover para el botón */
.btn-logout:hover {
    background-color: #d93b4b; /* Fondo más oscuro en hover */
    color: #fff; /* Asegurarse de que el texto sigue blanco */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Sombra al pasar el cursor */
}
/* Contenedor del input de fecha */
.date-picker {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
    background-color: transparent; /* Elimina el fondo blanco */
    padding: 0; /* Elimina cualquier padding */
    border: none; /* Elimina cualquier borde */
}

/* Estilo del h2 */
.date-picker .invisible-title {
    font-size: 25px;
    font-weight: bold;
    color: white; /* Texto en blanco */
    text-align: center;
    margin-bottom: 10px;
}

/* Input de fecha */
.date-picker input[type="date"] {
    width: 150px; /* Ajustar el ancho */
    padding: 8px;
    font-size: 14px;
    border: 2px solid #ccc;
    border-radius: 5px;
    text-align: center;
    background-color: #f9f9f9; /* Fondo del input */
    color: #555; /* Color del texto dentro del input */
    cursor: pointer;
}

/* Hover para el input */
.date-picker input[type="date"]:hover {
    border-color: #f3545d;
}

/* Focus para el input */
.date-picker input[type="date"]:focus {
    outline: none;
    border-color: #f3545d;
    box-shadow: 0 0 5px rgba(243, 84, 93, 0.5);
}
.date-picker label {
    font-size: 18px;
    font-weight: bold;
    color: #fff; /* Cambiar texto del label a blanco */
    margin-bottom: 5px;
}

</style>
</body>
</html>

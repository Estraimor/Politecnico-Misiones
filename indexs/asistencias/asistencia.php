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
  


<br>
<br>




  
 
        
<form action="../../Profesor/asistencia/guardar_asistencia_enfermeria.php" method="post">
<h2 class="section-title"> Tomar Asistencia </h2>
    <div class="table-responsive">
        <?php
        include '../../conexion/conexion.php';

        $curso = $_GET['id_curso'];
        $carrera = $_GET['id_carrera'];
        $comision = $_GET['id_comision'];

        $sql_materias = "
            SELECT * 
            FROM cursos_has_materias cm
            INNER JOIN materias m ON cm.materias_idMaterias = m.idMaterias
            WHERE cm.cursos_idcursos = '$curso' 
            AND m.carreras_idCarrera = '$carrera'
        ";
        $query_materias = mysqli_query($conexion, $sql_materias);
        $materias = [];
        while ($materia = mysqli_fetch_assoc($query_materias)) {
            $materias[] = $materia;
        }
        ?>

        <!-- Campos ocultos -->
        <input type="hidden" name="idcarrera" value="<?php echo $carrera; ?>">
        <input type="hidden" name="comision" value="<?php echo $comision; ?>">
        <input type="hidden" name="curso" value="<?php echo $curso; ?>">
        <div class="date-picker">
    <label for="fecha">Fecha Actual:</label>
    <input type="text" id="fecha" name="fecha" readonly>
</div>

        <table class="table-comision-a">
            <thead>
                <tr>
                    <th rowspan="2" class="header-cell">N°</th>
                    <th rowspan="2" class="header-cell">Apellido</th>
                    <th rowspan="2" class="header-cell">Nombre</th>
                    <th colspan="2" class="header-cell">
                        <!-- Select para elegir la materia -->
                        <select name="materia1" id="materiaSelect" class="form-container__input" required>
                            <option hidden value="">Selecciona una Materia</option>
                            <?php foreach ($materias as $materia) { ?>
                                <option value="<?php echo $materia['idMaterias']; ?>">
                                    <?php echo $materia['Nombre']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </th>
                </tr>
                <tr>
                    <th class="header-cell">Presente</th>
                    <th class="header-cell">Ausente</th>
                </tr>
            </thead>
            <tbody id="asistenciasTable">
                <!-- Las filas se generarán dinámicamente con JavaScript -->
            </tbody>
        </table>

        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn-submit">Guardar Asistencias</button>
    </div>
</form>


    
<script>


function validarFormulario() {
    const materiaSelect = document.getElementById('materiaSelect');

    // Verificar si se seleccionó una materia
    if (materiaSelect.value === "") {
        alert("Por favor, selecciona una materia antes de enviar el formulario.");
        return false; // Bloquear el envío del formulario
    }

    return true; // Permitir el envío si todo está correcto
}



document.addEventListener('DOMContentLoaded', function () {
    const materiaSelect = document.getElementById("materiaSelect");
    if (materiaSelect) {
        materiaSelect.addEventListener("change", function () {
            var materiaId = this.value;
            var curso = "<?php echo $curso; ?>";
            var carrera = "<?php echo $carrera; ?>";
            var comision = "<?php echo $comision; ?>";

            // Realizar una solicitud AJAX para obtener las asistencias de la materia seleccionada
            fetch(`./obtener_asistencias.php?materia=${materiaId}&curso=${curso}&carrera=${carrera}&comision=${comision}`)
                .then(response => response.json())
                .then(data => {
                    var tableBody = document.getElementById("asistenciasTable");
                    tableBody.innerHTML = ""; // Limpiar la tabla

                    if (data.error) {
                        console.error("Error en la consulta:", data.error);
                        return;
                    }

                    if (data.length === 0) {
                        tableBody.innerHTML = `<tr><td colspan="5" class="data-cell">No hay estudiantes inscritos para esta materia.</td></tr>`;
                        return;
                    }

                    data.forEach((item, index) => {
                        var row = `
                            <tr>
                                <td class="data-cell">${index + 1}</td>
                                <td class="data-cell">${item.apellido_alumno}</td>
                                <td class="data-cell">${item.nombre_alumno}</td>
                                <td class="checkbox-cell">
                                    <input type="radio" name="asistencia[${item.legajo}]" value="1" ${item.asistencia == 1 ? "checked" : ""} >
                                </td>
                                <td class="checkbox-cell">
                                    <input type="radio" name="asistencia[${item.legajo}]" value="2" ${item.asistencia == 2 ? "checked" : ""} >
                                </td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => console.error("Error al cargar las asistencias:", error));
        });
    } else {
        console.error("El elemento materiaSelect no existe en el DOM.");
    }
});
document.addEventListener('DOMContentLoaded', function() {
    var today = new Date();
    var year = today.getFullYear();
    var month = ('0' + (today.getMonth() + 1)).slice(-2); // Añade ceros si es necesario
    var day = ('0' + today.getDate()).slice(-2); // Añade ceros si es necesario
    var formattedDate = day + '/' + month + '/' + year; // Formato: DD/MM/YYYY
    document.getElementById('fecha').value = formattedDate; // Asignar al input
});

</script>

<style>
/* Contenedor del input de fecha */
.date-picker {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
    background-color: transparent; /* Asegúrate de que el fondo sea transparente */
    padding: 0; /* Elimina cualquier padding extra */
    border: none; /* Evita que haya un borde extra */
}
/* Estilo del label */
.date-picker label {
    font-size: 18px;
    font-weight: bold;
    color: #fff; /* Cambiar texto del label a blanco */
    margin-bottom: 5px;
}
/* Input de fecha */
.date-picker input[type="text"] {
    width: 150px; /* Ajustar el ancho */
    padding: 8px;
    font-size: 14px;
    border: 2px solid #ccc;
    border-radius: 5px;
    text-align: center;
    background-color: #f9f9f9; /* Fondo solo del input */
    color: #000;
    cursor: not-allowed; /* Indica que es de solo lectura */
    box-shadow: none; /* Elimina cualquier sombra */
}

/* Hover para el input */
.date-picker input[type="text"]:hover {
    border-color: #f3545d;
}

/* Focus para el input */
.date-picker input[type="text"]:focus {
    outline: none;
    border-color: #f3545d;
    box-shadow: 0 0 5px rgba(243, 84, 93, 0.5);
}


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

.section-title {
    font-size: 28px; /* Tamaño del texto más grande */
    font-weight: bold; /* Texto en negrita */
    color: #fff; /* Color del texto en blanco */
    text-align: center; /* Centrar el texto */
    margin-top: 20px; /* Espaciado superior */
    margin-bottom: 20px; /* Espaciado inferior */
    text-transform: uppercase; /* Texto en mayúsculas */
    font-family: 'Arial', sans-serif; /* Fuente moderna */
    letter-spacing: 2px; /* Espaciado entre letras */
    position: relative; /* Para añadir efectos decorativos */
}

/* Línea decorativa debajo del texto */
.section-title::after {
    content: ""; /* Pseudo-elemento vacío */
    display: block;
    width: 50%; /* Ancho de la línea decorativa */
    height: 3px; /* Grosor de la línea */
    background-color: #f3545d; /* Color rojo elegante */
    margin: 10px auto 0; /* Centrar la línea y separarla del texto */
    border-radius: 5px; /* Bordes redondeados */
}

/* Efecto hover (opcional) */
.section-title:hover {
    color: #f3545d; /* Cambia el texto a rojo al pasar el cursor */
    transition: color 0.3s ease; /* Transición suave */
}

.section-title:hover::after {
    background-color: #fff; /* Cambia la línea a blanco al pasar el cursor */
    transition: background-color 0.3s ease; /* Transición suave */
}



</style>
</body>
</html>

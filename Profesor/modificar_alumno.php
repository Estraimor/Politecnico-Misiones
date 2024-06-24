<?php
session_start();
if (empty($_SESSION["id"])) {
    header('Location: ../login/login.php');
}

// Set inactivity limit in seconds
$inactivity_limit = 1200;

// Check if the user has been inactive for too long
if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > $inactivity_limit)) {
    session_unset();
    session_destroy();
    header("Location: ../login/login.php");
    exit;
} else {
    $_SESSION['time'] = time();
}
?>
<?php include '../conexion/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencias Politécnico</title>
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link rel="stylesheet" type="text/css" href="./estilos_modificar_estudiante.css">
    <link rel="stylesheet" type="text/css" href="../normalize.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-datatables.min.js" type="text/javascript"></script>
</head>
<body>
<div id="success-message" class="success-message" style="display: none;"></div>
<div class="background">
<button class="toggle-menu-button" id="toggle-menu-button" onclick="toggleMenu()">
  <span id="toggle-menu-icon">☰</span>
</button>
<nav class="navbar">
    <div class="nav-right">
        <a href="./controlador_preceptormodificar.php" class="home-button">Inicio</a>
        <a href="../login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
    </div>
</nav>

<?php
if (isset($_GET['legajo'])) {
    $legajo = $_GET['legajo'];
    $sql = "SELECT * FROM alumno a
            INNER JOIN inscripcion_asignatura ia ON a.legajo = ia.alumno_legajo
            WHERE legajo = '$legajo'";
    $query = mysqli_query($conexion, $sql);
    $datos = mysqli_fetch_assoc($query);

    // Obtener todas las materias de la carrera del estudiante
    $sql_todas_materias = "SELECT m.idMaterias, m.Nombre, cm.cursos_idcursos 
                           FROM materias m
                           INNER JOIN cursos_has_materias cm ON cm.materias_idMaterias = m.idMaterias
                           WHERE m.carreras_idCarrera = (SELECT carreras_idCarrera FROM materias WHERE idMaterias = (SELECT materias_idMaterias FROM inscripcion_asignatura WHERE alumno_legajo = '$legajo' LIMIT 1))";
    $query_todas_materias = mysqli_query($conexion, $sql_todas_materias);
    $todas_materias = [];
    while ($materia = mysqli_fetch_assoc($query_todas_materias)) {
        $todas_materias[$materia['cursos_idcursos']][] = $materia;
    }

    // Obtener las materias inscritas por el alumno
    $materias_inscritas = [];
    $sql_materias_inscritas = "SELECT m.idMaterias, m.Nombre, cm.cursos_idcursos 
                               FROM materias m
                               INNER JOIN inscripcion_asignatura ia ON ia.materias_idMaterias = m.idMaterias
                               INNER JOIN cursos_has_materias cm ON cm.materias_idMaterias = m.idMaterias
                               WHERE ia.alumno_legajo = '$legajo'";
    $query_materias_inscritas = mysqli_query($conexion, $sql_materias_inscritas);
    while ($materia = mysqli_fetch_assoc($query_materias_inscritas)) {
        $materias_inscritas[$materia['cursos_idcursos']][] = $materia;
    }

    // Obtener las comisiones
    $sql_comisiones = "SELECT * FROM comisiones";
    $result_comisiones = mysqli_query($conexion, $sql_comisiones);
?>

<form action="guardar_modificacion_alumno.php" method="post" class="formulario">
    <input type="text" name="nombre_alumno" placeholder="Nombre" value="<?php echo $datos['nombre_alumno']; ?>" class="input-text"><br>
    <input type="text" name="apellido_alumno" placeholder="Apellido" value="<?php echo $datos['apellido_alumno']; ?>" class="input-text"><br>
    <input type="number" name="dni_alumno" placeholder="DNI (sin puntos)" value="<?php echo $datos['dni_alumno']; ?>" class="input-text"><br>
    <input type="number" name="celular" placeholder="Celular" value="<?php echo $datos['celular']; ?>" class="input-text"><br>
    <input type="text" name="legajo" id="legajo" placeholder="N° Legajo" value="<?php echo $datos['legajo']; ?>" class="input-text"><br>
    <input type="text" name="edad" placeholder="Edad" value="<?php echo $datos['edad']; ?>" class="input-text"><br>
    <input type="text" name="observaciones" placeholder="Observaciones" value="<?php echo $datos['observaciones']; ?>" class="input-text"><br>
    <input type="text" name="Trabaja_Horario" placeholder="Trabaja_Horario" value="<?php echo $datos['Trabaja_Horario']; ?>" class="input-text"><br>
    <input type="text" name="Año_cursada" placeholder="Año de Cursada" value="<?php echo $datos['año_cursada']; ?>" class="input-text"><br>

    <!-- Select de comisiones -->
    <select name="Comision" class="input-text" required>
        <?php while ($row_comision = mysqli_fetch_assoc($result_comisiones)) { ?>
            <option value="<?php echo $row_comision['idComisiones']; ?>" <?php echo ($row_comision['idComisiones'] == $datos['comisiones_idComisiones']) ? 'selected' : ''; ?>>
                <?php echo $row_comision['N_comicion']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <select id="carreras" name="carreras" class="input-text" required>
        <?php
        $sql_carreras = "SELECT idCarrera, nombre_carrera FROM carreras";
        $result_carreras = $conexion->query($sql_carreras);
        if ($result_carreras->num_rows > 0) {
            while ($row_carrera = $result_carreras->fetch_assoc()) {
                $selected = "";
                $sql_inscripcion = "SELECT 1 FROM inscripcion_asignatura ia
                                    INNER JOIN materias m ON m.idMaterias = ia.materias_idMaterias 
                                    WHERE m.carreras_idCarrera = " . $row_carrera["idCarrera"] . " AND ia.alumno_legajo = '$legajo'";
                $result_inscripcion = $conexion->query($sql_inscripcion);
                if ($result_inscripcion->num_rows > 0) {
                    $selected = "selected";
                }
                echo "<option value='" . $row_carrera["idCarrera"] . "' $selected>" . $row_carrera["nombre_carrera"] . "</option>";
            }
        } else {
            echo "<option value=''>No se encontraron carreras</option>";
        }
        ?>
    </select><br><br>

    <div id="materias-container">
        <!-- Materias de primer año -->
        <div>
            <h3>Materias de Primer Año</h3>
            <div id="materias-primer-ano">
                <?php
                foreach ($todas_materias[1] as $materia) {
                    echo "<select name='materias[1][]' class='form-container__input'>";
                    echo "<option value='0'" . (!isset($materias_inscritas[1]) || !in_array($materia, $materias_inscritas[1]) ? " selected" : "") . ">No cursa</option>";
                    echo "<option value='" . $materia['idMaterias'] . "'" . (isset($materias_inscritas[1]) && in_array($materia, $materias_inscritas[1]) ? " selected" : "") . ">" . $materia['Nombre'] . "</option>";
                    echo "</select><br>";
                }
                ?>
            </div>
        </div>
        <!-- Materias de segundo año -->
        <div>
            <h3>Materias de Segundo Año</h3>
            <div id="materias-segundo-ano">
                <?php
                foreach ($todas_materias[2] as $materia) {
                    echo "<select name='materias[2][]' class='form-container__input'>";
                    echo "<option value='0'" . (!isset($materias_inscritas[2]) || !in_array($materia, $materias_inscritas[2]) ? " selected" : "") . ">No cursa</option>";
                    echo "<option value='" . $materia['idMaterias'] . "'" . (isset($materias_inscritas[2]) && in_array($materia, $materias_inscritas[2]) ? " selected" : "") . ">" . $materia['Nombre'] . "</option>";
                    echo "</select><br>";
                }
                ?>
            </div>
        </div>
        <!-- Materias de tercer año -->
        <div>
            <h3>Materias de Tercer Año</h3>
            <div id="materias-tercer-ano">
                <?php
                foreach ($todas_materias[3] as $materia) {
                    echo "<select name='materias[3][]' class='form-container__input'>";
                    echo "<option value='0'" . (!isset($materias_inscritas[3]) || !in_array($materia, $materias_inscritas[3]) ? " selected" : "") . ">No cursa</option>";
                    echo "<option value='" . $materia['idMaterias'] . "'" . (isset($materias_inscritas[3]) && in_array($materia, $materias_inscritas[3]) ? " selected" : "") . ">" . $materia['Nombre'] . "</option>";
                    echo "</select><br>";
                }
                ?>
            </div>
        </div>
    </div>

    <input type="submit" value="Enviar" name="Enviar" class="btn-enviar">
</form>
<br>
<?php } else { ?>
    <p>Error: ID de alumno no proporcionado.</p>
<?php } ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    function toggleMenu() {
        const navbar = document.querySelector(".navbar");
        navbar.classList.toggle("show-menu");
    }

    document.getElementById("toggle-menu-button").addEventListener("click", toggleMenu);

    document.getElementById("carreras").addEventListener("change", function() {
        var carreraId = this.value;
        cargarMaterias(carreraId, 1, 'materias-primer-ano');
        cargarMaterias(carreraId, 2, 'materias-segundo-ano');
        cargarMaterias(carreraId, 3, 'materias-tercer-ano');
    });

    function cargarMaterias(carreraId, curso, containerId) {
        var container = document.getElementById(containerId);
        container.innerHTML = '';

        if (carreraId && curso) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'ajax_materias_inscripcion.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var materias = JSON.parse(xhr.responseText);
                    materias.forEach(function(materia) {
                        var div = document.createElement('div');

                        var select = document.createElement('select');
                        select.name = 'materias[' + curso + '][]';
                        select.className = 'form-container__input';

                        var optionNoCursa = document.createElement('option');
                        optionNoCursa.value = '0';
                        optionNoCursa.textContent = 'No cursa';
                        select.appendChild(optionNoCursa);

                        var optionMateria = document.createElement('option');
                        optionMateria.value = materia.idMaterias;
                        optionMateria.textContent = materia.Nombre;
                        select.appendChild(optionMateria);

                        div.appendChild(select);
                        container.appendChild(div);
                    });
                }
            };
            xhr.send('carreraId=' + carreraId + '&curso=' + curso);
        }
    }
});
</script>
</body>
</html>

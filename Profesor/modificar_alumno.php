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
        <span class="user-name"><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></span>
    </div>
</nav>

<?php
if (isset($_GET['legajo'])) {
    $legajo = $_GET['legajo'];

    // Consulta preparada para evitar inyección SQL
    $stmt = $conexion->prepare("SELECT * FROM alumno a
                                INNER JOIN inscripcion_asignatura ia ON a.legajo = ia.alumno_legajo
                                WHERE a.legajo = ?");
    $stmt->bind_param("s", $legajo);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos = $result->fetch_assoc();

    // Obtener todas las materias de la carrera del estudiante
    $sql_todas_materias = "SELECT m.idMaterias, m.Nombre, cm.cursos_idcursos, ia.año_cursada
                           FROM materias m
                           INNER JOIN cursos_has_materias cm ON cm.materias_idMaterias = m.idMaterias
                           LEFT JOIN inscripcion_asignatura ia ON ia.materias_idMaterias = m.idMaterias AND ia.alumno_legajo = ?
                           WHERE m.carreras_idCarrera = (SELECT carreras_idCarrera 
                                                         FROM materias 
                                                         WHERE idMaterias = (SELECT materias_idMaterias 
                                                                             FROM inscripcion_asignatura 
                                                                             WHERE alumno_legajo = ? LIMIT 1))";
    $stmt_todas_materias = $conexion->prepare($sql_todas_materias);
    $stmt_todas_materias->bind_param("ss", $legajo, $legajo);
    $stmt_todas_materias->execute();
    $query_todas_materias = $stmt_todas_materias->get_result();
    $todas_materias = [];
    while ($materia = $query_todas_materias->fetch_assoc()) {
        $todas_materias[$materia['cursos_idcursos']][] = $materia;
    }

    // Obtener las materias inscritas por el alumno
    $materias_inscritas = [];
    $sql_materias_inscritas = "SELECT m.idMaterias, m.Nombre, cm.cursos_idcursos, ia.año_cursada
                               FROM materias m
                               INNER JOIN inscripcion_asignatura ia ON ia.materias_idMaterias = m.idMaterias
                               INNER JOIN cursos_has_materias cm ON cm.materias_idMaterias = m.idMaterias
                               WHERE ia.alumno_legajo = ?";
    $stmt_materias_inscritas = $conexion->prepare($sql_materias_inscritas);
    $stmt_materias_inscritas->bind_param("s", $legajo);
    $stmt_materias_inscritas->execute();
    $query_materias_inscritas = $stmt_materias_inscritas->get_result();
    while ($materia = $query_materias_inscritas->fetch_assoc()) {
        $materias_inscritas[$materia['cursos_idcursos']][] = $materia;
    }

    // Obtener las comisiones
    $sql_comisiones = "SELECT * FROM comisiones";
    $result_comisiones = $conexion->query($sql_comisiones);
?>
<form action="guardar_modificacion_alumno.php" method="post" class="formulario">
    <label for="nombre_alumno">Nombre del Alumno:</label>
    <input type="text" name="nombre_alumno" placeholder="Nombre" value="<?php echo htmlspecialchars($datos['nombre_alumno']); ?>" class="input-text"><br>
    
    <label for="apellido_alumno">Apellido del Alumno:</label>
    <input type="text" name="apellido_alumno" placeholder="Apellido" value="<?php echo htmlspecialchars($datos['apellido_alumno']); ?>" class="input-text"><br>
    
    <label for="dni_alumno">DNI del Alumno:</label>
    <input type="number" name="dni_alumno" placeholder="DNI (sin puntos)" value="<?php echo htmlspecialchars($datos['dni_alumno']); ?>" class="input-text"><br>
    
    <label for="celular">Celular del Alumno:</label>
    <input type="number" name="celular" placeholder="Celular" value="<?php echo htmlspecialchars($datos['celular']); ?>" class="input-text"><br>
    
    <label for="legajo">N° Legajo del Alumno:</label>
    <input type="text" name="legajo" id="legajo" placeholder="N° Legajo" value="<?php echo htmlspecialchars($datos['legajo']); ?>" class="input-text"><br>
    
    <label for="edad">Edad del Alumno:</label>
    <input type="text" name="edad" placeholder="Edad" value="<?php echo htmlspecialchars($datos['edad']); ?>" class="input-text"><br>
    
    <label for="observaciones">Observaciones:</label>
    <input type="text" name="observaciones" placeholder="Observaciones" value="<?php echo htmlspecialchars($datos['observaciones']); ?>" class="input-text"><br>
    
    <label for="Trabaja_Horario">Horario de Trabajo:</label>
    <input type="text" name="Trabaja_Horario" placeholder="Trabaja_Horario" value="<?php echo htmlspecialchars($datos['Trabaja_Horario']); ?>" class="input-text"><br>
    
    <label for="Año_cursada">Año de Cursada:</label>
    <input type="text" name="Año_cursada" placeholder="Año de Cursada" value="<?php echo htmlspecialchars($datos['año_cursada']); ?>" class="input-text"><br>

    <!-- Select de comisiones -->
    <label for="Comision">Comisión:</label>
    <select name="Comision" class="input-text" required>
        <?php while ($row_comision = $result_comisiones->fetch_assoc()) { ?>
            <option value="<?php echo htmlspecialchars($row_comision['idComisiones']); ?>" <?php echo ($row_comision['idComisiones'] == $datos['comisiones_idComisiones']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($row_comision['N_comicion']); ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label for="carreras">Carrera:</label>
    <select id="carreras" name="carreras" class="input-text" required>
        <?php
        $sql_carreras = "SELECT idCarrera, nombre_carrera FROM carreras";
        $result_carreras = $conexion->query($sql_carreras);
        if ($result_carreras->num_rows > 0) {
            while ($row_carrera = $result_carreras->fetch_assoc()) {
                $selected = "";
                $sql_inscripcion = "SELECT 1 FROM inscripcion_asignatura ia
                                    INNER JOIN materias m ON m.idMaterias = ia.materias_idMaterias 
                                    WHERE m.carreras_idCarrera = ? AND ia.alumno_legajo = ?";
                $stmt_inscripcion = $conexion->prepare($sql_inscripcion);
                $stmt_inscripcion->bind_param("ss", $row_carrera["idCarrera"], $legajo);
                $stmt_inscripcion->execute();
                $result_inscripcion = $stmt_inscripcion->get_result();
                if ($result_inscripcion->num_rows > 0) {
                    $selected = "selected";
                }
                echo "<option value='" . htmlspecialchars($row_carrera["idCarrera"]) . "' $selected>" . htmlspecialchars($row_carrera["nombre_carrera"]) . "</option>";
            }
        } else {
            echo "<option value=''>No se encontraron carreras</option>";
        }
        ?>
    </select><br><br>

    <div id="materias-container">
    <?php for ($anio = 1; $anio <= 3; $anio++): ?>
        <div>
            <h3>Materias de <?= $anio ?>° Año</h3>
            <div id="materias-<?= $anio ?>-ano">
                <?php
                foreach ($todas_materias[$anio] as $materia) {
                    $año_cursada = isset($materia['año_cursada']) ? " (" . htmlspecialchars($materia['año_cursada']) . ")" : "";

                    // Primer año: input normal
                    if ($anio === 1) {
                        $valorMateria = isset($materias_inscritas[$anio]) && in_array($materia, $materias_inscritas[$anio]) ? htmlspecialchars($materia['Nombre']) . $año_cursada : "No cursa";
                        echo "<input type='text' readonly class='form-container__input' value='$valorMateria'><br>";

                        // Campo hidden para enviar al servidor
                        $idMateria = isset($materias_inscritas[$anio]) && in_array($materia, $materias_inscritas[$anio]) ? htmlspecialchars($materia['idMaterias']) : '0';
                        echo "<input type='hidden' name='materias[$anio][]' value='$idMateria'>";
                    } else {
                        // Segundo y tercer año: readonly
                        $valorMateria = isset($materias_inscritas[$anio]) && in_array($materia, $materias_inscritas[$anio]) ? htmlspecialchars($materia['Nombre']) . $año_cursada : "No cursa";
                        echo "<input type='text' readonly class='form-container__input' value='$valorMateria'><br>";

                        // Campo hidden para enviar al servidor
                        $idMateria = isset($materias_inscritas[$anio]) && in_array($materia, $materias_inscritas[$anio]) ? htmlspecialchars($materia['idMaterias']) : '0';
                        echo "<input type='hidden' name='materias[$anio][]' value='$idMateria'>";
                    }
                }
                ?>
            </div>
        </div>
    <?php endfor; ?>
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
        for (let curso = 1; curso <= 3; curso++) {
            cargarMaterias(carreraId, curso, `materias-${curso}-ano`);
        }
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

<style>
    * Contenedor del área de navegación derecha */
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
</style>
</body>
</html>

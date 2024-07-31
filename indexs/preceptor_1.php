<?php include'../conexion/conexion.php'; ?>
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

// Asume que el ID del profesor se obtiene de la sesión
$profesor_id = $_SESSION['id'];

// Obtener las carreras asociadas al preceptor
$sql_carreras = "SELECT c.idCarrera, c.nombre_carrera 
                 FROM carreras c
                 INNER JOIN preceptores p ON c.idCarrera = p.carreras_idCarrera
                 WHERE p.profesor_idProrfesor = ?";
$stmt_carreras = $conexion->prepare($sql_carreras);
if ($stmt_carreras === false) {
    die('Prepare failed: ' . htmlspecialchars($conexion->error));
}
$stmt_carreras->bind_param('i', $profesor_id);
$stmt_carreras->execute();
$result_carreras = $stmt_carreras->get_result();

$carreras = [];
while ($row = $result_carreras->fetch_assoc()) {
    $carreras[$row['idCarrera']] = $row['nombre_carrera'];
}
$stmt_carreras->close();

// Obtener las carreras, cursos y comisiones asociadas al preceptor
$sql = "SELECT c.idCarrera, c.nombre_carrera, cu.idcursos, cu.nombre_curso, co.idComisiones, co.N_comicion
        FROM carreras c
        INNER JOIN preceptores p ON c.idCarrera = p.carreras_idCarrera
        INNER JOIN cursos cu ON cu.idcursos = p.cursos_idcursos
        INNER JOIN comisiones co ON co.idComisiones = p.comisiones_idComisiones
        WHERE p.profesor_idProrfesor = ?";
$stmt = $conexion->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conexion->error));
}
$stmt->bind_param('i', $profesor_id);
$stmt->execute();
$result = $stmt->get_result();

$menu_data = [];
while ($row = $result->fetch_assoc()) {
    $menu_data[$row['nombre_carrera']][] = [
        'id_curso' => $row['idcursos'],
        'id_carrera' => $row['idCarrera'],
        'id_comision' => $row['idComisiones'],
        'nombre_curso' => $row['nombre_curso'],
        'nombre_comision' => $row['N_comicion']
    ];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGPM-Manuel Salas</title>
    <link rel="stylesheet" type="text/css" href="../estilos.css">
    <link rel="stylesheet" type="text/css" href="./cssinforme.css">
    <link rel="stylesheet" type="text/css" href="../normalize.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .modal-justificados {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.7);
    z-index: 999999;
}

.modal-content-justificados {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 70%;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    animation: animatetop 0.4s;
}

@keyframes animatetop {
    from {top: -300px; opacity: 0}
    to {top: 0; opacity: 1}
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

#tablaJustificados {
    width: 100%;
    border-collapse: collapse;
}

#tablaJustificados th, #tablaJustificados td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

#tablaJustificados th {
    background-color: #4CAF50;
    color: white;
}

#tablaJustificados tr:nth-child(even) {
    background-color: #f2f2f2;
}

#tablaJustificados tr:hover {
    background-color: #ddd;
}
    </style>
</head>
<body>
<div id="success-message" class="success-message" style="display: none;"></div>
<div class="background">

<button class="toggle-menu-button" id="toggle-menu-button" onclick="toggleMenu()">
  <span id="toggle-menu-icon">☰</span>
</button>
<nav class="navbar">
    <div class="nav-left">
        <a href="#" class="home-button" >Menu Principal</a>
        <button class="btn-new-member" id="btn-new-member" >Nuevo Estudiante</button>
        <button class="btn-new-member btn-justificacion" onclick="abrirModalJustificacion()" style="margin-right: 20px;">Justificar Falta</button>
    </div>

    <ul class="nav-options" style="margin-left: 150px;" >
        <li class="dropdown">
            <a href="#" class="dropbtn"> Estudiantes Retirados <i class="fas fa-chevron-down"></i></a>
            <div class="dropdown-content">
                <?php foreach ($menu_data as $nombre_carrera => $cursos_comisiones): ?>
                    <div class="submenu">
                        <a href="#" class="submenu-trigger"><?php echo $nombre_carrera; ?> <i class="fas fa-chevron-right"></i></a>
                        <div class="sub-dropdown-content">
                            <?php foreach ($cursos_comisiones as $cc): ?>
                                <a href="./alumnos_rat.php?id_curso=<?php echo $cc['id_curso']; ?>&id_carrera=<?php echo $cc['id_carrera']; ?>&id_comision=<?php echo $cc['id_comision']; ?>">
                                    <?php echo $nombre_carrera . ' - ' . $cc['nombre_curso'] . ' - ' . $cc['nombre_comision']; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </li>
    </ul>
    
    <ul class="nav-options"  >
        <li class="dropdown">
            <a href="#" class="dropbtn"> Elegir carrera <i class="fas fa-chevron-down"  ></i></a>
            <div class="dropdown-content">
                <?php foreach ($menu_data as $nombre_carrera => $cursos_comisiones): ?>
                    <div class="submenu" >
                        <a href="#" class="submenu-trigger"><?php echo $nombre_carrera; ?> <i class="fas fa-chevron-right"></i></a>
                        <div class="sub-dropdown-content">
                            <?php foreach ($cursos_comisiones as $cc): ?>
                                <a href="./asistencias/asistencia.php?id_curso=<?php echo $cc['id_curso']; ?>&id_carrera=<?php echo $cc['id_carrera']; ?>&id_comision=<?php echo $cc['id_comision']; ?>">
                                    <?php echo $nombre_carrera . ' - ' . $cc['nombre_curso'] . ' - ' . $cc['nombre_comision']; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </li>
    </ul>

    <ul class="nav-options">
        <li class="dropdown">
            <a href="#" class="dropbtn"> Ver asistencia carrera <i class="fas fa-chevron-down"></i></a>
            <div class="dropdown-content">
                <?php foreach ($menu_data as $nombre_carrera => $cursos_comisiones): ?>
                    <div class="submenu">
                        <a href="#" class="submenu-trigger"><?php echo $nombre_carrera; ?> <i class="fas fa-chevron-right"></i></a>
                        <div class="sub-dropdown-content">
                            <?php foreach ($cursos_comisiones as $cc): ?>
                                <a href="./asistencias/ver_asistencia.php?id_curso=<?php echo $cc['id_curso']; ?>&id_carrera=<?php echo $cc['id_carrera']; ?>&id_comision=<?php echo $cc['id_comision']; ?>">
                                    <?php echo $nombre_carrera . ' - ' . $cc['nombre_curso'] . ' - ' . $cc['nombre_comision']; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
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
        <button id="btnMostrarInformesAsistencia" class="boton-informes-asistencia">Informes de Asistencias</button>
        <button id="btnGenerarInformeEstudiantes">Generar Informe Estudiantes</button>
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
            <th>Comisión</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Asume que el ID del profesor se obtiene de la sesión
        $profesor_id = $_SESSION['id'];

        $sql = "SELECT a.legajo, a.nombre_alumno, a.apellido_alumno, a.dni_alumno, a.celular, c3.nombre_carrera, c2.N_comicion
                FROM inscripcion_asignatura ia
                INNER JOIN alumno a ON ia.alumno_legajo = a.legajo
                INNER JOIN materias m ON ia.materias_idMaterias = m.idMaterias
                INNER JOIN cursos c ON ia.cursos_idcursos = c.idcursos
                INNER JOIN comisiones c2 ON ia.comisiones_idComisiones = c2.idComisiones
                INNER JOIN carreras c3 ON m.carreras_idCarrera = c3.idCarrera
                INNER JOIN preceptores p ON p.carreras_idCarrera = m.carreras_idCarrera
                INNER JOIN profesor p2 ON p.profesor_idProrfesor = p2.idProrfesor
                WHERE p2.idProrfesor = ? AND a.estado = 1
                GROUP BY a.legajo, c3.nombre_carrera, c2.N_comicion";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('i', $profesor_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($datos = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $datos['legajo']; ?></td>
            <td><?php echo $datos['apellido_alumno']; ?></td>
            <td><?php echo $datos['nombre_alumno']; ?></td>
            <td><?php echo $datos['dni_alumno']; ?></td>
            <td><?php echo $datos['celular']; ?></td>
            <td><?php echo $datos['nombre_carrera']; ?></td>
            <td><?php echo $datos['N_comicion']; ?></td>
            <td>
                <a href="../Profesor/modificar_alumno.php?legajo=<?php echo $datos['legajo']; ?>" class="modificar-button"><i class="fas fa-pencil-alt"></i></a>
                <a href="#" onclick="return confirmarBorrado('<?php echo $datos['legajo']; ?>')" class="borrar-button"><i class="fas fa-trash-alt"></i></a>
                <a href="../Profesor/porcentajes_de_asistencia.php?legajo=<?php echo $datos['legajo']; ?>" class="accion-button"><i class="fas fa-exclamation"></i></a>
            </td>
        </tr>
        <?php
        }
        $stmt->close();
        ?>
    </tbody>
</table>
        </div>
    </div>
</div>


<div id="modalInformesAsistencia" class="modal-informes-asistencia" style="display: none; position: fixed; z-index: 155555555555; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content-informes-asistencia" style="background-color: rgba(255, 255, 255, 0.9); margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);">
        <span class="cerrar-modal-informes-asistencia">&times;</span>
        <h2>Generar Informe de Asistencias</h2>
        <br>
        <form action="generar_excel.php" method="post">
        <label for="selectCarreraAsistencias">Selecciona una carrera, curso y comisión:</label>
    <select id="selectCarreraAsistencias" name="carrera_curso_comision" class="form-input-informes">
        <option hidden>Selecciona una opción</option>
        <!-- Opciones se llenarán dinámicamente -->
    </select>
    <br><br>
    
    <input type="hidden" id="cursoHiddenAsistencias" name="curso" value="">
    <input type="hidden" id="comisionHiddenAsistencias" name="comision" value="">
    
    <label for="fecha_inicio">Fecha de inicio:</label><br>
    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-input-informes" required>
    <br><br>

    <label for="fecha_fin">Fecha de fin:</label><br>
    <input type="date" id="fecha_fin" name="fecha_fin" class="form-input-informes" required>
    <br><br>

    <input type="submit" value="Generar PDF de Asistencias" class="boton-submit-informes">
        </form>
    </div>
</div>



<div id="modal" class="modal">
    <div class="modal-content" style="text-align: left;">
        <span class="close" onclick="closeModal()">&times;</span>
        <?php include '../Profesor/estudiante/guardar_estudiante.php'; ?>
        <h2 class="form-container__h2">Registro de Estudiante</h2>
        <form action="" method="post" style="text-align: left;">
            <label for="nombre_alu">Nombre:</label>
            <input type="text" id="nombre_alu" class="form-container__input" name="nombre_alu" placeholder="Ingrese el nombre" autocomplete="off" required>
            
            <label for="apellido_alu">Apellido:</label>
            <input type="text" id="apellido_alu" class="form-container__input" name="apellido_alu" placeholder="Ingrese el apellido" autocomplete="off" required>
            
            <label for="dni_alu">DNI:</label>
            <input type="number" id="dni_alu" class="form-container__input" name="dni_alu" placeholder="Ingrese el DNI" autocomplete="off" required>
            
            <label for="celular">Celular:</label>
            <input type="number" id="celular" class="form-container__input" name="celular" placeholder="Ingrese el celular" autocomplete="off">
            
            <?php
            $sql_legajo = "SELECT MAX(legajo) AS max_legajo FROM alumno";
            $resultado_legajo = $conexion->query($sql_legajo);
            $fila_legajo = $resultado_legajo->fetch_assoc();
            $nuevo_legajo = $fila_legajo['max_legajo'] + 1;
            ?>
            <label for="legajo">N° Legajo:</label>
            <input type="text" id="legajo" name="legajo" placeholder="N° Legajo" value="<?php echo $nuevo_legajo; ?>" class="form-container__input">
            
            <label for="edad">Fecha de Nacimiento:</label>
            <input type="date" id="edad" class="form-container__input" name="edad" placeholder="Ingrese fecha de nacimiento" autocomplete="off">
            
            <label for="observaciones">Observaciones:</label>
            <input type="text" id="observaciones" class="form-container__input" name="observaciones" placeholder="Observaciones" autocomplete="off" required>
            
            <label for="Trabajo_Horario">Trabajo / Horario:</label>
            <input type="text" id="Trabajo_Horario" class="form-container__input" name="Trabajo_Horario" placeholder="Trabajo / Horario" autocomplete="off" required>
            
            <?php
            $sql_carreras = "SELECT * FROM carreras WHERE idCarrera in ('18','27','46','55')";
            $peticion = mysqli_query($conexion, $sql_carreras);
            ?>
            <label for="inscripcion_carrera">Carrera:</label>
            <select name="inscripcion_carrera" id="inscripcion_carrera" class="form-container__input">
    <option hidden>Selecciona una carrera</option>
    <?php foreach ($carreras as $idCarrera => $nombreCarrera) { ?>
        <option value="<?php echo $idCarrera; ?>"><?php echo $nombreCarrera; ?></option>
    <?php } ?>
</select>
            
            <?php
            $sql_comision = "SELECT c.idComisiones,c.N_comicion FROM comisiones c";
            $resultado_comision = $conexion->query($sql_comision);
            ?>
            <label for="Comision">Comisión:</label>
            <select name="Comision" id="Comision" class="form-container__input">
                <option hidden>Selecciona una Comisión</option>
                <?php while ($rowcomision = mysqli_fetch_assoc($resultado_comision)) { ?>
                <option value="<?php echo $rowcomision['idComisiones']; ?>"><?php echo $rowcomision['N_comicion']; ?></option>
                <?php } ?>
            </select>
            
            <label for="Año_inscripcion">Año de Inscripción:</label>
            <select name="Año_inscripcion" id="Año_inscripcion" class="form-container__input">
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2033">2033</option>
                <option value="2034">2034</option>
            </select>
            
            <input type="submit" class="form-container__input" name="enviar" value="Enviar" onclick="mostrarAlertaExitosa(); closeSuccessMessage();">
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
                    // Consulta SQL para obtener los datos
                    $sql1 = "SELECT a2.nombre_alumno, a2.apellido_alumno, a2.legajo, p.nombre_profe, c.nombre_carrera, m.Nombre AS nombre_materia, a.fecha, a.motivo
                             FROM alumnos_rat a
                             INNER JOIN alumno a2 ON a2.legajo = a.alumno_legajo
                             INNER JOIN carreras c ON c.idCarrera = a.carreras_idCarrera
                             INNER JOIN profesor p ON a.profesor_idProrfesor = p.idProrfesor 
                             INNER JOIN materias m ON a.materias_idMaterias = m.idMaterias
                             WHERE p.idProrfesor = {$_SESSION['id']}";

                    $query1 = mysqli_query($conexion, $sql1);

                    // Verificar si la consulta fue exitosa
                    if ($query1) {
                        while ($datos = mysqli_fetch_assoc($query1)) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($datos['apellido_alumno']); ?></td>
                                <td><?php echo htmlspecialchars($datos['nombre_alumno']); ?></td>
                                <td><?php echo htmlspecialchars($datos['legajo']); ?></td>
                                <td><?php echo htmlspecialchars($datos['nombre_profe']); ?></td>
                                <td><?php echo htmlspecialchars($datos['nombre_carrera']); ?></td>
                                <td><?php echo htmlspecialchars($datos['nombre_materia']); ?></td>
                                <td><?php echo htmlspecialchars($datos['motivo']); ?></td>
                                <td><?php echo htmlspecialchars($datos['fecha']); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        // Mostrar un mensaje de error si la consulta falla
                        echo "<tr><td colspan='8'>Error: " . mysqli_error($conexion) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<button id="btnOpenModalJustificados">Ver Alumnos Justificados</button>

<div id="modalJustificados" class="modal-justificados">
    <div class="modal-content-justificados">
        <span class="close" id="closeJustificados">&times;</span>
        <div id="modalBodyJustificados">
            <table id="tablaJustificados">
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
                    // Consulta SQL para obtener los datos de los alumnos justificados
                    $sql_justificados = "SELECT a2.nombre_alumno, a2.apellido_alumno, a2.legajo, p.nombre_profe, c.nombre_carrera, m.Nombre AS nombre_materia, a.fecha, a.motivo
                                         FROM alumnos_justificados a
                                         INNER JOIN alumno a2 ON a2.legajo = a.alumno_legajo
                                         INNER JOIN carreras c ON c.idCarrera = a.carreras_idCarrera
                                         INNER JOIN profesor p ON a.profesor_idProrfesor = p.idProrfesor 
                                         INNER JOIN materias m ON a.materias_idMaterias = m.idMaterias
                                         WHERE p.idProrfesor = {$_SESSION['id']}";

                    $query_justificados = mysqli_query($conexion, $sql_justificados);

                    // Verificar si la consulta fue exitosa
                    if ($query_justificados) {
                        while ($datos_justificados = mysqli_fetch_assoc($query_justificados)) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($datos_justificados['apellido_alumno']); ?></td>
                                <td><?php echo htmlspecialchars($datos_justificados['nombre_alumno']); ?></td>
                                <td><?php echo htmlspecialchars($datos_justificados['legajo']); ?></td>
                                <td><?php echo htmlspecialchars($datos_justificados['nombre_profe']); ?></td>
                                <td><?php echo htmlspecialchars($datos_justificados['nombre_carrera']); ?></td>
                                <td><?php echo htmlspecialchars($datos_justificados['nombre_materia']); ?></td>
                                <td><?php echo htmlspecialchars($datos_justificados['motivo']); ?></td>
                                <td><?php echo htmlspecialchars($datos_justificados['fecha']); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        // Mostrar un mensaje de error si la consulta falla
                        echo "<tr><td colspan='8'>Error: " . mysqli_error($conexion) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php

 ?>
 <!-- Modal para generar informe de estudiantes -->
 <div id="modal-lista-estudiantes" class="modal-lista-estudiantes" style="display: none; position: fixed; z-index: 155555555555; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content-lista-estudiantes" style="background-color: rgba(255, 255, 255, 0.9); margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);">
        <span class="cerrar-modal-lista-estudiantes">&times;</span>
        <h2>Generar Informe de Estudiantes</h2>
        <br>
        <form action="generar_exel_alumnos.php" method="post">
            <label for="selectCarreraEstudiantes">Selecciona una carrera, curso y comisión:</label>
            <select id="selectCarreraEstudiantes" name="carrera_curso_comision" class="form-input-informes">
                <option hidden>Selecciona una opción</option>
                <!-- Opciones se llenarán dinámicamente -->
            </select>
            <br><br>

            <input type="hidden" id="cursoHiddenEstudiantes" name="curso" value="">
            <input type="hidden" id="comisionHiddenEstudiantes" name="comision" value="">

            <input type="submit" value="Generar Lista de Estudiantes" class="boton-submit-informes">
        </form>
    </div>
</div>


<div class="modal-justificacion">
  <div class="modal-content-justificacion">
    <span class="close-justificacion" onclick="cerrarModalJustificacion()">×</span>
    <h2 class="form-container__h2">Justificar Falta</h2>
    <form action="guardar_falta_justificada.php" id="miFormularioJustificados" method="post">
    <label for="nombre_alu">Filtro estudiante:</label>
      <input type="text" name="filtroAlumno" id="filtroAlumnoJustificado" placeholder="Filtrar por nombre, apellido o legajo de alumno" class="form-container__input">
      <label for="nombre_alu">Selecciona alumno:</label>
      <select name="selectAlumnoJustificado" id="selectAlumnoJustificado" class="form-container__input">
          <option value="" selected>Seleccionar alumno</option>
      </select>
      <label for="nombre_alu">Materia 1:</label>
      <select id="selectMateriaJustificada1" name="materia1" class="form-container__input">
        <option value="">Seleccione Primera Materia</option>
      </select>
      <label>Materia 2:</label>
      <select id="selectMateriaJustificada2" name="materia2" class="form-container__input">
        <option value="">Seleccione Segunda Materia</option>
      </select>
      <input type="hidden" id="carreraJustificada" name="carrera" value="">
      <input type="hidden" id="cursoJustificado" name="curso" value="">
      <input type="hidden" id="comisionJustificada" name="comision" value="">
      <input type="hidden" name="profesor" value="<?php echo $_SESSION["id"]; ?>">
      <label>Motivo:</label>
      <input type="text" name="motivo" placeholder="Motivo de Falta Justificada" class="form-container__input">
      <label>Fecha Falta:</label>
      <input type="date" name="fecha" id="fechaJustificados" class="form-container__input">
      <input type="submit" class="form-container__input" name="enviar" value="Confirmar">
    </form>
  </div>
</div>



<div class="nav-welcome-container">

<div id="welcome-box" class="welcome-box">
  <h1 class="welcome-box__h1">Bienvenido</h1>
  <p class="welcome-box__p">¡Prec. <?php  echo $_SESSION['nombre']; ?>  <?php  echo $_SESSION['apellido'] ?>!</p>
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

// Escucha el evento 'keydown' en el documento
document.addEventListener('keydown', function(event) {
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
        tuFormulario.addEventListener("submit", function(event) {
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

// DataTables de Alumnos
var myTable = document.querySelector("#tabla");
var dataTable = new DataTable(tabla);
  
function confirmarBorrado(legajo) {
    var respuesta = confirm("¿Estás seguro de que quieres borrar este alumno?");
    if (respuesta) {
        // Realizar el borrado lógico directamente sin redirección previa
        window.location.href = "../Profesor/Borrado_logico_alumno.php?legajo=" + legajo;
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

// Obtener el modal para Estudiantes Retirados antes de tiempo
var modalTiempo = document.getElementById("modalRetiradosTiempo");

// Obtener el botón que abre el modal de Estudiantes Retirados antes de tiempo
var btnTiempo = document.getElementById("btnOpenModalRetiradosTiempo");

// Obtener el elemento <span> que cierra el modal de Estudiantes Retirados antes de tiempo
var spanTiempo = document.getElementById("closeRetiradosTiempo");

// Al hacer clic en el botón, abrir el modal de Estudiantes Retirados antes de tiempo
btnTiempo.onclick = function() {
  modalTiempo.style.display = "block";
}

// Al hacer clic en <span> (x), cerrar el modal de Estudiantes Retirados antes de tiempo
spanTiempo.onclick = function() {
  modalTiempo.style.display = "none";
}

// También cierra el modal si el usuario hace clic fuera de él
window.onclick = function(event) {
  if (event.target == modalTiempo) {
    modalTiempo.style.display = "none";
  }
}

//--------------------PDF alumno ---------------------------//

document.addEventListener('DOMContentLoaded', function() {
    var data = <?php echo json_encode($menu_data); ?>;
    console.log("Datos cargados:", data);

    var modalListaEstudiantes = document.getElementById('modal-lista-estudiantes');
    var closeListaEstudiantesModal = document.querySelector('.cerrar-modal-lista-estudiantes');
    var btnGenerarInformeEstudiantes = document.getElementById('btnGenerarInformeEstudiantes');

    // Abrir el modal de lista de estudiantes
    btnGenerarInformeEstudiantes.onclick = function() {
        console.log("Botón clickeado");
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

    var selectCarrera = document.getElementById('selectCarrera');
    var cursoHidden = document.getElementById('cursoHidden');
    var comisionHidden = document.getElementById('comisionHidden');

    selectCarrera.addEventListener('change', function() {
        var selectedCarrera = this.value.trim();
        selectCarrera.innerHTML = '<option hidden>Selecciona un curso y comisión</option>';

        if (data[selectedCarrera]) {
            var opciones = data[selectedCarrera];
            opciones.forEach(function(opcion) {
                var option = document.createElement('option');
                option.value = opcion.id_curso + '-' + opcion.id_comision; // Concatenar ids
                option.textContent = opcion.nombre_carrera + ' - ' + opcion.nombre_curso + ' - ' + opcion.nombre_comision;
                selectCarrera.appendChild(option);
            });
        } else {
            console.log('No se encontraron datos para la carrera seleccionada.');
        }
    });

    selectCarrera.addEventListener('change', function() {
        var selectedOption = this.value;
        var [idCurso, idComision] = selectedOption.split('-');
        cursoHidden.value = idCurso;
        comisionHidden.value = idComision;
    });
});


$(document).ready(function() {
    // Función para actualizar el selector de alumnos
    function actualizarSelectAlumnos(alumnos) {
        var selectAlumno = $('#selectAlumnoJustificado');
        selectAlumno.empty(); // Vaciar el select para llenarlo de nuevo

        // Agregar la opción por defecto
        selectAlumno.append('<option value="" selected>Seleccionar alumno</option>');

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
    $('#filtroAlumnoJustificado').on('input', function() {
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
                var carreraHidden = $('#carreraJustificada');
                if (response.alumnos.length > 0) {
                    carreraHidden.val(response.alumnos[0].carreras_idCarrera);
                } else {
                    carreraHidden.val(''); // Si no hay alumnos, vaciar el valor del input hidden
                }
                limpiarSelectMaterias(); // Limpiar el selector de materias hasta que se seleccione un alumno
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Función para actualizar el selector de materias
    function actualizarSelectMaterias(legajoAlumno) {
        $.ajax({
            url: 'obtener_materias.php',
            method: 'POST',
            data: { legajo: legajoAlumno },
            dataType: 'json',
            success: function(response) {
                var selectMateria1 = $('#selectMateriaJustificada1');
                var selectMateria2 = $('#selectMateriaJustificada2');
                selectMateria1.empty(); // Vaciar el select para llenarlo de nuevo
                selectMateria2.empty(); // Vaciar el select para llenarlo de nuevo

                // Agregar una opción por cada materia recibida
                response.materias.forEach(function(materia) {
                    var option = $('<option>', {
                        value: materia.idMaterias,
                        text: materia.Nombre
                    });
                    selectMateria1.append(option.clone());
                    selectMateria2.append(option.clone());
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Función para limpiar el selector de materias
    function limpiarSelectMaterias() {
        var selectMateria1 = $('#selectMateriaJustificada1');
        var selectMateria2 = $('#selectMateriaJustificada2');
        selectMateria1.empty(); // Vaciar el select
        selectMateria2.empty(); // Vaciar el select
        selectMateria1.append('<option value="">Seleccione Primera Materia</option>'); // Agregar la opción por defecto
        selectMateria2.append('<option value="">Seleccione Segunda Materia</option>'); // Agregar la opción por defecto
    }

    // Evento change para el select de alumno para justificación
    $('#selectAlumnoJustificado').change(function() {
        // Obtener el valor seleccionado en el select de alumno
        var legajoAlumno = $(this).val();

        if (legajoAlumno) {
            // Enviar una solicitud AJAX para obtener el curso y la comisión del alumno
            $.ajax({
                url: 'obtener_curso_comision.php', // Ruta al script PHP que obtiene los datos
                method: 'POST',
                data: { legajo: legajoAlumno }, // Datos a enviar al servidor
                dataType: 'json', // Especificar que esperamos datos JSON en la respuesta
                success: function(response) {
                    // Rellenar los campos ocultos con los valores obtenidos
                    $('#cursoJustificado').val(response.curso);
                    $('#comisionJustificada').val(response.comision);
                    $('#carreraJustificada').val(response.carrera);
                    
                    // Llamar a la función para actualizar el selector de materias
                    actualizarSelectMaterias(legajoAlumno);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            limpiarSelectMaterias();
        }
    });

    // Evento change para los selectores de materia para justificación
    $('#selectMateriaJustificada1, #selectMateriaJustificada2').change(function() {
        // Obtener el valor seleccionado en el select de materia
        var materia = $(this).val();

        // Enviar una solicitud AJAX para obtener la carrera de la materia
        $.ajax({
            url: 'obtener_carrera_materia.php', // Ruta al script PHP que obtiene la carrera de la materia
            method: 'POST',
            data: { materia: materia }, // Datos a enviar al servidor
            dataType: 'json', // Especificar que esperamos datos JSON en la respuesta
            success: function(response) {
                // Rellenar el campo oculto de carrera con el valor obtenido
                $('#carreraJustificada').val(response.carrera);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

function abrirModalJustificacion() {
  document.getElementsByClassName("modal-justificacion")[0].style.display = "block";
}

function cerrarModalJustificacion() {
  document.getElementsByClassName("modal-justificacion")[0].style.display = "none";
}


// Obtener el modal
var modalJustificados = document.getElementById("modalJustificados");

// Obtener el botón que abre el modal
var btnJustificados = document.getElementById("btnOpenModalJustificados");

// Obtener el elemento que cierra el modal
var spanJustificados = document.getElementById("closeJustificados");

// Cuando el usuario hace clic en el botón, abrir el modal
btnJustificados.onclick = function() {
  modalJustificados.style.display = "block";
}

// Cuando el usuario hace clic en (x), cerrar el modal
spanJustificados.onclick = function() {
  modalJustificados.style.display = "none";
}

// También cierra el modal si el usuario hace clic fuera de él
window.onclick = function(event) {
  if (event.target == modalJustificados) {
    modalJustificados.style.display = "none";
  }
}


//------------------------------------PDF Asistewncia---------------------------------------//
$(document).ready(function() {
    function cargarDatos(selectId, hiddenCursoId, hiddenComisionId) {
        var selectCarrera = $(selectId);

        $.ajax({
            url: 'obtener_ccc_informe.php', 
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                console.log(data);
                selectCarrera.html('<option hidden>Selecciona una opción</option>');
                
                if (data.length > 0) {
                    data.forEach(function(opcion) {
                        var option = $('<option></option>');
                        option.val(opcion.idCarrera + '-' + opcion.idCurso + '-' + opcion.idComision);
                        option.text(opcion.nombreCarrera + ' - ' + opcion.nombreCurso + ' - ' + opcion.nombreComision);
                        selectCarrera.append(option);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar los datos:', error);
                console.log(xhr.responseText);
            }
        });

        selectCarrera.on('change', function() {
            var valorSeleccionado = $(this).val();
            var ids = valorSeleccionado.split('-');

            if (ids.length === 3) {
                var idCurso = ids[1];
                var idComision = ids[2];

                $(hiddenCursoId).val(idCurso);
                $(hiddenComisionId).val(idComision);
                
                // Depurar valores
                console.log("Curso ID: " + idCurso);
                console.log("Comisión ID: " + idComision);
            }
        });
    }

    cargarDatos('#selectCarreraAsistencias', '#cursoHiddenAsistencias', '#comisionHiddenAsistencias');
    cargarDatos('#selectCarreraEstudiantes', '#cursoHiddenEstudiantes', '#comisionHiddenEstudiantes');
});


</script>
</body>
</html>

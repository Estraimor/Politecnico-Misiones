<?php
session_start();
if (empty($_SESSION["id"])) { header('Location: ./login/login.php'); }

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
<?php include './conexion/conexion.php'; ?>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<div id="success-message" class="success-message" style="display: none;"></div>
<div class="background">

<button class="toggle-menu-button" id="toggle-menu-button" onclick="toggleMenu()">
  <span id="toggle-menu-icon">☰</span>
</button>
<nav class="navbar">
<<<<<<< HEAD
    <div class="nav-left">  
        <a href="index.php" class="home-button">Inicio</a>
        <button class="btn-new-member" id="btn-new-member">Nuevo Estudiante</button>
        <button class="btn-new-member" id="btnOpenNewStudentFP">Nuevo Estudiante FP</button>
        <button class="btn-situacion-academica">
            <a href="../proximamente/proximamente.php" class="btn-link">Situación Académica</a>
        </button>
        <button class="btn-inscripcion" id="btnInscripcionSegundoAnio">Inscripción Segundo/Tercer Año</button>
        <button class="">
            <a href="./preceptores.php">Preceptores</a>
        </button>
        <button class="btn-preceptores">
            <a href="../proximamente/proximamente.php">Profesores</a>
        </button>
    </div>
    <div class="nav-right">
        <a href="./login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
=======
          <div class="nav-left">  
            <a href="index.php" class="home-button">Inicio</a>
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
        <a href=" ./login/cerrar_sesion.php " class="btn-logout">Cerrar sesión</a>
>>>>>>> d2c92b420cc9dede6771cec92458be6611ce8fcb
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
                        <th>Comision</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql1 = "SELECT a.apellido_alumno,a.nombre_alumno,a.dni_alumno,a.legajo,a.celular,c.nombre_carrera,c2.N_comicion FROM inscripcion_asignatura ia 
                    INNER JOIN alumno a on ia.alumno_legajo = a.legajo 
                    INNER JOIN materias m on ia.materias_idMaterias = m.idMaterias
                    INNER JOIN carreras c on m.carreras_idCarrera = c.idCarrera
                    INNER JOIN comisiones c2 on ia.comisiones_idComisiones = c2.idComisiones
                    WHERE  a.estado = '1'
                    GROUP BY a.legajo";
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
                        <td><?php echo $datos['N_comicion']; ?></td>
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
<!-- Modal para la tabla de estudiantes FP -->
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
                        <th class="ths">Carrera</th>
                        <th class="ths">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql1 = "SELECT af.nombre_afp, af.apellido_afp, af.legajo_afp, af.dni_afp, af.celular_afp,c.nombre_carrera
                            FROM alumnos_fp af
                            INNER JOIN alumnos_fp_has_carreras afc on af.legajo_afp = afc.alumnos_fp_legajo_afp
                            INNER JOIN carreras c on c.idCarrera = afc.carreras_idCarrera
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
                        <td><?php echo $datos['nombre_carrera']; ?></td>
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

 <!-- Modal de inscripción para segundo año -->
<div id="inscripcionSegundoAnioModal" class="estudiantes-modal" style="display: none;">
    <div class="modal-content-estudiantes">
        <span class="modal-close-estudiantes close-modal-button" id="closeInscripcionSegundoAnioModal">&times; Cerrar</span>
        <h2>Registro de Inscripción para Segundo Y Tercer Año</h2>
        <form id="formInscripcion">
            <input type="text" name="legajo" placeholder="N° Legajo" class="form-container__input" required>
            <input type="text" name="nombre" class="form-container__input" readonly>

            <select name="carrera" id="carreraSelect" class="form-container__input" required>
                <option hidden>Selecciona Carrera</option>
                <?php
                $sql_carreras = "SELECT * FROM carreras WHERE idCarrera in (18, 27, 46, 55)";
                $result_carreras = mysqli_query($conexion, $sql_carreras);
                while ($row = mysqli_fetch_assoc($result_carreras)) {
                    echo "<option value='{$row['idCarrera']}'>{$row['nombre_carrera']}</option>";
                }
                ?>
            </select>

            <select name="curso" id="cursoSelect" class="form-container__input" required>
                <option hidden>Selecciona Curso</option>
                <option value="2">Segundo Año</option>
                <option value="3">Tercer Año</option>
            </select>

            <div id="materias-container">
                <!-- Los selects de materias se agregarán aquí mediante JavaScript -->
            </div>

            <select name="comision" class="form-container__input" required>
                <option hidden>Selecciona Comisión</option>
                <?php
                $sql_comision = "SELECT * FROM comisiones";
                $result_comision = mysqli_query($conexion, $sql_comision);
                while ($row = mysqli_fetch_assoc($result_comision)) {
                    echo "<option value='{$row['idComisiones']}'>{$row['N_comicion']}</option>";
                }
                ?>
            </select>

            <select name="año_inscripcion" id="año_inscripcion" class="form-container__input" required>
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

            <input type="submit" name="enviar" value="Inscribir" class="form-container__input">
        </form>
    </div>
</div>


<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <?php include './Profesor/estudiante/guardar_estudiante.php'; ?>
        <h2 class="form-container__h2">Registro de Estudiante</h2>
        <form action="" method="post">
            <input type="text" class="form-container__input" name="nombre_alu" placeholder="Ingrese el nombre" autocomplete="off" required>
            <input type="text" class="form-container__input" name="apellido_alu" placeholder="Ingrese el apellido" autocomplete="off" required>
            <input type="number" class="form-container__input" name="dni_alu" placeholder="Ingrese el DNI" autocomplete="off" required>
            <input type="number" class="form-container__input" name="celular" placeholder="Ingrese el celular" autocomplete="off">
            <?php
            $sql_legajo = "SELECT MAX(legajo) AS max_legajo FROM alumno";
            $resultado_legajo = $conexion->query($sql_legajo);
            $fila_legajo = $resultado_legajo->fetch_assoc();
            $nuevo_legajo = $fila_legajo['max_legajo'] + 1;
            ?>
            <input type="text" name="legajo" placeholder="N° Legajo" value="<?php echo $nuevo_legajo; ?>" class="form-container__input">
            <input type="date" class="form-container__input" name="edad" placeholder="Ingrese fecha de nacimiento" autocomplete="off">
            <input type="text" class="form-container__input" name="observaciones" placeholder="Observaciones" autocomplete="off" required>
            <input type="text" class="form-container__input" name="Trabajo_Horario" placeholder="Trabajo / Horario" autocomplete="off" required>
            <?php
            $sql_carreras = "SELECT * FROM carreras WHERE idCarrera in ('18','27','46','55')";
            $peticion = mysqli_query($conexion, $sql_carreras);
            ?>
            <select name="inscripcion_carrera" id="inscripcion_carrera" class="form-container__input">
                <option hidden>Selecciona una carrera</option>
                <?php while ($row = mysqli_fetch_assoc($peticion)) { ?>
                <option value="<?php echo $row['idCarrera']; ?>"><?php echo $row['nombre_carrera']; ?></option>
                <?php } ?>
            </select>
            <?php
            $sql_comision = "SELECT c.idComisiones,c.N_comicion FROM comisiones c";
            $resultado_comision = $conexion->query($sql_comision);
            ?>
            <select name="Comision" id="Comision"  class="form-container__input">
                <option hidden>Selecciona una Comision</option>
                <?php while ($rowcomision = mysqli_fetch_assoc($resultado_comision)) { ?>
                <option value="<?php echo $rowcomision['idComisiones']; ?>"><?php echo $rowcomision['N_comicion']; ?></option>
                <?php } ?>
            </select>
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
            $sql_mater = "SELECT * 
                        FROM preceptores p 
                        INNER JOIN carreras c on p.carreras_idCarrera = c.idCarrera";
            $peticion = mysqli_query($conexion, $sql_mater);
            ?>
            <select name="carrera" class="form-input-informes">
                <option hidden>Selecciona una carrera</option>
                <?php while ($informacion = mysqli_fetch_assoc($peticion)) { ?>
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
            INNER JOIN carreras c on c.idCarrera = p.carreras_idCarrera";
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
            INNER JOIN carreras c on c.idCarrera = p.carreras_idCarrera";
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
    <div class="modal-content-student-fp">
        <?php
        $sql_carreras = "SELECT * FROM carreras c WHERE c.idCarrera IN ('8','14','15','64','65')";
        $resultado_carreras = mysqli_query($conexion, $sql_carreras);
        $carreras = array();
        while ($informacion_carrera = mysqli_fetch_assoc($resultado_carreras)) {
            $carreras[] = $informacion_carrera;
        }
        ?>
        <span class="close-student-fp">&times;</span>
        <form action="./FP/ABM_FP/guardar_alumnofp.php" method="post">
            <h2>Registro de FP</h2>
            <?php
            $sql_legajo = "SELECT MAX(legajo_afp) AS max_legajo FROM alumnos_fp";
            $resultado_legajo = $conexion->query($sql_legajo);
            $fila_legajo = $resultado_legajo->fetch_assoc();
            $nuevo_legajo = $fila_legajo['max_legajo'] + 1;
            ?>
            <input type="text" name="legajo" placeholder="N° Legajo" value="<?php echo $nuevo_legajo; ?>" class="form-container__input">
            <input type="text" name="nombre" placeholder="Nombre" class="form-container__input" autocomplete="off">
            <input type="text" name="apellido" placeholder="Apellido" class="form-container__input" autocomplete="off">
            <input type="number" name="dni" placeholder="DNI" class="form-container__input" autocomplete="off">
            <input type="number" name="celular" placeholder="Celular" class="form-container__input" autocomplete="off">
            <input type="text" name="observaciones" placeholder="Observaciones" class="form-container__input" autocomplete="off">
            <input type="text" name="trabaja" placeholder="Trabaja" class="form-container__input" autocomplete="off">
            
            <select name="FP1" class="form-container__input">
                <option value="" hidden selected>Selecciona una carrera</option>
                <?php foreach ($carreras as $carrera) {
                    if ($carrera['idCarrera'] != '65') { ?>
                        <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
                <?php }
                } ?>
            </select>
            <select name="FP2" class="form-container__input">
                <option value="" hidden selected>Selecciona una carrera</option>
                <?php foreach ($carreras as $carrera) {
                    if ($carrera['idCarrera'] != '65') { ?>
                        <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
                <?php }
                } ?>
            </select>
            <select name="FP3" class="form-container__input">
                <option value="" hidden selected>Selecciona una carrera</option>
                <?php foreach ($carreras as $carrera) {
                    if ($carrera['idCarrera'] != '65') { ?>
                        <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
                <?php }
                } ?>
            </select>
            <select name="FP4" class="form-container__input">
                <option value="" hidden selected>Selecciona una carrera</option>
                <?php foreach ($carreras as $carrera) {
                    if ($carrera['idCarrera'] != '65') { ?>
                        <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
                <?php }
                } ?>
            </select>
            
            <input type="submit" name="enviar" value="Enviar" class="form-container__input">
        </form>
    </div>
</div>


<script>
function toggleMenu() {
    const navbar = document.querySelector(".navbar");
    navbar.classList.toggle("show-menu");
}

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

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        var estudianteModal = document.getElementById('modal');
        if (estudianteModal.style.display === 'block') {
            closeModal();
        }
        var materiaModal = document.getElementById('materia-modal');
        if (materiaModal.style.display === 'block') {
            closeMateriaModal();
        }
    }
});

document.addEventListener("DOMContentLoaded", function() {
    console.log("Script cargado");

    var tuFormulario = document.getElementById("tu-formulario");
    if (tuFormulario) {
        tuFormulario.addEventListener("submit", function (event) {
            event.preventDefault();
            var envioExitoso = true;
            if (envioExitoso) {
                document.getElementById("envio-exitoso").value = "1";
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

var myTable = document.querySelector("#tablaFP");
var dataTable = new DataTable(tablaFP);

function confirmarBorrado(legajo) {
    var respuesta = confirm("¿Estás seguro de que quieres borrar este alumno?");
    if (respuesta) {
        window.location.href = "./Profesor/Borrado_logico_alumno.php?legajo=" + legajo;
    }
    return false;
}

function nombreNuevo(legajo) {
    var respuesta = confirm("¿Estás seguro de que quieres borrar este alumno?");
    if (respuesta) {
        window.location.href = "./FP/ABM_FP/Borrado_logico_AFP.php?legajo=" + legajo;
    }
    return false;
}

document.addEventListener('DOMContentLoaded', function() {
    var modalEstudiantes = document.getElementById('estudiantesModal');
    var btnImprimirListaEstudiantes = document.getElementById('btnImprimirListaEstudiantes');
    var modalListaEstudiantes = document.getElementById('modal-lista-estudiantes');
    var closeListaEstudiantesModal = document.getElementById('closeListaEstudiantesModal');

    btnImprimirListaEstudiantes.onclick = function() {
        modalEstudiantes.style.display = "none";
        modalListaEstudiantes.style.display = "block";
    }

    closeListaEstudiantesModal.onclick = function() {
        modalListaEstudiantes.style.display = "none";
    }

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
    var welcomeBox = document.getElementById('welcome-box');
    var estudiantesModal = document.getElementById('estudiantesModal');

    btnMostrarInformesAsistencia.onclick = function() {
        modalInformesAsistencia.style.display = "block";
        welcomeBox.style.display = "none";
        estudiantesModal.style.display = "none";
    }

    cerrarModalInformesAsistencia.onclick = function() {
        modalInformesAsistencia.style.display = "none";
        welcomeBox.style.display = "block";
    }

    window.onclick = function(event) {
        if (event.target == modalInformesAsistencia) {
            modalInformesAsistencia.style.display = "none";
            welcomeBox.style.display = "block";
        }
    }
});

var modal = document.getElementById('modalNewStudentFP');
var btn = document.getElementById('btnOpenNewStudentFP');
var span = document.getElementsByClassName('close-student-fp')[0];

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("modal-lista-estudiantes-FP");
    var btnOpenModal = document.getElementById("abrirInformeFP");
    var btnCloseModal = document.getElementById("closeListaEstudiantesModal-FP");

    btnOpenModal.addEventListener("click", function() {
        modal.style.display = "block";
    });

    btnCloseModal.addEventListener("click", function() {
        modal.style.display = "none";
    });

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
});

function mostrarModal() {
    var modal = document.getElementById('modal-lista-estudiantes');
    modal.style.display = 'block';
}

function cerrarModal() {
    var modal = document.getElementById('modal-lista-estudiantes');
    modal.style.display = 'none';
}

window.onload = function() {
    var botonCierre = document.getElementById('closeListaEstudiantesModal');
    botonCierre.onclick = function() {
        cerrarModal();
    };

    var botonAbrir = document.getElementById('modallistaestudiantestecnicaturas');
    botonAbrir.onclick = function() {
        mostrarModal();
    };
};

window.onclick = function(event) {
    var modal = document.getElementById('modal-lista-estudiantes');
    if (event.target == modal) {
        cerrarModal();
    }
};
// -------------------------------Segundo AÑO--------------------------------------//
document.addEventListener("DOMContentLoaded", function() {
    // Abrir y cerrar el modal de inscripción para segundo año
    var modal = document.getElementById("inscripcionSegundoAnioModal");
    var btnOpenModal = document.getElementById("btnInscripcionSegundoAnio");
    var btnCloseModal = document.getElementById("closeInscripcionSegundoAnioModal");

    btnOpenModal.addEventListener("click", function() {
        modal.style.display = "block";
    });

    btnCloseModal.addEventListener("click", function() {
        modal.style.display = "none";
    });

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // Cargar materias mediante AJAX al cambiar el curso
    $('#cursoSelect').change(function() {
        var carrera = $('#carreraSelect').val();
        var curso = $('#cursoSelect').val();
        var materiasContainer = $('#materias-container');

        if (carrera && curso) {
            console.log("Cargando materias para carrera ID: " + carrera + " y curso: " + curso); // Depuración
            $.ajax({
                url: './Profesor/estudiante/inscripciones_2_3/obtener_materias.php',
                type: 'POST',
                data: { carrera: carrera, curso: curso },
                success: function(data) {
                    try {
                        console.log("Respuesta recibida: ", data); // Depuración
                        var materias = JSON.parse(data);
                        materiasContainer.empty(); // Limpiar el contenedor de materias

                        materias.forEach(function(materia) {
                            var div = $('<div></div>'); // Crear un contenedor para cada select

                            var select = $('<select></select>')
                                .attr('name', 'materias[' + materia.idMaterias + ']')
                                .addClass('form-container__input');

                            var optionNoCursa = $('<option></option>')
                                .val('0')
                                .text('No Cursa');
                            select.append(optionNoCursa);

                            var optionMateria = $('<option></option>')
                                .val(materia.idMaterias)
                                .text(materia.Nombre);
                            select.append(optionMateria);

                            div.append(select);
                            materiasContainer.append(div);
                        });

                        console.log("Materias cargadas exitosamente."); // Depuración
                    } catch (e) {
                        console.error("Error al procesar las materias: ", e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar las materias: " + xhr.responseText); // Detallado
                }
            });
        } else {
            console.warn("Carrera o curso no seleccionados."); // Depuración
        }
    });

    // Manejo del formulario
    $('#formInscripcion').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: './Profesor/estudiante/inscripciones_2_3/procesar_inscripcion.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
                $('#inscripcionSegundoAnioModal').hide();
            },
            error: function(xhr, status, error) {
                console.error("Error al procesar la inscripción: " + xhr.responseText); // Detallado
            }
        });
    });
});




</script>
</body>
</html>

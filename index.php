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
    <div class="nav-left">  
        <a href="index.php" class="home-button">Inicio</a>
        <button class="btn-new-member" id="btn-new-member">Nuevo Estudiante</button>
        <button class="btn-inscripcion" id="btnInscripcionSegundoAnio">Inscripción Segundo/Tercer Año</button>
    </div>
    <div class="nav-right">
        <a href="./login/cerrar_sesion.php" class="btn-logout">Cerrar sesión</a>
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



<!-- Modal de inscripción para segundo año / tercero  -->
<div id="inscripcionSegundoAnioModal" class="estudiantes-modal" style="display: none;">
    <div class="modal-content-estudiantes">
        <span class="modal-close-estudiantes close-modal-button" id="closeInscripcionSegundoAnioModal">&times; Cerrar</span>
        <h2>Registro de Inscripción para Segundo Y Tercer Año</h2>
        <form id="formInscripcion" action="./Profesor/estudiante/inscripciones_2_3/procesar_inscripcion.php">
        <label for="nombre_alu">Nombre:</label><br>
    <input type="text" name="legajo" placeholder="N° Legajo" class="form-container__input" required>
    <label for="nombre_alu">Carrera:</label>
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
    <label for="nombre_alu">Curso:</label>
    <select name="curso" id="cursoSelect" class="form-container__input" required>
        <option hidden>Selecciona Curso</option>
        <option value="2">Segundo Año</option>
        <option value="3">Tercer Año</option>
    </select>

    <div id="materias-container">
        <!-- Los checkboxes de materias se agregarán aquí mediante JavaScript -->
    </div>
    <label for="nombre_alu">Comision:</label>
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
    <label for="nombre_alu">Año:</label>
    <select name="Año_inscripcion" id="Año_inscripcion" class="form-container__input" required>
    <option hidden value="">Selecciona un año</option>
    <?php for ($year = 2025; $year <= 2034; $year++) { ?>
    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
    <?php } ?>
</select>

    <input type="submit" name="enviar" value="Inscribir" class="form-container__input">
</form>
    </div>
</div>


<div id="modal" class="modal">
    <div class="modal-content" style="text-align: left;">
        <span class="close" onclick="closeModal()">&times;</span>
        <?php include './Profesor/estudiante/guardar_estudiante.php'; ?>
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
<select name="inscripcion_carrera" id="inscripcion_carrera" class="form-container__input" required>
    <option hidden value="">Selecciona una carrera</option>
    <?php while ($row = mysqli_fetch_assoc($peticion)) { ?>
    <option value="<?php echo $row['idCarrera']; ?>"><?php echo $row['nombre_carrera']; ?></option>
    <?php } ?>
</select>

<?php
$sql_comision = "SELECT c.idComisiones, c.N_comicion FROM comisiones c";
$resultado_comision = $conexion->query($sql_comision);
?>
<label for="Comision">Comisión:</label>
<select name="Comision" id="Comision" class="form-container__input" required>
    <option hidden value="">Selecciona una Comisión</option>
    <?php while ($rowcomision = mysqli_fetch_assoc($resultado_comision)) { ?>
    <option value="<?php echo $rowcomision['idComisiones']; ?>"><?php echo $rowcomision['N_comicion']; ?></option>
    <?php } ?>
</select>

<label for="Año_inscripcion">Año de Inscripción:</label>
<select name="Año_inscripcion" id="Año_inscripcion" class="form-container__input" required>
    <option hidden value="">Selecciona un año</option>
    <?php for ($year = 2025; $year <= 2034; $year++) { ?>
    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
    <?php } ?>
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
            <input type="date" id="fecha_inicio" class="input_fecha" name="fecha_inicio" required>
            <br><br>
            <label for="fecha_fin">Fecha de fin:</label>
            <input type="date" id="fecha_fin" class="input_fecha" name="fecha_fin" required>
            <br><br>
            <label for="carrera">Selecciona una carrera:</label>
            <select name="carrera_curso_comision" class="form-input-informes" required>
                <option hidden>Selecciona una carrera</option>
                <?php
                include '../conexion/conexion.php';
                $sql_carreras = "SELECT * FROM carreras
                                WHERE idCarrera in('18','27','46','55')";
                $result_carreras = mysqli_query($conexion, $sql_carreras);

                while ($carrera = mysqli_fetch_assoc($result_carreras)) {
                    echo '<option value="'.$carrera['idCarrera'].'">'.$carrera['nombre_carrera'].'</option>';
                }
                ?>
            </select>
            <br><br>
            <label for="curso">Selecciona un curso:</label>
            <select name="curso" class="form-input-informes" required>
                <option hidden>Selecciona un curso</option>
                <?php
                $sql_cursos = "SELECT * FROM cursos";
                $result_cursos = mysqli_query($conexion, $sql_cursos);

                while ($curso = mysqli_fetch_assoc($result_cursos)) {
                    echo '<option value="'.$curso['idcursos'].'">'.$curso['nombre_curso'].'</option>';
                }
                ?>
            </select>
            <br><br>
            <label for="comision">Selecciona una comisión:</label>
            <select name="comision" class="form-input-informes" required>
                <option hidden>Selecciona una comisión</option>
                <?php
                $sql_comisiones = "SELECT * FROM comisiones";
                $result_comisiones = mysqli_query($conexion, $sql_comisiones);

                while ($comision = mysqli_fetch_assoc($result_comisiones)) {
                    echo '<option value="'.$comision['idComisiones'].'">'.$comision['N_comicion'].'</option>';
                }
                ?>
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
        <form action="./indexs/generar_exel_alumnos_administrativo.php" method="post">
            <br><br>
            <label for="carrera">Selecciona una carrera:</label>
            <select name="carrera" class="form-input-informes" required>
                <option hidden>Selecciona una carrera</option>
                <?php
                include '../conexion/conexion.php';
                $sql_carreras = "SELECT * FROM carreras
                                WHERE idCarrera in('18','27','46','55')";
                $result_carreras = mysqli_query($conexion, $sql_carreras);

                while ($carrera = mysqli_fetch_assoc($result_carreras)) {
                    echo '<option value="'.$carrera['idCarrera'].'">'.$carrera['nombre_carrera'].'</option>';
                }
                ?>
            </select>
            <br><br>
            <label for="curso">Selecciona un curso:</label>
            <select name="curso" class="form-input-informes" required>
                <option hidden>Selecciona un curso</option>
                <?php
                $sql_cursos = "SELECT * FROM cursos";
                $result_cursos = mysqli_query($conexion, $sql_cursos);

                while ($curso = mysqli_fetch_assoc($result_cursos)) {
                    echo '<option value="'.$curso['idcursos'].'">'.$curso['nombre_curso'].'</option>';
                }
                ?>
            </select>
            <br><br>
            <label for="comision">Selecciona una comisión:</label>
            <select name="comision" class="form-input-informes" required>
                <option hidden>Selecciona una comisión</option>
                <?php
                $sql_comisiones = "SELECT * FROM comisiones";
                $result_comisiones = mysqli_query($conexion, $sql_comisiones);

                while ($comision = mysqli_fetch_assoc($result_comisiones)) {
                    echo '<option value="'.$comision['idComisiones'].'">'.$comision['N_comicion'].'</option>';
                }
                ?>
            </select>
            <br><br>
            <input type="submit" value="Generar Excel" class="boton-submit-informes">
        </form>
    </div>
</div>

<!-- Botón para abrir el modal -->
<button id="btnVerEstudiantes" class="boton-ver-estudiantes">Ver estudiantes dados de baja</button>

<!-- Modal para mostrar la tabla de estudiantes -->
<div id="modalEstudiantes" class="modal-estudiantes">
    <div class="contenido-modal-estudiantes">
        <span class="cerrar-modal-estudiantes boton-cerrar" id="cerrarModalEstudiantes">&times; Cerrar</span>
        <div id="contenedorTablaEstudiantes">
            <table id="tablaEstudiantes">
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
                <tbody id="cuerpoTablaEstudiantes">
                    <!-- Contenido dinámico aquí -->
                </tbody>
            </table>
        </div>
    </div>
</div>






<script>
    document.addEventListener("DOMContentLoaded", function () {
        const carrera = document.getElementById("inscripcion_carrera");
        const comision = document.getElementById("Comision");
        const anio = document.getElementById("Año_inscripcion");
        const submitButton = document.getElementById("submitButton");

        // Función para habilitar o deshabilitar el botón de envío
        function validateForm() {
            if (carrera.value && comision.value && anio.value) {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }

        // Inicialmente deshabilitar el botón
        submitButton.disabled = true;

        // Agregar eventos de cambio a los selects
        carrera.addEventListener("change", validateForm);
        comision.addEventListener("change", validateForm);
        anio.addEventListener("change", validateForm);
    });
</script>

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




function confirmarBorrado(legajo) {
    var respuesta = confirm("¿Estás seguro de que quieres borrar este alumno?");
    if (respuesta) {
        window.location.href = "./Profesor/Borrado_logico_alumno.php?legajo=" + legajo;
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
document.addEventListener("DOMContentLoaded", function() {
    var modal = document.getElementById("inscripcionSegundoAnioModal");
    var btnOpenModal = document.getElementById("btnInscripcionSegundoAnio");
    var btnCloseModal = document.getElementById("closeInscripcionSegundoAnioModal");

    // Verificar que los elementos existan
    if (modal && btnOpenModal && btnCloseModal) {
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
    } else {
        console.error("No se encontraron los elementos del modal. Verifica los IDs en el HTML.");
    }

    // Cuando se cambie de curso o carrera
$('#cursoSelect').change(function () {
    var carrera = $('#carreraSelect').val();
    var curso = $('#cursoSelect').val();
    var legajo = $('input[name="legajo"]').val(); // Obtener el legajo del input
    var materiasContainer = $('#materias-container');

    // Vaciar el contenedor de materias antes de cargar nuevas
    materiasContainer.empty();

    if (carrera && curso && legajo) {
        $.ajax({
            url: './Profesor/estudiante/inscripciones_2_3/obtener_materias.php',
            type: 'POST',
            data: { carrera: carrera, curso: curso, legajo: legajo },
            success: function (data) {
                try {
                    var materias = JSON.parse(data);

                    materias.forEach(function (materia) {
                        var div = $('<div></div>'); // Crear un contenedor para cada materia

                        var checkbox = $('<input>')
                            .attr('type', 'checkbox')
                            .attr('name', 'materias[]')
                            .attr('value', materia.idMaterias)
                            .prop('checked', materia.cursada == 1); // Marcar el checkbox si la materia ya está cursada

                        var label = $('<label></label>')
                            .text(materia.Nombre)
                            .prepend(checkbox); // Añadir el checkbox al inicio del label

                        div.append(label);
                        materiasContainer.append(div);

                        // Evento para manejar cambios en los checkboxes
                        checkbox.change(function () {
                            if (!this.checked) {
                                if (confirm("¿Estás seguro de que deseas eliminar esta inscripción?")) {
                                    $.ajax({
                                        url: './Profesor/estudiante/inscripciones_2_3/procesar_inscripcion.php',
                                        type: 'POST',
                                        data: {
                                            accion: 'eliminar',
                                            legajo: legajo,
                                            materia: materia.idMaterias,
                                            curso: curso
                                        },
                                        success: function (response) {
                                            alert(response);
                                        },
                                        error: function (xhr, status, error) {
                                            console.error("Error al eliminar la inscripción: " + xhr.responseText);
                                        }
                                    });
                                } else {
                                    // Si el usuario cancela, volver a marcar el checkbox
                                    this.checked = true;
                                }
                            }
                        });
                    });
                } catch (e) {
                    console.error("Error al procesar las materias: ", e);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar las materias: " + xhr.responseText);
            }
        });
    } else {
        console.warn("Carrera, curso o legajo no seleccionados.");
    }
});

// Limpiar la tabla al enviar el formulario
$('#formInscripcion').submit(function (event) {
    event.preventDefault(); // Prevenir el envío tradicional del formulario

    var materiasContainer = $('#materias-container');
    materiasContainer.empty(); // Vaciar las materias antes de enviar el formulario

    $.ajax({
        url: './Profesor/estudiante/inscripciones_2_3/procesar_inscripcion.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            alert(response); // Mostrar respuesta del servidor
        },
        error: function (xhr, status, error) {
            console.error("Error al procesar el formulario: " + xhr.responseText);
            alert("Ocurrió un error al procesar el formulario.");
        }
    });
});



    // Manejo del formulario
$('#formInscripcion').submit(function(event) {
    event.preventDefault(); // Prevenir el envío tradicional del formulario

    $.ajax({
        url: './Profesor/estudiante/inscripciones_2_3/procesar_inscripcion.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            // Verificar la respuesta del servidor
            if (response.includes("exitosa")) {
                // Mostrar mensaje de éxito
                alert("Inscripción realizada con éxito.");
                // Cerrar el modal
                $('#inscripcionSegundoAnioModal').hide();
                // Opcional: Limpiar el formulario
                $('#formInscripcion')[0].reset();
            } else {
                // Mostrar mensaje de error
                alert("Error: " + response);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al procesar la inscripción: " + xhr.responseText);
            alert("Ocurrió un error al intentar inscribir al estudiante.");
            }
        });
    });
});




// Actualizar tabla estudiantes 
document.addEventListener('DOMContentLoaded', function () {
    const btnMostrarEstudiantes = document.getElementById('btnMostrarEstudiantes');
    const tablaContainerEstudiantes = document.getElementById('tablaContainerEstudiantes');
    const estudiantesModal = document.getElementById('estudiantesModal');

    // Función para cargar los datos de la tabla mediante AJAX
    function actualizarTablaEstudiantes() {
        fetch('./obtener_estudiantes.php')
            .then(response => response.text())
            .then(data => {
                // Actualiza el cuerpo de la tabla con los nuevos datos
                const tablaBody = document.querySelector('#tabla tbody');
                tablaBody.innerHTML = data;
            })
            .catch(error => {
                console.error('Error al actualizar la tabla:', error);
            });
    }

    // Mostrar el modal y cargar los datos al hacer clic en el botón
    btnMostrarEstudiantes.addEventListener('click', function () {
        estudiantesModal.style.display = 'block';
        actualizarTablaEstudiantes(); // Cargar los datos al abrir el modal
    });

    // Cerrar el modal al hacer clic en el botón de cerrar
    const closeEstudiantesModal = document.getElementById('closeEstudiantesModal');
    closeEstudiantesModal.addEventListener('click', function () {
        estudiantesModal.style.display = 'none';
    });

    // Cerrar el modal al hacer clic fuera de él
    window.addEventListener('click', function (event) {
        if (event.target === estudiantesModal) {
            estudiantesModal.style.display = 'none';
        }
    });
});

</script>







<script>

document.addEventListener("DOMContentLoaded", function () {
    const btnVerEstudiantes = document.getElementById("btnVerEstudiantes");
    const modalEstudiantes = document.getElementById("modalEstudiantes");
    const cerrarModal = document.getElementById("cerrarModalEstudiantes");

    // Abrir modal al hacer clic en "Ver Estudiantes"
    btnVerEstudiantes.addEventListener("click", function () {
        modalEstudiantes.style.display = "block";
        cargarListaEstudiantes(); // Llamar a la función para cargar los datos
    });

    // Cerrar modal al hacer clic en la "X"
    cerrarModal.addEventListener("click", function () {
        modalEstudiantes.style.display = "none";
    });

    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener("click", function (event) {
        if (event.target === modalEstudiantes) {
            modalEstudiantes.style.display = "none";
        }
    });

    // Cargar estudiantes dinámicamente
    function cargarListaEstudiantes() {
        fetch("cargar_lista_estudiantes.php")
            .then((response) => response.text())
            .then((data) => {
                document.getElementById("cuerpoTablaEstudiantes").innerHTML = data;
            });
    }

    // Función para cambiar estado del estudiante
    function cambiarEstadoEstudiante(legajo) {
        fetch("cambiar_estado_estudiante.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `legajo=${legajo}`,
        })
            .then(response => response.text())
            .then(data => {
                alert(data); // Mensaje de confirmación
                cargarListaEstudiantes(); // Recargar tabla
            });
    }

    // Delegación de eventos para el botón de recuperar
    document.getElementById("cuerpoTablaEstudiantes").addEventListener("click", function (event) {
        if (event.target.classList.contains("boton-recuperar")) {
            const legajo = event.target.dataset.legajo;
            cambiarEstadoEstudiante(legajo);
        }
    });
});
</script>

<style>
    /* Ocultar el modal inicialmente */
.modal-estudiantes {
    display: none; /* Ocultar inicialmente */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
}

/* Contenido del modal */
.contenido-modal-estudiantes {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 900px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Botón cerrar */
.boton-cerrar {
    float: right;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}

/* Tabla */
#tablaEstudiantes {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

#tablaEstudiantes th,
#tablaEstudiantes td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

#tablaEstudiantes th {
    background-color: #f3545d;
    color: white;
}

#tablaEstudiantes tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.boton-ver-estudiantes {
    background-color: #9c0e0e;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}



</style>

</body>
</html>

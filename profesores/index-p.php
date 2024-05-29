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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGPM-Docentes</title>
    <link rel="stylesheet" type="text/css" href="../../../normalize.css">
    <link rel="stylesheet" type="text/css" href="./estilos_profesores.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    <style>
        /* Estilos para el modal */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
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
    </style>
</head>
<body>
<nav>
    <div class="logo"><img src="../imagenes/politecnico.png" alt="Politecnico Logo"></div>
    <button class="modal-btn" id="modalBtn">Libro de Tema</button>
    <button class="logout-btn" onclick="window.location.href='../login/cerrar_sesion.php'">Cerrar Sesión</button> <!-- Asegúrate de que logout.php existe y maneja la sesión -->
</nav>
<div class="nav-welcome-container">
    <div id="welcome-box" class="welcome-box">
        <?php
        $sql = "SELECT m.Nombre AS nombre_materia, c.nombre_carrera, p.nombre_profe, p.apellido_profe, m.idMaterias, c.idCarrera 
                FROM materias m  
                INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
                INNER JOIN profesor p ON m.profesor_idProrfesor = p.idProrfesor
                WHERE p.idProrfesor = '{$_SESSION["id"]}'"; 
        $query = mysqli_query($conexion, $sql); 

        if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
            ?>
            <h1 class="welcome-box__h1">Bienvenido/a <?php echo $row['apellido_profe'] ?> <?php echo $row['nombre_profe'] ?></h1>
            <h3>Seleccione una Materia</h3>
            <?php
            do {
                ?>
                <button><a href="./prueba_tabla.php?materia=<?php echo $row['idMaterias'] ?>&carrera=<?php echo $row['idCarrera'] ?>"> <?php echo $row['nombre_carrera'] ?> -- <?php echo $row['nombre_materia'] ?></a></button><br>
                <?php
            } while ($row = mysqli_fetch_array($query));
        } else {
            echo "No se encontraron materias asociadas al profesor.";
        } ?>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <!-- Contenido del modal -->
    <?php
    // Consulta para obtener las materias y sus carreras asociadas
    $sql = "SELECT c.idCarrera, c.nombre_carrera, m.idMaterias, m.Nombre
            FROM materias m
            INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
            INNER JOIN profesor p ON m.profesor_idProrfesor = p.idProrfesor
            WHERE p.idProrfesor = '{$_SESSION['id']}'";

    $query = mysqli_query($conexion, $sql);

    // Arrays para almacenar los datos de materias y carreras
    $materias = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $materias[] = $row;
    }
    ?>
    <h2>Libro de Tema</h2>
    <form action="guardar_libro_tema.php" method="post">
        <input type="hidden" name="profesor" value="<?php echo $_SESSION['id']; ?>">
        
        <select name="materia" id="materia" onchange="actualizarCarrera()">
            <option value="">Seleccione una materia</option>
            <?php
            // Consulta para obtener las materias y sus carreras asociadas
            $sql = "SELECT c.idCarrera, c.nombre_carrera, m.idMaterias, m.Nombre
                    FROM materias m
                    INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
                    INNER JOIN profesor p ON m.profesor_idProrfesor = p.idProrfesor
                    WHERE p.idProrfesor = '{$_SESSION['id']}'";
            
            $query = mysqli_query($conexion, $sql);

            // Iterar sobre los resultados con while en lugar de foreach
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<option value=\"{$row['idMaterias']}\" data-carrera-id=\"{$row['idCarrera']}\">{$row['Nombre']} / {$row['nombre_carrera']}</option>";
            }
            ?>
        </select>
        
        <input type="hidden" name="carrera" id="carrera">
        
        <input type="text" name="capacidades" placeholder="Capacidades">
        <input type="text" name="contenidos" placeholder="Contenidos">
        <input type="text" name="evaluacion" placeholder="Evaluación">
        <input type="text" name="observacion" placeholder="Observacion Diaria">
        <input type="date" name="fecha">
        
        <input type="submit" name="enviar" value="Enviar">
    </form>
    </div>
</div>
    <script>
    function actualizarCarrera() {
        var materiaSelect = document.getElementById('materia');
        var carreraInput = document.getElementById('carrera');
        
        var selectedOption = materiaSelect.options[materiaSelect.selectedIndex];
        var carreraId = selectedOption.getAttribute('data-carrera-id');
        
        carreraInput.value = carreraId || '';
    }

    // Script para manejar el modal
    var modal = document.getElementById('myModal');
    var btn = document.getElementById('modalBtn');
    var span = document.getElementsByClassName('close')[0];

    btn.onclick = function() {
        modal.style.display = 'block';
    }

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('myModal');
    var btn = document.getElementById('modalBtn');
    var span = document.getElementsByClassName('close')[0];

    btn.onclick = function() {
        modal.classList.add('show');
        modal.style.display = 'block';
    }

    span.onclick = function() {
        closeModal();
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    function closeModal() {
        modal.classList.remove('show');
        setTimeout(function() {
            modal.style.display = 'none';
        }, 300); // Tiempo coincidente con la duración de la transición
    }
});
    </script>
  

</body>

</html>
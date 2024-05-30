<?php
session_start();
if (empty($_SESSION["id"])) {
    header('Location: ../../login/login.php');
}

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
<?php include '../../conexion/conexion.php' ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGPM-Docentes</title>
    <link rel="stylesheet" type="text/css" href="../../../normalize.css">
    <link rel="icon" href="../politecnico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Bz5/BqJ8SCxmeLEjmo5fD5fgONMAewh+PxQv0tRnm5IsJf5M9bGqDlVCS5c3X7CQZLjdvFtJ+zaOhtlUlm7XjA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
</head>
<body>

<table id="tablaLibros" border="1">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Carrera</th>
            <th>Materia</th>
            <th>Capacidades</th>
            <th>Contenidos</th>
            <th>Evaluación</th>
            <th>Observaciones diarias</th>
            <th> Acciones </th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>

<script>
    $(document).ready(function() {
        function cargarDatos() {
            $.ajax({
                url: 'ajax_libro_tema.php',
                method: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    const tbody = $('#tablaLibros tbody');
                    tbody.empty();
                    data.forEach(row => {
                        const newRow = $(`
                            <tr>
                                <td>${row.fecha}</td>
                                <td>${row.nombre_carrera}</td>
                                <td>${row.materia_nombre}</td> <!-- Verifica que la propiedad sea correcta -->
                                <td class="editable">${row.capacidades}</td>
                                <td class="editable">${row.contenidos}</td>
                                <td class="editable">${row.evaluacion}</td>
                                <td class="editable">${row.observacion_diaria}</td>
                                <td>
                                    <button class="btn-modificar">Modificar</button>
                                    <button class="btn-borrar">Borrar</button>
                                    <button class="btn-actualizar" style="display: none;">Actualizar cambios</button>
                                </td>
                            </tr>
                        `);
                        tbody.append(newRow);
                    });

                    // Delegación de eventos para los botones
                    tbody.on('click', '.btn-modificar', function() {
                        var fila = $(this).closest('tr');
                        fila.find('.editable').each(function() {
                            var contenido = $(this).text();
                            $(this).html('<input type="text" value="' + contenido + '">');
                        });
                        fila.find('.btn-modificar').hide();
                        fila.find('.btn-borrar').hide();
                        fila.find('.btn-actualizar').show();
                    });

                    tbody.on('click', '.btn-actualizar', function() {
                        var fila = $(this).closest('tr');
                        fila.find('.editable').each(function() {
                            var contenido = $(this).find('input').val();
                            $(this).text(contenido);
                        });
                        fila.find('.btn-actualizar').hide();
                        fila.find('.btn-modificar').show();
                        fila.find('.btn-borrar').show();
                    });

                    tbody.on('click', '.btn-borrar', function() {
                        if (confirm('¿Está seguro de que desea borrar este registro?')) {
                            $(this).closest('tr').remove();
                            // Aquí puedes agregar la lógica para eliminar el registro de la base de datos si es necesario
                        }
                    });

                    // Agregar fila de inputs dentro del formulario
                    tbody.append(`
                        <tr>
                            <td colspan="8">
                                <form id="nuevoLibroForm" action="guardar_libro_tema.php" method="post">
                                    <input type="hidden" name="profesor" value="<?php echo $_SESSION['id']; ?>">
                                    <select name="materia" id="materia" onchange="actualizarCarrera()">
                                        <option value="">Seleccione una materia</option>
                                        <?php
                                        $sql = "SELECT c.idCarrera, c.nombre_carrera, m.idMaterias, m.Nombre
                                                FROM materias m
                                                INNER JOIN carreras c ON m.carreras_idCarrera = c.idCarrera
                                                INNER JOIN profesor p ON m.profesor_idProrfesor = p.idProrfesor
                                                WHERE p.idProrfesor = '{$_SESSION['id']}'";
                                        
                                        $query = mysqli_query($conexion, $sql);
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            echo "<option value=\"{$row['idMaterias']}\" data-carrera-id=\"{$row['idCarrera']}\">{$row['Nombre']} / {$row['nombre_carrera']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="carrera" id="carrera">
                                    <input type="text" name="capacidades" placeholder="Capacidades">
                                    <input type="text" name="contenidos" placeholder="Contenidos">
                                    <input type="text" name="evaluacion" placeholder="Evaluación">
                                    <input type="date" name="fecha">
                                    <input type="text" name="observacion" placeholder="Observación Diaria">
                                    <input type="submit" name="enviar" value="Enviar">
                                </form>
                            </td>
                        </tr>
                    `);

                    // Re-inicializar DataTables
                    var myTable = document.querySelector("#tablaLibros");
                    var dataTable = new DataTable(myTable);
                }
            });
        }

        // Llamar a la función para cargar los datos
        cargarDatos();
    });

    // Función para actualizar la carrera basada en la materia seleccionada
    function actualizarCarrera() {
        const selectMateria = document.getElementById('materia');
        const selectedOption = selectMateria.options[selectMateria.selectedIndex];
        const carreraId = selectedOption.getAttribute('data-carrera-id');
        document.getElementById('carrera').value = carreraId;
    }
</script>




</body>
</html>
<?php include'../../conexion/conexion.php';
 ?>
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

<form id="dateForm" action="guardar_libro_tema.php" method="post">
    <input type="hidden" name="profesor" value="<?php echo $_SESSION['id']; ?>">
    <table id="tablaLibros" border="1">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Capacidades</th>
                <th>Contenidos</th>
                <th>Evaluacion</th>
               
                <th>Observacione diarias</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</form>

<script>
    $(document).ready(function() {
        function cargarDatos() {
            $.ajax({
                url: 'ruta_a_tu_php.php', // Cambia esto por la ruta a tu archivo PHP
                method: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    const tbody = $('#tablaLibros tbody');
                    tbody.empty();
                    data.forEach(row => {
                        tbody.append(`
                            <tr>
                                <td>${row.capacidades}</td>
                                <td>${row.contenidos}</td>
                                <td>${row.evaluacion}</td>
                                <td>${row.fecha}</td>
                                <td>${row.observaciones_diarias}</td>
                            </tr>
                        `);
                    });
                    // Agregar fila de inputs dentro del formulario
                    tbody.append(`
                        <tr>
                            <td colspan="5">
                                <form action="guardar_libro_tema.php" method="post">
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
                                    <input type="text" name="observacion" placeholder="Observacion Diaria">
                                    <input type="date" name="fecha">
                                    <input type="submit" name="enviar" value="Enviar">
                                </form>
                            </td>
                        </tr>
                    `);
                    var myTable = document.querySelector("#tablaLibros");
                    var dataTable = new DataTable(myTable);
                }
            });
        }

        // Llamar a la función para cargar los datos
        cargarDatos();
    });
</script>

</body>
</html>

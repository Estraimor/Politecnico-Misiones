<?php
require './exel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$server = 'localhost';
$user = 'u756746073_root';
$pass = 'POLITECNICOmisiones2023.';
$bd = 'u756746073_politecnico';
$conexion = mysqli_connect($server, $user, $pass, $bd, '3306');

if ($conexion) {
    echo "";
} else {
    echo "conexion not connected";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las fechas de inicio y fin desde el formulario
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
    $carrera = isset($_POST['carrera']) ? $_POST['carrera'] : null;

    if ($fecha_inicio && $fecha_fin && $carrera) {
        // Consultar la base de datos para obtener los datos de asistencia entre las fechas especificadas
        $consulta_asistencia = "SELECT a.idasistencia, a.fecha, CONCAT(a2.nombre_alumno, ' ', a2.apellido_alumno) AS nombre_completo, c.nombre_carrera, m.Nombre, a.1_Horario, a.2_Horario 
        FROM asistencia a 
        INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.inscripcion_asignatura_alumno_legajo 
        INNER JOIN alumno a2 ON a2.legajo = ia.alumno_legajo INNER JOIN carreras c ON c.idCarrera = ia.carreras_idCarrera 
        INNER JOIN materias m ON m.idMaterias = a.materias_idMaterias 
        WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' and c.idCarrera = '$carrera';";
        $resultado_asistencia = $conexion->query($consulta_asistencia);

        // Verificar si se obtuvieron resultados de asistencia
        if ($resultado_asistencia && $resultado_asistencia->num_rows > 0) {
            // Crear un nuevo objeto Spreadsheet (similar a PHPExcel)
            $spreadsheet = new Spreadsheet();

            // Agregar una hoja para los datos de asistencia
            $sheet_asistencia = $spreadsheet->getActiveSheet();
            $sheet_asistencia->setTitle('Asistencia');

            // Escribir el encabezado para los datos de asistencia en la primera fila
            $sheet_asistencia->setCellValue('A1', 'ID Asistencia');
            $sheet_asistencia->setCellValue('B1', 'Fecha');
            $sheet_asistencia->setCellValue('C1', 'Nombre Alumno');
            $sheet_asistencia->setCellValue('D1', 'Carrera');
            $sheet_asistencia->setCellValue('E1', 'Materia');
            $sheet_asistencia->setCellValue('F1', '1° Horario');
            $sheet_asistencia->setCellValue('G1', '2° Horario');

            // Variables para contar presentes, ausentes y justificados por fecha y horario
            $conteo_por_fecha_y_horario = [];

            // Contador para la fila actual en la hoja de asistencia
            $row_asistencia = 2;

            // Iterar sobre los resultados de la consulta de asistencia
            while ($fila_asistencia = $resultado_asistencia->fetch_assoc()) {
                $sheet_asistencia->setCellValue('A' . $row_asistencia, $fila_asistencia['idasistencia']);
                $sheet_asistencia->setCellValue('B' . $row_asistencia, $fila_asistencia['fecha']);
                $sheet_asistencia->setCellValue('C' . $row_asistencia, $fila_asistencia['nombre_completo']);
                $sheet_asistencia->setCellValue('D' . $row_asistencia, $fila_asistencia['nombre_carrera']); // Corregido: se usa el nombre de la carrera en lugar del id
                $sheet_asistencia->setCellValue('E' . $row_asistencia, $fila_asistencia['Nombre']); // Corregido: se usa el nombre de la materia en lugar del id
                $sheet_asistencia->setCellValue('F' . $row_asistencia, $fila_asistencia['1_Horario']);
                $sheet_asistencia->setCellValue('G' . $row_asistencia, $fila_asistencia['2_Horario']);

                // Incrementar el conteo para la fecha y el horario
                $fecha_asistencia = $fila_asistencia['fecha'];
                if (!isset($conteo_por_fecha_y_horario[$fecha_asistencia])) {
                    $conteo_por_fecha_y_horario[$fecha_asistencia] = ['Presente' => 0, 'Ausente' => 0, 'Justificada' => 0, 'Presente_2' => 0, 'Ausente_2' => 0, 'Justificada_2' => 0];
                }

                // Incrementar el conteo para el horario 1
                if ($fila_asistencia['1_Horario'] == 'Presente') {
                    $conteo_por_fecha_y_horario[$fecha_asistencia]['Presente']++;
                } elseif ($fila_asistencia['1_Horario'] == 'Ausente') {
                    $conteo_por_fecha_y_horario[$fecha_asistencia]['Ausente']++;
                } elseif ($fila_asistencia['1_Horario'] == 'Justificada') {
                    $conteo_por_fecha_y_horario[$fecha_asistencia]['Justificada']++;
                }

                // Incrementar el conteo para el horario 2
                if ($fila_asistencia['2_Horario'] == 'Presente') {
                    $conteo_por_fecha_y_horario[$fecha_asistencia]['Presente_2']++;
                } elseif ($fila_asistencia['2_Horario'] == 'Ausente') {
                    $conteo_por_fecha_y_horario[$fecha_asistencia]['Ausente_2']++;
                } elseif ($fila_asistencia['2_Horario'] == 'Justificada') {
                    $conteo_por_fecha_y_horario[$fecha_asistencia]['Justificada_2']++;
                }

                $row_asistencia++;
            }

            // Calcular el porcentaje de asistencia para cada fecha y horario
            foreach ($conteo_por_fecha_y_horario as $fecha => $conteo) {
                $total_asistencias = $conteo['Presente'] + $conteo['Ausente'] + $conteo['Justificada'];
                $porcentaje_presentes = $total_asistencias > 0 ? ($conteo['Presente'] / $total_asistencias) * 100 : 0;
                $porcentaje_ausentes = $total_asistencias > 0 ? ($conteo['Ausente'] / $total_asistencias) * 100 : 0;
                $porcentaje_justificados = $total_asistencias > 0 ? ($conteo['Justificada'] / $total_asistencias) * 100 : 0;

                $total_asistencias_2 = $conteo['Presente_2'] + $conteo['Ausente_2'] + $conteo['Justificada_2'];
                $porcentaje_presentes_2 = $total_asistencias_2 > 0 ? ($conteo['Presente_2'] / $total_asistencias_2) * 100 : 0;
                $porcentaje_ausentes_2 = $total_asistencias_2 > 0 ? ($conteo['Ausente_2'] / $total_asistencias_2) * 100 : 0;
                $porcentaje_justificados_2 = $total_asistencias_2 > 0 ? ($conteo['Justificada_2'] / $total_asistencias_2) * 100 : 0;

                $conteo_por_fecha_y_horario[$fecha]['Porcentaje_Presentes'] = $porcentaje_presentes;
                $conteo_por_fecha_y_horario[$fecha]['Porcentaje_Ausentes'] = $porcentaje_ausentes;
                $conteo_por_fecha_y_horario[$fecha]['Porcentaje_Justificados'] = $porcentaje_justificados;

                $conteo_por_fecha_y_horario[$fecha]['Porcentaje_Presentes_2'] = $porcentaje_presentes_2;
                $conteo_por_fecha_y_horario[$fecha]['Porcentaje_Ausentes_2'] = $porcentaje_ausentes_2;
                $conteo_por_fecha_y_horario[$fecha]['Porcentaje_Justificados_2'] = $porcentaje_justificados_2;
            }

            // Escribir el resumen por fecha y horario al final de la hoja de asistencia
            $row_asistencia++;

            $sheet_asistencia->setCellValue('A' . $row_asistencia, 'Fecha');
            $sheet_asistencia->setCellValue('B' . $row_asistencia, 'Cantidad Presente 1 Materia');
            $sheet_asistencia->setCellValue('C' . $row_asistencia, 'Cantidad Ausente 1 Materia');
            $sheet_asistencia->setCellValue('D' . $row_asistencia, 'Cantidad Justificada 1 Materia');
            $sheet_asistencia->setCellValue('E' . $row_asistencia, 'Porcentaje de Presentes');
            $sheet_asistencia->setCellValue('F' . $row_asistencia, 'Porcentaje de Ausentes');
            $sheet_asistencia->setCellValue('G' . $row_asistencia, 'Porcentaje de Justificados');
            $sheet_asistencia->setCellValue('H' . $row_asistencia, 'Cantidad Presente 2 Materia');
            $sheet_asistencia->setCellValue('I' . $row_asistencia, 'Cantidad Ausente 2 Materia');
            $sheet_asistencia->setCellValue('J' . $row_asistencia, 'Cantidad Justificada 2 Materia');
            $sheet_asistencia->setCellValue('K' . $row_asistencia, 'Porcentaje de Presentes_2');
            $sheet_asistencia->setCellValue('L' . $row_asistencia, 'Porcentaje de Ausentes_2');
            $sheet_asistencia->setCellValue('M' . $row_asistencia, 'Porcentaje de Justificados_2');

            foreach ($conteo_por_fecha_y_horario as $fecha => $conteo) {
                $sheet_asistencia->setCellValue('A' . $row_asistencia, $fecha);
                $sheet_asistencia->setCellValue('B' . $row_asistencia, $conteo['Presente']);
                $sheet_asistencia->setCellValue('C' . $row_asistencia, $conteo['Ausente']);
                $sheet_asistencia->setCellValue('D' . $row_asistencia, $conteo['Justificada']);
                $sheet_asistencia->setCellValue('E' . $row_asistencia, $conteo['Porcentaje_Presentes']);
                $sheet_asistencia->setCellValue('F' . $row_asistencia, $conteo['Porcentaje_Ausentes']);
                $sheet_asistencia->setCellValue('G' . $row_asistencia, $conteo['Porcentaje_Justificados']);
                $sheet_asistencia->setCellValue('H' . $row_asistencia, $conteo['Presente_2']);
                $sheet_asistencia->setCellValue('I' . $row_asistencia, $conteo['Ausente_2']);
                $sheet_asistencia->setCellValue('J' . $row_asistencia, $conteo['Justificada_2']);
                $sheet_asistencia->setCellValue('K' . $row_asistencia, $conteo['Porcentaje_Presentes_2']);
                $sheet_asistencia->setCellValue('L' . $row_asistencia, $conteo['Porcentaje_Ausentes_2']);
                $sheet_asistencia->setCellValue('M' . $row_asistencia, $conteo['Porcentaje_Justificados_2']);
                $row_asistencia++;
            }

            // Consultar las justificaciones para las fechas y la carrera especificadas
            $consulta_justificaciones = "SELECT 
    c.nombre_carrera,
    a2.nombre_alumno,
    a2.apellido_alumno,
    m.Nombre AS materia,
    a.Motivo,
    a.fecha 
FROM 
    alumnos_justificados a
INNER JOIN 
    carreras c ON c.idCarrera = a.inscripcion_asignatura_carreras_idCarrera
INNER JOIN 
    alumno a2 ON a.inscripcion_asignatura_alumno_legajo = a2.legajo
INNER JOIN 
    materias m ON m.idMaterias = a.materias_idMaterias
WHERE 
    a.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' OR a.inscripcion_asignatura_carreras_idCarrera = '$carrera'";

            $resultado_justificaciones = mysqli_query($conexion, $consulta_justificaciones);

            if ($resultado_justificaciones && mysqli_num_rows($resultado_justificaciones) > 0) {
    // Crear una nueva hoja para las justificaciones
    $sheet_justificaciones = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Justificaciones');
    $spreadsheet->addSheet($sheet_justificaciones);

    // Establecer las cabeceras para las justificaciones
    $sheet_justificaciones->setCellValue('A1', 'Carrera');
    $sheet_justificaciones->setCellValue('B1', 'Nombre');
    $sheet_justificaciones->setCellValue('C1', 'Apellido');
    $sheet_justificaciones->setCellValue('D1', 'Materia');
    $sheet_justificaciones->setCellValue('E1', 'Motivo');
    $sheet_justificaciones->setCellValue('F1', 'Fecha');

    // Contador de fila para las justificaciones
    $row_justificaciones = 2;

    // Iterar sobre los resultados de las justificaciones y escribirlos en la hoja correspondiente
    while ($fila_justificacion = mysqli_fetch_assoc($resultado_justificaciones)) {
        $sheet_justificaciones->setCellValue('A' . $row_justificaciones, $fila_justificacion['nombre_carrera']);
        $sheet_justificaciones->setCellValue('B' . $row_justificaciones, $fila_justificacion['nombre_alumno']);
        $sheet_justificaciones->setCellValue('C' . $row_justificaciones, $fila_justificacion['apellido_alumno']);
        $sheet_justificaciones->setCellValue('D' . $row_justificaciones, $fila_justificacion['materia']);
        $sheet_justificaciones->setCellValue('E' . $row_justificaciones, $fila_justificacion['Motivo']);
        $sheet_justificaciones->setCellValue('F' . $row_justificaciones, $fila_justificacion['fecha']);

        $row_justificaciones++;
    }
}


            // Configurar el tipo de contenido y la descarga del archivo
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="asistencias_' . $fecha_inicio . '_' . $fecha_fin . '.xlsx"');
            header('Cache-Control: max-age=0');

            // Crear un objeto Writer para guardar el archivo Excel
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            // Finalizar la ejecución del script PHP
            exit;
        } else {
            echo "No se encontraron registros de asistencia entre las fechas especificadas.";
        }
    } else {
        echo "Error: Las fechas de inicio, fin o la carrera no fueron proporcionadas correctamente.";
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    echo "Acceso denegado.";
}
?>

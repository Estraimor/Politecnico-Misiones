<?php
require './exel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$server='localhost';
$user='root';
$pass='';
$bd='u756746073_politecnico';
$conexion=mysqli_connect($server,$user,$pass,$bd, '3306');

if ($conexion) { echo ""; } else { echo "conexion not connected"; }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las fechas de inicio y fin desde el formulario
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
    $carrera = isset($_POST['carrera']) ? $_POST['carrera'] : null;

    if ($fecha_inicio && $fecha_fin) {
        // Consultar la base de datos para obtener los datos de asistencia entre las fechas especificadas
        $consulta = "SELECT a.idasistencia, a.fecha, CONCAT(a2.nombre_alumno, ' ', a2.apellido_alumno) AS nombre_completo, c.nombre_carrera, m.Nombre, a.1_Horario, a.2_Horario 
        FROM asistencia a 
        INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.inscripcion_asignatura_alumno_legajo 
        INNER JOIN alumno a2 ON a2.legajo = ia.alumno_legajo INNER JOIN carreras c ON c.idCarrera = ia.carreras_idCarrera 
        INNER JOIN materias m ON m.idMaterias = a.materias_idMaterias 
        WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' and c.idCarrera = '$carrera';";
        $resultado = $conexion->query($consulta);

        // Verificar si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            // Crear un nuevo objeto Spreadsheet (similar a PHPExcel)
            $spreadsheet = new Spreadsheet();

            // Agregar una hoja al archivo Excel
            $sheet = $spreadsheet->getActiveSheet();

            // Escribir el encabezado en la primera fila
            $sheet->setCellValue('A1', 'ID Asistencia');
            $sheet->setCellValue('B1', 'Fecha');
            $sheet->setCellValue('C1', 'Nombre Alumno');
            $sheet->setCellValue('D1', 'Carrera');
            $sheet->setCellValue('E1', 'Materia');
            $sheet->setCellValue('F1', '1° Horario');
            $sheet->setCellValue('G1', '2° Horario');

            // Variables para contar presentes, ausentes y justificados por fecha y horario
            $conteo_por_fecha_y_horario = [];

            // Contador para la fila actual
            $row = 2;

            // Iterar sobre los resultados de la consulta
            while ($fila = $resultado->fetch_assoc()) {
                $sheet->setCellValue('A' . $row, $fila['idasistencia']);
                $sheet->setCellValue('B' . $row, $fila['fecha']);
                $sheet->setCellValue('C' . $row, $fila['nombre_completo']);
                $sheet->setCellValue('D' . $row, $fila['nombre_carrera']); // Corregido: se usa el nombre de la carrera en lugar del id
                $sheet->setCellValue('E' . $row, $fila['Nombre']); // Corregido: se usa el nombre de la materia en lugar del id
                $sheet->setCellValue('F' . $row, $fila['1_Horario']);
                $sheet->setCellValue('G' . $row, $fila['2_Horario']);

                // Incrementar el conteo para el fecha
                $fecha = $fila['fecha'];
                if (!isset($conteo_por_fecha_y_horario[$fecha])) {
                    $conteo_por_fecha_y_horario[$fecha] = ['Presente' => 0, 'Ausente' => 0, 'Justificada' => 0, 'Presente_2' => 0, 'Ausente_2' => 0, 'Justificada_2' => 0];
                }

                // Incrementar el conteo para el horario 1
                if ($fila['1_Horario'] == 'Presente') {
                    $conteo_por_fecha_y_horario[$fecha]['Presente']++;
                } elseif ($fila['1_Horario'] == 'Ausente') {
                    $conteo_por_fecha_y_horario[$fecha]['Ausente']++;
                } elseif ($fila['1_Horario'] == 'Justificada') {
                    $conteo_por_fecha_y_horario[$fecha]['Justificada']++;
                }

                // Incrementar el conteo para el horario 2
                if ($fila['2_Horario'] == 'Presente') {
                    $conteo_por_fecha_y_horario[$fecha]['Presente_2']++;
                } elseif ($fila['2_Horario'] == 'Ausente') {
                    $conteo_por_fecha_y_horario[$fecha]['Ausente_2']++;
                } elseif ($fila['2_Horario'] == 'Justificada') {
                    $conteo_por_fecha_y_horario[$fecha]['Justificada_2']++;
                }

                $row++;
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

            // Escribir el resumen por fecha y horario al final del archivo Excel
            $sheet->setCellValue('A' . $row, 'Fecha');
            $sheet->setCellValue('B' . $row, ' Cantidad Presente 1 Materia');
            $sheet->setCellValue('C' . $row, ' Cantidad Ausente 1 materia');
            $sheet->setCellValue('D' . $row, ' Cantidad Justificada 1 Materia');
            $sheet->setCellValue('E' . $row, 'Porcentaje de Presentes');
            $sheet->setCellValue('F' . $row, 'Porcentaje de Ausentes');
            $sheet->setCellValue('G' . $row, 'Porcentaje de Justificados');
            $sheet->setCellValue('H' . $row, ' Cantidad Presente 2 Materia');
            $sheet->setCellValue('I' . $row, ' Cantidad Ausente 2 Materia');
            $sheet->setCellValue('J' . $row, ' Cantidad Justificada 2 Materia');
            $sheet->setCellValue('K' . $row, 'Porcentaje de Presentes_2');
            $sheet->setCellValue('L' . $row, 'Porcentaje de Ausentes_2');
            $sheet->setCellValue('M' . $row, 'Porcentaje de Justificados_2');
            $row++;

            foreach ($conteo_por_fecha_y_horario as $fecha => $conteo) {
                $sheet->setCellValue('A' . $row, $fecha);
                $sheet->setCellValue('B' . $row, $conteo['Presente']);
                $sheet->setCellValue('C' . $row, $conteo['Ausente']);
                $sheet->setCellValue('D' . $row, $conteo['Justificada']);
                $sheet->setCellValue('E' . $row, $conteo['Porcentaje_Presentes']);
                $sheet->setCellValue('F' . $row, $conteo['Porcentaje_Ausentes']);
                $sheet->setCellValue('G' . $row, $conteo['Porcentaje_Justificados']);
                $sheet->setCellValue('H' . $row, $conteo['Presente_2']);
                $sheet->setCellValue('I' . $row, $conteo['Ausente_2']);
                $sheet->setCellValue('J' . $row, $conteo['Justificada_2']);
                $sheet->setCellValue('K' . $row, $conteo['Porcentaje_Presentes_2']);
                $sheet->setCellValue('L' . $row, $conteo['Porcentaje_Ausentes_2']);
                $sheet->setCellValue('M' . $row, $conteo['Porcentaje_Justificados_2']);
                $row++;
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
        echo "Error: Las fechas de inicio y fin no fueron proporcionadas correctamente.";
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
} else {
    echo "Acceso denegado.";
}
?>

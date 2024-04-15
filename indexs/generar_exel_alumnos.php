<?php
require './exel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['carrera'])) {
        $carrera = $_POST['carrera'];

        // Consultar la base de datos para obtener los datos de los alumnos de la carrera seleccionada
        $consulta = "SELECT legajo, apellido_alumno, nombre_alumno, dni_alumno, celular
                     FROM inscripcion_asignatura ia 
                     INNER JOIN alumno a ON ia.alumno_legajo = a.legajo 
                     WHERE ia.carreras_idCarrera = '$carrera' AND a.estado = '1'";
        $resultado = $conexion->query($consulta);

        // Verificar si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            // Crear un nuevo objeto Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Escribir el encabezado en la primera fila
            $sheet->setCellValue('A1', 'N°');
            $sheet->setCellValue('B1', 'Legajo');
            $sheet->setCellValue('C1', 'Apellido');
            $sheet->setCellValue('D1', 'Nombre');
            $sheet->setCellValue('E1', 'DNI');
            $sheet->setCellValue('F1', 'Celular');

            // Contador para la fila actual
            $row = 2;

            // Contador para enumerar los alumnos
            $numero = 1;

            // Iterar sobre los resultados de la consulta
            while ($fila = $resultado->fetch_assoc()) {
                // Escribir el número de alumno antes de los datos del alumno
                $sheet->setCellValue('A' . $row, $numero);

                // Escribir los datos del estudiante
                $sheet->setCellValue('B' . $row, $fila['legajo']);
                $sheet->setCellValue('C' . $row, $fila['apellido_alumno']);
                $sheet->setCellValue('D' . $row, $fila['nombre_alumno']);
                $sheet->setCellValue('E' . $row, $fila['dni_alumno']);
                $sheet->setCellValue('F' . $row, $fila['celular']);

                // Incrementar el contador de alumnos
                $numero++;

                // Incrementar el contador de fila
                $row++;
            }

            // Configurar el tipo de contenido y la descarga del archivo
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Alumnos_' . date('Y-m-d') . '.xlsx"');
            header('Cache-Control: max-age=0');

            // Guardar el archivo Excel en la salida
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            // Finalizar la ejecución del script PHP
            exit;
        } else {
            echo "No se encontraron datos de alumnos para la carrera seleccionada.";
        }
    } else {
        echo "No se recibió el parámetro 'carrera' en el formulario.";
    }
} else {
    echo "Acceso denegado.";
}
?>

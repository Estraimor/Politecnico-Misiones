<?php
require './exel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$server = 'localhost';
$user = 'root';
$pass = '';
$bd = 'u756746073_politecnico';
$conexion = mysqli_connect($server, $user, $pass, $bd, '3306');

if (!$conexion) {
    echo "Error de conexión: " . mysqli_connect_error();
    exit;
}

if (isset($_POST['enviar'])) {
    // Verificar si 'carrera' está definida en $_POST
    if (isset($_POST['inscripcion_carrera'])) {
        // Obtener las fechas de inicio y fin desde el formulario
        $carrera = $_POST['inscripcion_carrera'];

        // Consultar la base de datos para obtener los datos de asistencia entre las fechas especificadas
        $consulta = "SELECT * FROM inscripcion_asignatura ia 
        INNER JOIN alumno a on ia.alumno_legajo = a.legajo 
        INNER JOIN preceptores p ON p.carreras_idCarrera = ia.carreras_idCarrera 
        WHERE ia.carreras_idCarrera = '$carrera'  and a.estado = '1'";
        $resultado = $conexion->query($consulta);

        // Verificar si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            // Crear un nuevo objeto Spreadsheet (similar a PHPExcel)
            $spreadsheet = new Spreadsheet();

            // Agregar una hoja al archivo Excel
            $sheet = $spreadsheet->getActiveSheet();

            // Escribir el encabezado en la primera fila
            $sheet->setCellValue('A1', 'Legajo');
            $sheet->setCellValue('B1', 'Apellido');
            $sheet->setCellValue('C1', 'Nombre');
            $sheet->setCellValue('D1', 'DNI');
            $sheet->setCellValue('E1', 'Celular');

            // Contador para la fila actual
            $row = 2;

            // Iterar sobre los resultados de la consulta
            while ($fila = $resultado->fetch_assoc()) {
                $sheet->setCellValue('A' . $row, $fila['legajo']);
                $sheet->setCellValue('B' . $row, $fila['apellido_alumno']);
                $sheet->setCellValue('C' . $row, $fila['nombre_alumno']);
                $sheet->setCellValue('D' . $row, $fila['dni_alumno']);
                $sheet->setCellValue('E' . $row, $fila['celular']);
                $row++;
            }

            // Configurar el tipo de contenido y la descarga del archivo
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Alumnos.xlsx"');
            header('Cache-Control: max-age=0');

            // Crear un objeto Writer para guardar el archivo Excel
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');

            // Finalizar la ejecución del script PHP
            exit;
        } else {
            echo "No se encontraron datos para la carrera seleccionada.";
            exit;
        }
    } else {
        echo "No se recibió el parámetro 'carrera' en el formulario.";
        exit;
    }
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

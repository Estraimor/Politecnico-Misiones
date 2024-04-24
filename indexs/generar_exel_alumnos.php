<?php
require './exel/vendor/autoload.php';

use Fpdf\Fpdf;

include '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['carrera'])) {
        $carrera = $_POST['carrera'];

        // Nombre de la institución
        $institucion = 'Instituto Superior Politécnico Misiones Nº 1';

        // Consultar el nombre de la carrera
        $consulta_carrera = "SELECT nombre_carrera FROM carreras WHERE idCarrera  = '$carrera'";
        $resultado_carrera = $conexion->query($consulta_carrera);
        $nombre_carrera = $resultado_carrera->fetch_assoc()['nombre_carrera'];

        // Consultar la base de datos para obtener los datos de los alumnos de la carrera seleccionada
        $consulta = "SELECT legajo, apellido_alumno, nombre_alumno, dni_alumno, celular
                     FROM inscripcion_asignatura ia 
                     INNER JOIN alumno a ON ia.alumno_legajo = a.legajo 
                     WHERE ia.carreras_idCarrera = '$carrera' AND a.estado = '1'
                     ORDER BY a.apellido_alumno";
        $resultado = $conexion->query($consulta);

        // Verificar si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            // Crear un nuevo objeto TCPDF
            $pdf = new Fpdf();
            $pdf->AddPage();

            // Insertar nombre de la institución
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 10, $institucion, 0, 1, 'C');

            // Insertar título
            $pdf->SetFont('Arial', 'B', 18);
            $pdf->Cell(0, 10, 'Lista de Alumnos', 0, 1, 'C');

            // Insertar nombre de la carrera
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(0, 10, $nombre_carrera, 0, 1, 'C');

            // Encabezados de los datos de los alumnos
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(10, 10, 'N°', 1, 0, 'C');
            $pdf->Cell(30, 10, 'Legajo', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Apellido', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C');
            $pdf->Cell(30, 10, 'DNI', 1, 0, 'C');
            $pdf->Cell(40, 10, 'Celular', 1, 1, 'C');

            // Datos de los alumnos
            while ($fila = $resultado->fetch_assoc()) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(10, 10, '', 0, 0, 'C');
                $pdf->Cell(30, 10, $fila['legajo'], 1, 0, 'C');
                $pdf->Cell(40, 10, $fila['apellido_alumno'], 1, 0, 'C');
                $pdf->Cell(40, 10, $fila['nombre_alumno'], 1, 0, 'C');
                $pdf->Cell(30, 10, $fila['dni_alumno'], 1, 0, 'C');
                $pdf->Cell(40, 10, $fila['celular'], 1, 1, 'C');
            }

            // Salida del PDF
            $pdf->Output('D', 'Alumnos_' . date('Y-m-d') . '.pdf');

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

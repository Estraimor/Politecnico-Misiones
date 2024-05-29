<?php
require '../../indexs/pdf/vendor/setasign/fpdf/fpdf.php';

include '../conexion/conexion.php';

    $materia = $_GET['materia'];
    $carrera = $_GET['carrera'];

$nombre_inst = utf8_decode('Instituto Superior Politécnico Misiones Nº 1');
// Nombre del archivo PDF con el nombre del alumno y su legajo
$nombre_archivo = "1er cautri o 2 do cuatri _$carrera.pdf";


class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        global $nombre_inst;
        // Espacio antes del encabezado de los datos
        $this->Ln(30); // Aumentar el valor para más espacio

        // Calcular la posición horizontal para centrar el rectángulo
        $xRect = ($this->GetPageWidth() - 190) / 2;

        // Color del rectángulo
        $this->SetFillColor(189, 213, 234); // Color BDD5EA

        // Encabezado solo en la primer página
        if ($this->PageNo() == 1) {
            // Dibujar rectángulo centrado
            $this->Rect($xRect, 10, 190, 47, 'F');
            // Título solo en la primer página
            $this->SetFont('Arial', 'B', 16);
            $this->SetTextColor(20, 13, 79); // Cambiar a color oscuro
            // Coordenadas para centrar verticalmente en el rectángulo
            $this->SetXY($xRect, 20);
            $this->Cell(210, 10, $nombre_inst, 0, 1, 'C');

            // Subtítulo solo en la primer página
            $this->SetFont('Arial', '', 14);
            // Coordenadas para centrar verticalmente en el rectángulo
            $this->SetXY($xRect, 30);

            // Logo
            $this->Image('../imagenes/politecnico.png', 15, 15, 37);
            // Arial bold 15
            $this->SetFont('Arial', 'B', 15);
            // Título
            // Nombre del alumno y legajo
            $this->Cell(0, 40, 'Alumno: ' . $GLOBALS['nombre_alumno'] . '  Legajo: ' . $GLOBALS['legajo'], 0, 1, 'C');
            // Salto de línea
            $this->Ln(10);
        }
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

try {
    // Crear instancia de FPDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // Consulta para obtener datos del alumno
    $sql_datos_notas = "SELECT a.dni_alumno, a.nombre_alumno, a.apellido_alumno, a.legajo, 
    f.tp_1, f.tp_2, f.parcial_1, f.recuperatorio1, f.to_3, f.tp_4, f.parcial_2, f.recuperatorio2,
    f.condicion_materia_idcondicion_materia, f.mesa_final, m.idMaterias  
FROM alumno a
JOIN materias m ON m.idMaterias = '$materia'
LEFT JOIN finales f ON a.legajo = f.alumno_legajo AND f.materias_idMaterias = m.idMaterias
LEFT JOIN inscripcion_asignatura ia ON a.legajo = ia.alumno_legajo AND m.carreras_idCarrera = ia.carreras_idCarrera
WHERE m.idMaterias = '$materia' AND ia.carreras_idCarrera = '$carrera';";
    $query_datos_alumno = mysqli_query($conexion, $sql_datos_alumno);

    if (!$query_datos_alumno) {
        throw new Exception("Error al obtener los datos del alumno: " . mysqli_error($conexion));
    }

      if ($row_datos_alumno = mysqli_fetch_assoc($query_datos_alumno)) {
        $pdf->SetFont('Arial', '', 18);
        $pdf->Cell(0, 10, '' , 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Apellido: ' . utf8_decode($row_datos_alumno['apellido_alumno']), 0, 1);
        $pdf->Cell(0, 10, 'Nombre: ' . utf8_decode($row_datos_alumno['nombre_alumno']), 0, 1);
        $pdf->Cell(0, 10, 'DNI: ' . utf8_decode($row_datos_alumno['dni_alumno']), 0, 1);
        $pdf->Cell(0, 10, 'Edad: ' . utf8_decode($row_datos_alumno['edad']), 0, 1);
        $pdf->Cell(0, 10, 'Observaciones: ' . utf8_decode($row_datos_alumno['observaciones']), 0, 1);
        $pdf->Cell(0, 10, 'Trabajo: ' . utf8_decode($row_datos_alumno['Trabaja_Horario']), 0, 1);
        $pdf->Cell(0, 10, 'Celular: ' . utf8_decode($row_datos_alumno['celular']), 0, 1);
        $pdf->Cell(0, 10, 'Carrera: ' . utf8_decode($row_datos_alumno['nombre_carrera']), 0, 1);
    }

    // Configurar el tipo de contenido y la descarga del archivo
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="' . $nombre_archivo . '"');
    header('Cache-Control: max-age=0');

    // Salida del PDF
    $pdf->Output('D', $nombre_archivo);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

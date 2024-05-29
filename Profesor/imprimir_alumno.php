<?php
require '../indexs/pdf/vendor/setasign/fpdf/fpdf.php';

include '../conexion/conexion.php';

$legajo = $_GET['legajo'];

// Obtener nombre del alumno
$sql_nombre_alumno = "SELECT nombre_alumno FROM alumno WHERE legajo  = '$legajo'";
$query_nombre_alumno = mysqli_query($conexion, $sql_nombre_alumno);
$row_nombre_alumno = mysqli_fetch_assoc($query_nombre_alumno);
$nombre_alumno = $row_nombre_alumno['nombre_alumno'];
$nombre_inst = utf8_decode('Instituto Superior Politécnico Misiones Nº 1');
// Nombre del archivo PDF con el nombre del alumno y su legajo
$nombre_archivo = "datos_alumno_$nombre_alumno-$legajo.pdf";


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
    $sql_datos_alumno = "SELECT *
                            FROM alumno a
                            INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.legajo
                            INNER JOIN carreras c ON c.idCarrera = ia.carreras_idCarrera 
                        WHERE legajo = '$legajo'";
    $query_datos_alumno = mysqli_query($conexion, $sql_datos_alumno);

    if (!$query_datos_alumno) {
        throw new Exception("Error al obtener los datos del alumno: " . mysqli_error($conexion));
    }

      if ($row_datos_alumno = mysqli_fetch_assoc($query_datos_alumno)) {
        $pdf->SetFont('Arial', '', 18);
        $pdf->Cell(0, 10, 'Datos del Estudiante' , 0, 1);
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

    // Consulta para obtener datos de asistencias
$sql_asistencias = "SELECT 
                        m.Nombre,
                        (SUM(CASE WHEN a.1_Horario = 'Presente' OR a.2_Horario = 'Presente' THEN 1 ELSE 0 END) + SUM(CASE WHEN a.1_Horario = 'Presente' AND a.2_Horario = 'Presente' THEN 1 ELSE 0 END)) AS asistencias,
                        (SUM(CASE WHEN a.1_Horario = 'Ausente' OR a.2_Horario = 'Ausente' THEN 1 ELSE 0 END) + SUM(CASE WHEN a.1_Horario = 'Ausente' AND a.2_Horario = 'Ausente' THEN 1 ELSE 0 END)) AS ausencias,
                        COUNT(*) AS total_clases
                    FROM 
                        asistencia a
                    INNER JOIN 
                        materias m ON a.materias_idMaterias = m.idMaterias
                    WHERE 
                        a.inscripcion_asignatura_alumno_legajo = '$legajo'
                    GROUP BY 
                        m.Nombre";

$query_asistencias = mysqli_query($conexion, $sql_asistencias);

if (!$query_asistencias) {
    throw new Exception("Error al obtener las asistencias: " . mysqli_error($conexion));
}

// Generar tabla de asistencias
// Generar tabla de asistencias
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 18);
$pdf->Cell(0, 10, 'Asistencias', 0, 1);
$pdf->SetFont('Arial', '', 13);
$pdf->Cell(0, 10, 'Materia: ', 0, 0);
$pdf->Cell(0, 10, 'Presente: ' . '%', 0, 0);
$pdf->Cell(0, 10, 'Ausente: ' . '%', 0, 1);

while ($row_asistencias = mysqli_fetch_assoc($query_asistencias)) {
    $porcentaje_asistencia = $row_asistencias['asistencias'] * 100.0 / $row_asistencias['total_clases'];
    $porcentaje_ausencia = $row_asistencias['ausencias'] * 100.0 / $row_asistencias['total_clases'];

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, utf8_decode($row_asistencias['Nombre']), 0, 0);
    $pdf->Cell(0, 10, utf8_decode(number_format($porcentaje_asistencia, 2)) . '%', 0, 0);
    $pdf->Cell(0, 10, utf8_decode(number_format($porcentaje_ausencia, 2)) . '%', 0, 1);
}


    // Consulta para obtener datos de justificaciones
    $sql_justificaciones = "SELECT * FROM alumnos_justificados WHERE inscripcion_asignatura_alumno_legajo  = '$legajo'";
    $query_justificaciones = mysqli_query($conexion, $sql_justificaciones);

    if (!$query_justificaciones) {
        throw new Exception("Error al obtener las justificaciones: " . mysqli_error($conexion));
    }

    // Generar tabla de justificaciones
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Justificaciones', 0, 1);
    // Agregar más celdas y datos según sea necesario...

    // Consulta para obtener datos de ratificaciones
    $sql_ratificaciones = "SELECT * FROM alumnos_rat WHERE alumno_legajo  = '$legajo'";
    $query_ratificaciones = mysqli_query($conexion, $sql_ratificaciones);

    if (!$query_ratificaciones) {
        throw new Exception("Error al obtener las ratificaciones: " . mysqli_error($conexion));
    }

    // Generar tabla de ratificaciones
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Ratificaciones', 0, 1);
    // Agregar más celdas y datos según sea necesario...

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

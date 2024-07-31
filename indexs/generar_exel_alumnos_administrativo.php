<?php
require './pdf/vendor/setasign/fpdf/fpdf.php';
include '../conexion/conexion.php';

// Variables globales para almacenar los nombres
$nombre_carrera = '';
$nombre_curso = '';
$nombre_comision = '';
$nombre_inst = 'Instituto Superior Politécnico Misiones Nº 1';

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        global $nombre_carrera, $nombre_curso, $nombre_comision, $nombre_inst;

        // Espacio antes del encabezado de los datos
        $this->Ln(30);

        // Calcular la posición horizontal para centrar el rectángulo
        $xRect = ($this->GetPageWidth() - 190) / 2;

        // Color del rectángulo
        $this->SetFillColor(189, 213, 234);

        // Encabezado solo en la primera página
        if ($this->PageNo() == 1) {
            // Dibujar rectángulo centrado
            $this->Rect($xRect, 10, 180, 40, 'F');
            // Título solo en la primera página
            $this->SetFont('Arial', 'B', 16);
            $this->SetTextColor(20, 13, 79);
            $this->SetXY($xRect, 20);
            $this->Cell(190, 10, iconv('UTF-8', 'ISO-8859-1', $nombre_inst), 0, 1, 'C');

            // Subtítulo solo en la primera página
            $this->SetFont('Arial', '', 14);
            $this->SetXY($xRect, 30);
            $this->Cell(190, 10, iconv('UTF-8', 'ISO-8859-1', "Carrera: $nombre_carrera - Curso: $nombre_curso - Comisión: $nombre_comision"), 0, 1, 'C');
            
            // Espacio después del subtítulo
            $this->Ln(10);
        }

        // Mostrar la imagen en la misma posición en todas las páginas
        $this->Image('../imagenes/politecnico.png', $xRect + 5, 15, 20);

        // Encabezados de las columnas
        $this->SetFillColor(205, 237, 253);
        $this->SetTextColor(0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(10, 10, 'N', 1, 0, 'C', true); // Encabezado para el contador
        $this->Cell(50, 10, 'Apellido', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(70, 10, 'DNI', 1, 1, 'C', true);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Verificar que los datos sean válidos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['carrera']) && isset($_POST['curso']) && isset($_POST['comision'])) {
        $carrera = intval($_POST['carrera']);
        $curso = intval($_POST['curso']);
        $comision = intval($_POST['comision']);

        global $nombre_carrera, $nombre_curso, $nombre_comision;

        // Consultar el nombre de la carrera, curso y comisión
        $consulta_carrera = "SELECT c.nombre_carrera, cu.nombre_curso, co.N_comicion 
                             FROM carreras c
                             INNER JOIN cursos cu ON cu.idcursos = ?
                             INNER JOIN comisiones co ON co.idComisiones = ?
                             WHERE c.idCarrera = ?";
        $stmt_carrera = $conexion->prepare($consulta_carrera);
        $stmt_carrera->bind_param('iii', $curso, $comision, $carrera);
        $stmt_carrera->execute();
        $resultado_carrera = $stmt_carrera->get_result();
        $row = $resultado_carrera->fetch_assoc();
        $nombre_carrera = $row['nombre_carrera'];
        $nombre_curso = $row['nombre_curso'];
        $nombre_comision = $row['N_comicion'];

        $consulta = "SELECT a.apellido_alumno, a.nombre_alumno, a.dni_alumno
             FROM inscripcion_asignatura ia 
             INNER JOIN alumno a ON ia.alumno_legajo = a.legajo 
             INNER JOIN materias m ON ia.materias_idMaterias = m.idMaterias
             WHERE m.carreras_idCarrera = ? AND ia.cursos_idcursos = ? AND ia.comisiones_idComisiones = ? AND a.estado = '1'
             GROUP BY a.legajo
             ORDER BY a.apellido_alumno";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param('iii', $carrera, $curso, $comision);
$stmt->execute();
$resultado = $stmt->get_result();

        // Verificar si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            // Crear un nuevo objeto PDF personalizado
            $pdf = new PDF();
            $pdf->AddPage();

            $contador = 1; // Variable contador
            while ($fila = $resultado->fetch_assoc()) {
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(10, 10, $contador, 1, 0, 'C');
                $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', $fila['apellido_alumno']), 1, 0, 'C');
                $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', $fila['nombre_alumno']), 1, 0, 'C');
                $pdf->Cell(70, 10, $fila['dni_alumno'], 1, 1, 'C');
                $contador++; // Incrementar el contador
            }

            // Salida del PDF
            $nombre_archivo = "Alumnos_{$nombre_carrera}_{$nombre_curso}_{$nombre_comision}_" . date('Y-m-d') . '.pdf';
            $pdf->Output('D', $nombre_archivo);

            // Finalizar la ejecución del script PHP
            exit;
        } else {
            echo "<script>alert('No se encontraron datos de alumnos para la carrera seleccionada.'); window.location.href = '../index.php';</script>";
        }
    } else {
        echo "Faltan datos. Por favor, selecciona carrera, curso y comisión.";
    }
} else {
    echo "Acceso denegado.";
}
?>
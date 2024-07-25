<?php
require './pdf/vendor/setasign/fpdf/fpdf.php';
include '../conexion/conexion.php';

// Variable global para almacenar el nombre de la carrera
$nombre_carrera = '';
$nombre_inst = 'Instituto Superior Politécnico Misiones Nº 1';

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        global $nombre_carrera, $nombre_inst, $subtitulo, $carrera;

        // Espacio antes del encabezado de los datos
        $this->Ln(30); // Aumentar el valor para más espacio

        // Calcular la posición horizontal para centrar el rectángulo
        $xRect = ($this->GetPageWidth() - 190) / 2;

        // Color del rectángulo
        $this->SetFillColor(189, 213, 234); // Color BDD5EA

        // Encabezado solo en la primer página
        if ($this->PageNo() == 1) {
            // Dibujar rectángulo centrado
            $this->Rect($xRect, 10, 180, 40, 'F');
            // Título solo en la primer página
            $this->SetFont('Arial', 'B', 16);
            $this->SetTextColor(20, 13, 79); // Cambiar a color oscuro
            // Coordenadas para centrar verticalmente en el rectángulo
            $this->SetXY($xRect, 20);
            $this->Cell(190, 10, $nombre_inst, 0, 1, 'C');

            // Subtítulo solo en la primer página
            $this->SetFont('Arial', '', 14);
            // Coordenadas para centrar verticalmente en el rectángulo
            $this->SetXY($xRect, 30);
            // Lógica de transformación del nombre de la carrera
            switch ($carrera) {
                case "18":
                    $subtitulo = "Enfermería Primer Año Comisión A";
                    break;
                case "19":
                    $subtitulo = "Enfermería Primer Año Comisión B";
                    break;
                // Añadir más casos según sea necesario
                default:
                    $subtitulo = "Carrera no especificada";
                    break;
            }
            $this->Cell(190, 10, $subtitulo, 0, 1, 'C');
            
            // Espacio después del subtítulo
            $this->Ln(10);
        }

        // Mostrar la imagen en la misma posición en todas las páginas
        $this->Image('../imagenes/politecnico.png', $xRect + 5, 15, 20);

        // Encabezados de las columnas
        $this->SetFillColor(205, 237, 253); // Color púrpura 140D4F
        $this->SetTextColor(0); // Blanco
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(10, 10, 'N', 1, 0, 'C', true); // Encabezado para el contador
        $this->Cell(50, 10, 'Apellido', 1, 0, 'C', true); // Encabezado para el apellido
        $this->Cell(50, 10, 'Nombre', 1, 0, 'C', true); // Encabezado para el nombre
        $this->Cell(70, 10, 'DNI', 1, 1, 'C', true); // Encabezado para el DNI
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
    if (isset($_POST['carrera'])) {
        global $nombre_carrera;

        $carrera = $_POST['carrera'];

        // Consultar el nombre de la carrera
        $consulta_carrera = "SELECT nombre_carrera FROM carreras WHERE idCarrera = ?";
        $stmt_carrera = $conexion->prepare($consulta_carrera);
        $stmt_carrera->bind_param('i', $carrera);
        $stmt_carrera->execute();
        $resultado_carrera = $stmt_carrera->get_result();
        $nombre_carrera = $resultado_carrera->fetch_assoc()['nombre_carrera'];

        // Consultar la base de datos para obtener los datos de los alumnos de la carrera seleccionada
        $consulta = "SELECT apellido_alumno, nombre_alumno, dni_alumno
                     FROM inscripcion_asignatura ia 
                     INNER JOIN alumno a ON ia.alumno_legajo = a.legajo 
                     INNER JOIN materias m on ia.materias_idMaterias = m.idMaterias
                     WHERE m.carreras_idCarrera = ? AND a.estado = '1'
                     GROUP BY a.legajo
                     ORDER BY a.apellido_alumno
                     ";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param('i', $carrera);
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
                $pdf->Cell(50, 10, $fila['apellido_alumno'], 1, 0, 'C');
                $pdf->Cell(50, 10, $fila['nombre_alumno'], 1, 0, 'C');
                $pdf->Cell(70, 10, $fila['dni_alumno'], 1, 1, 'C');
                $contador++; // Incrementar el contador
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
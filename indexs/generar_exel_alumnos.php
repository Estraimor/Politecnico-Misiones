<?php
require './pdf/vendor/setasign/fpdf/fpdf.php';

include '../conexion/conexion.php';

// Variable global para almacenar el nombre de la carrera
$nombre_carrera = '';
$nombre_inst = utf8_decode('Instituto Superior Politécnico Misiones Nº 1');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        global $nombre_carrera, $nombre_inst, $subtitulo,$carrera;

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
                    $subtitulo = "Enfermeia Primer Año Comision A";
                    break;
                case "19":
                    $subtitulo = "Enfermeria Primer Año Comision B";
                    break;
                case "20":
                    $subtitulo = "Enfermeria Primer Año Comision C";
                    break;
                case "33":
                    $subtitulo = "Enfermeria Segundo Año Comision A";
                    break;
                case "34":
                    $subtitulo = "Enfermeria Segundo Año Comision B";
                    break;
                case "35":
                    $subtitulo = "Enfermeria Segundo Año Comision C";
                    break;
                case "36":
                    $subtitulo = "Enfermeria Tercer Año Comision A";
                    break;
                case "37":
                    $subtitulo = "Enfermeria Tercer Año Comision B";
                    break;
                case "39":
                    $subtitulo = "Enfermeria Tercer Año Comision C";
                    break;
                case "27":
                    $subtitulo = "Acompañante Terapeutico Primer Año Comision A";
                    break;
                case "31":
                    $subtitulo = "Acompañante Terapeutico Primer Año Comision B";
                    break;
                case "32":
                    $subtitulo = "Acompañante Terapeutico Primer Año Comision C";
                    break;
                case "40":
                    $subtitulo = "Acompañante Terapeutico Segundo Año Comision A";
                    break;
                case "41":
                    $subtitulo = "Acompañante Terapeutico Segundo Año Comision B";
                    break;
                case "42":
                    $subtitulo = "Acompañante Terapeutico Segundo Año Comision C";
                    break;
                case "43":
                    $subtitulo = "Acompañante Terapeutico Tercer Año Comision A";
                    break;
                case "44":
                    $subtitulo = "Acompañante Terapeutico Tercer Año Comision B";
                    break;
                case "45":
                    $subtitulo = "Acompañante Terapeutico Tercer Año Comision C";
                    break;
                case "46":
                    $subtitulo = "Automatizacion y Robotica Primer Año Comision A";
                    break;
                case "47":
                    $subtitulo = "Automatizacion y Robotica Primer Año Comision B";
                    break;
                case "48":
                    $subtitulo = "Automatizacion y Robotica Primer Año Comision C";
                    break;
                case "49":
                    $subtitulo = "Automatizacion y Robotica Segundo Año Comision A";
                    break;
                case "50":
                    $subtitulo = "Automatizacion y Robotica Segundo Año Comision B";
                    break;
                case "51":
                    $subtitulo = "Automatizacion y Robotica Segundo Año Comision C";
                    break;
                case "52":
                    $subtitulo = "Automatizacion y Robotica Tercer Año Comision A";
                    break;
                case "53":
                    $subtitulo = "Automatizacion y Robotica Tercer Año Comision B";
                    break;
                case "54":
                    $subtitulo = "Automatizacion y Robotica Tercer Año Comision C";
                    break;
                case "55":
                    $subtitulo = "Comercializacion y Marketing Primer Año Comision A";
                    break;
                case "56":
                    $subtitulo = "Comercializacion y Marketing Primer Año Comision B";
                    break;
                case "57":
                    $subtitulo = "Comercializacion y Marketing Primer Año Comision C";
                    break;
                case "58":
                    $subtitulo = "Comercializacion y Marketing Segundo Año Comision A";
                    break;
                case "59":
                    $subtitulo = "Comercializacion y Marketing Segundo Año Comision B";
                    break;
                case "60":
                    $subtitulo = "Comercializacion y Marketing Segundo Año Comision C";
                    break;
                case "61":
                    $subtitulo = "Comercializacion y Marketing Tercer Año Comision A";
                    break;
                case "62":
                    $subtitulo = "Comercializacion y Marketing Tercer Año Comision B";
                    break;
                case "63":
                    $subtitulo = "Comercializacion y Marketing Tercer Año Comision C";
                    break;
                default:
                    // Si no coincide con ningún caso, mantener el nombre original
                    break;
            }
            $this->Cell(190, 10, utf8_decode($subtitulo), 0, 1, 'C');
            
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['carrera'])) {
        global $nombre_carrera;

        $carrera = $_POST['carrera'];

        // Consultar el nombre de la carrera
        $consulta_carrera = "SELECT nombre_carrera FROM carreras WHERE idCarrera  = '$carrera'";
        $resultado_carrera = $conexion->query($consulta_carrera);
        $nombre_carrera = utf8_decode($resultado_carrera->fetch_assoc()['nombre_carrera']);

        // Consultar la base de datos para obtener los datos de los alumnos de la carrera seleccionada
        $consulta = "SELECT apellido_alumno, nombre_alumno, dni_alumno
                     FROM inscripcion_asignatura ia 
                     INNER JOIN alumno a ON ia.alumno_legajo = a.legajo 
                     WHERE ia.carreras_idCarrera = '$carrera' AND a.estado = '1'
                     ORDER BY a.apellido_alumno";
        $resultado = $conexion->query($consulta);

        // Verificar si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            // Crear un nuevo objeto PDF personalizado
            $pdf = new PDF();
            $pdf->AddPage();

           $contador = 1; // Variable contador
            while ($fila = $resultado->fetch_assoc()) {
             $pdf->SetFont('Arial', '', 12);
        // Mostrar el contador antes del nombre del alumno
            $pdf->Cell(10, 10, $contador, 1, 0, 'C');
            $pdf->Cell(50, 10, utf8_decode($fila['apellido_alumno']), 1, 0, 'C');
            $pdf->Cell(50, 10, utf8_decode($fila['nombre_alumno']), 1, 0, 'C');
            $pdf->Cell(70, 10, utf8_decode($fila['dni_alumno']), 1, 1, 'C');
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

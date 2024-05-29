<?php
require './pdf/vendor/setasign/fpdf/fpdf.php';

include'../conexion/conexion.php';
$nombre_inst = utf8_decode('Instituto Superior Politécnico Misiones Nº 1');

class PDF extends FPDF {
    function Header() {
        global $nombre_inst, $carrera, $fechas_con_asistencia;

        // Encabezado solo en la primera página
        if ($this->PageNo() == 1) {
            $this->SetFillColor(189, 213, 234); // Color del cuadro
            $this->Rect(10, 7, 190, 50, 'F'); // Rectángulo
            $this->SetXY(10, 1); // Ajuste de la posición Y
            $this->SetFont('Arial', 'B', 12);
            $this->Image('../imagenes/politecnico.png', 15, 15, 37); // Colocar la imagen
            $this->Cell(0, 35, $nombre_inst, 0, 1, 'C');
            $this->SetFont('Arial', 'I', 10);
            // Determinar el subtítulo basado en el valor de $carrera
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
            $this->Cell(180, 26, utf8_decode($subtitulo), 0, 1, 'C');
            // Ajuste de la posición para que esté más cerca del encabezado de datos
            $this->SetY(51); // Posición Y más cerca del encabezado de datos
            // Imprimir la fecha de inicio y fin
            $this->Cell(0, 5, 'Fecha de inicio: ' . $_POST['fecha_inicio'] . ' - Fecha de fin: ' . $_POST['fecha_fin'], 0, 1, 'C');
            // Salto de línea adicional para separar el encabezado del contenido de datos
            $this->Ln(1);
        } else {
            // Encabezado para las páginas siguientes
            $this->SetFont('Arial', '', 10);
            $this->Image('../imagenes/politecnico.png', 15, 15, 20); // Colocar la imagen
            $this->Ln(30);
            $this->Cell(50, 7, 'Nombres', 1);
            foreach ($fechas_con_asistencia as $fecha) {
                $this->Cell(10, 7, date('d/m', strtotime($fecha)), 1, 0, 'C');
            }
            $this->Ln();
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las fechas de inicio y fin desde el formulario
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
    $carrera = isset($_POST['carrera']) ? $_POST['carrera'] : null;




    if ($fecha_inicio && $fecha_fin && $carrera) {
        // Consultar la base de datos para obtener los datos de asistencia entre las fechas especificadas
        $consulta_asistencia = "SELECT DISTINCT fecha
        FROM asistencia a 
        INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.inscripcion_asignatura_alumno_legajo 
        INNER JOIN alumno a2 ON a2.legajo = ia.alumno_legajo INNER JOIN carreras c ON c.idCarrera = ia.carreras_idCarrera 
        INNER JOIN materias m ON m.idMaterias = a.materias_idMaterias 
        WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' and c.idCarrera = '$carrera';";
        $resultado_fechas = $conexion->query($consulta_asistencia);
        
        $fechas_asistencia = [];
        while ($row = $resultado_fechas->fetch_assoc()) {
            $fechas_asistencia[] = $row['fecha'];
        }

        // Obtener las fechas esperadas dentro del rango de fechas de inicio y fin
        $fechas_esperadas = [];
        $temp_fecha = $fecha_inicio;
        while ($temp_fecha <= $fecha_fin) {
            $fechas_esperadas[] = $temp_fecha;
            $temp_fecha = date('Y-m-d', strtotime($temp_fecha . ' +1 day'));
        }

        // Filtrar las fechas de asistencia para eliminar las fechas sin registros
        $fechas_con_asistencia = array_intersect($fechas_esperadas, $fechas_asistencia);

        // Verificar si se obtuvieron resultados de asistencia
        if ($fechas_con_asistencia) {
            // Crear un objeto FPDF para el documento PDF
            $pdf = new PDF();
            $pdf->AddPage();

            // Establecer la fuente y el tamaño del texto
            $pdf->SetFont('Arial', '', 10);

            // Cabecera del PDF
            $pdf->SetFillColor(200, 220, 255); // Color de fondo de la cabecera
            $pdf->SetTextColor(0); // Color del texto de la cabecera

            // Imprimir las fechas en la primera fila del PDF
            $pdf->Cell(50, 7, 'Nombres', 1); // Celda vacía para la esquina superior izquierda
            foreach ($fechas_con_asistencia as $fecha) {
                $pdf->Cell(10, 7, date('d/m', strtotime($fecha)), 1, 0, 'C');
            }
            $pdf->Ln();

            // Consultar la asistencia para las fechas obtenidas
            // Consultar la asistencia para las fechas obtenidas
$consulta_asistencia = "SELECT CONCAT(a2.apellido_alumno, ' ', a2.nombre_alumno) AS nombre_completo,
                        a.fecha AS fecha,
                        a.1_Horario AS horario_1,
                        a.2_Horario AS horario_2
                        FROM asistencia a 
                        INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.inscripcion_asignatura_alumno_legajo 
                        INNER JOIN alumno a2 ON a2.legajo = ia.alumno_legajo 
                        INNER JOIN carreras c ON c.idCarrera = ia.carreras_idCarrera 
                        INNER JOIN materias m ON m.idMaterias = a.materias_idMaterias 
                        WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' AND c.idCarrera = '$carrera'
                        ORDER BY a2.apellido_alumno, a2.nombre_alumno, a.fecha;";

$resultado_asistencia = $conexion->query($consulta_asistencia);

// Construir un array multidimensional para almacenar la asistencia de cada alumno por fecha
$asistencias_por_alumno = [];
while ($fila_asistencia = $resultado_asistencia->fetch_assoc()) {
    $nombre = utf8_decode($fila_asistencia['nombre_completo']);
    $fecha = $fila_asistencia['fecha'];
    $horario_1 = $fila_asistencia['horario_1'];
    $horario_2 = $fila_asistencia['horario_2'];

    // Si el alumno no está en el array, inicializamos su asistencia
    if (!isset($asistencias_por_alumno[$nombre])) {
        $asistencias_por_alumno[$nombre] = [];
    }

    // Determinar la asistencia y guardarla en el array de asistencias
    if ($horario_1 == 'Presente' && $horario_2 == 'Presente') {
        $asistencia = 'P';
    } elseif ($horario_1 == 'Presente' && ($horario_2 == 'ausente' || $horario_2 == 'Ausente')) {
        $asistencia = 'P';
    } elseif (($horario_1 == 'ausente' || $horario_1 == 'Ausente') && $horario_2 == 'Presente') {
        $asistencia = 'P';
    } elseif ($horario_1 == 'Presente' && $horario_2 == '') {
        $asistencia = 'P';
    } elseif ($horario_1 == '' && $horario_2 == 'Presente') {
        $asistencia = 'P';
    } elseif (($horario_1 == 'ausente' || $horario_1 == 'Ausente') && ($horario_2 == 'ausente' || $horario_2 == 'Ausente')) {
        $asistencia = 'A';
    } elseif (($horario_1 == 'ausente' || $horario_1 == 'Ausente') && $horario_2 == '') {
        $asistencia = 'A';
    } elseif ($horario_1 == '' && ($horario_2 == 'ausente' || $horario_2 == 'Ausente')) {
        $asistencia = 'A';
    } elseif ($horario_1 == '' || $horario_2 == '') {
        $asistencia = 'P/N';
    }

    // Almacenar la asistencia para este alumno y esta fecha
    $asistencias_por_alumno[$nombre][$fecha] = $asistencia;
}
$contador = 1;
// Ancho máximo permitido para el nombre
$ancho_maximo = 40;

// Imprimir nombres y asistencias
foreach ($asistencias_por_alumno as $nombre => $asistencias) {
    // Verificar si el alumno tiene asistencia para alguna de las fechas
    $tiene_asistencia = false;
    foreach ($fechas_asistencia as $fecha_asistencia) {
        if (isset($asistencias[$fecha_asistencia])) {
            $tiene_asistencia = true;
            break;
        }
    }

    // Si el alumno tiene asistencia para alguna fecha, imprimir su asistencia
    if ($tiene_asistencia) {
        // Imprimir el contador
        $pdf->Cell(6, 7, $contador++, 1); // Imprimir el contador

        // Verificar el ancho del nombre
        $ancho_nombre = $pdf->GetStringWidth($nombre);
        
        // Cortar el nombre si supera el ancho máximo
        if ($ancho_nombre > $ancho_maximo) {
            // Calcular cuántos caracteres deben mostrarse según el ancho máximo
            $caracteres_a_mostrar = floor($ancho_maximo / $pdf->GetStringWidth('A')); // Ancho aproximado de un carácter
            
            // Cortar el nombre
            $nombre_cortado = mb_substr($nombre, 0, $caracteres_a_mostrar); // Usamos mb_substr para manejar correctamente caracteres multibyte
        } else {
            $nombre_cortado = $nombre; // El nombre no necesita ser cortado
        }

        // Imprimir el nombre del alumno
        $pdf->Cell(44, 7, $nombre_cortado, 1);

        // Imprimir asistencia para cada fecha con asistencia
        foreach ($fechas_asistencia as $fecha) {
            $asistencia = isset($asistencias[$fecha]) ? $asistencias[$fecha] : 'A'; // Si no hay asistencia para esta fecha, se marca como ausente
            $pdf->Cell(10, 7, $asistencia, 1, 0, 'C');
        }
        $pdf->Ln(); // Saltar a la siguiente línea
    }
}
    
          // Obtener el subtítulo según la carrera seleccionada
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

// Generar el nombre del archivo PDF incluyendo el subtítulo
$nombre_archivo = 'Asistencia_' . $subtitulo . '_' . $fecha_inicio . '_al_' . $fecha_fin . '.pdf';
$nombre_archivo = utf8_decode($nombre_archivo);

// Configurar el tipo de contenido y la descarga del archivo
header('Content-Type: application/pdf');
header('Content-Disposition: attachment;filename="' . $nombre_archivo . '"');
header('Cache-Control: max-age=0');

// Salida del PDF
$pdf->Output('D', $nombre_archivo);

// Finalizar la ejecución del script PHP
exit;
        } else {
            echo "No hay registros de asistencia para las fechas especificadas.";
        }
    } else {
        echo "Error: Por favor, seleccione la fecha de inicio, la fecha de fin y la carrera.";
    }
} else {
    echo "Error: Método de solicitud no válido.";
}
?>

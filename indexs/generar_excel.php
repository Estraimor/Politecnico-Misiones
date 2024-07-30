<?php
require './pdf/vendor/setasign/fpdf/fpdf.php';
include '../conexion/conexion.php';

$nombre_inst = mb_convert_encoding('Instituto Superior Politécnico Misiones Nº 1', 'ISO-8859-1', 'UTF-8');

class PDF extends FPDF {
    function Header() {
        global $nombre_inst, $fechas_con_asistencia, $subtitulo;

        if ($this->PageNo() == 1) {
            $this->SetFillColor(189, 213, 234);
            $this->Rect(10, 7, 190, 50, 'F');
            $this->SetXY(10, 1);
            $this->SetFont('Arial', 'B', 12);
            $this->Image('../imagenes/politecnico.png', 15, 15, 37);
            $this->Cell(0, 35, $nombre_inst, 0, 1, 'C');
            $this->SetFont('Arial', 'I', 10);
            $this->Cell(180, 26, mb_convert_encoding($subtitulo, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
            $this->SetY(51);
            $this->Cell(0, 5, 'Fecha de inicio: ' . $_POST['fecha_inicio'] . ' - Fecha de fin: ' . $_POST['fecha_fin'], 0, 1, 'C');
            $this->Ln(1);
        } else {
            $this->SetFont('Arial', '', 10);
            $this->Image('../imagenes/politecnico.png', 15, 15, 20);
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
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
    $carrera = isset($_POST['carrera_curso_comision']) ? $_POST['carrera_curso_comision'] : null;
    $curso = isset($_POST['curso']) ? $_POST['curso'] : null;
    $comision = isset($_POST['comision']) ? $_POST['comision'] : null;

    

    if ($fecha_inicio && $fecha_fin && $carrera && $curso && $comision) {
        $consulta_datos = "
            SELECT c.nombre_carrera, cu.nombre_curso, co.N_comicion 
            FROM carreras c
            INNER JOIN cursos cu ON cu.idcursos = ?
            INNER JOIN comisiones co ON co.idComisiones = ?
            WHERE c.idCarrera = ?
        ";
        $stmt_datos = $conexion->prepare($consulta_datos);
        $stmt_datos->bind_param('iii', $curso, $comision, $carrera);
        $stmt_datos->execute();
        $resultado_datos = $stmt_datos->get_result();

        if ($resultado_datos->num_rows > 0) {
            $datos = $resultado_datos->fetch_assoc();
            $nombre_carrera = $datos['nombre_carrera'];
            $nombre_curso = $datos['nombre_curso'];
            $nombre_comision = $datos['N_comicion'];
        } else {
            die("Error: No se encontraron datos para los identificadores proporcionados.");
        }

        $subtitulo = "$nombre_carrera - Curso: $nombre_curso - Comisión: $nombre_comision";

        $consulta_asistencia = "
            SELECT DISTINCT fecha
            FROM asistencia a 
            INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.inscripcion_asignatura_alumno_legajo 
            INNER JOIN alumno a2 ON a2.legajo = ia.alumno_legajo 
            WHERE a.fecha BETWEEN ? AND ? 
            AND a.carreras_idCarrera = ? 
            AND a.cursos_idcursos = ? 
            AND a.comisiones_idComisiones = ?
        ";
        $stmt_asistencia = $conexion->prepare($consulta_asistencia);
        $stmt_asistencia->bind_param('ssiii', $fecha_inicio, $fecha_fin, $carrera, $curso, $comision);
        $stmt_asistencia->execute();
        $resultado_fechas = $stmt_asistencia->get_result();
        
        $fechas_asistencia = [];
        while ($row = $resultado_fechas->fetch_assoc()) {
            $fechas_asistencia[] = $row['fecha'];
        }

        $fechas_esperadas = [];
        $temp_fecha = $fecha_inicio;
        while ($temp_fecha <= $fecha_fin) {
            $fechas_esperadas[] = $temp_fecha;
            $temp_fecha = date('Y-m-d', strtotime($temp_fecha . ' +1 day'));
        }

        $fechas_con_asistencia = array_intersect($fechas_esperadas, $fechas_asistencia);

        if ($fechas_con_asistencia) {
            $pdf = new PDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetFillColor(200, 220, 255);
            $pdf->SetTextColor(0);
            $pdf->Cell(50, 7, 'Nombres', 1);

            foreach ($fechas_con_asistencia as $fecha) {
                $pdf->Cell(10, 7, date('d/m', strtotime($fecha)), 1, 0, 'C');
            }
            $pdf->Ln();

            $consulta_asistencia = "
                SELECT CONCAT(a2.apellido_alumno, ' ', a2.nombre_alumno) AS nombre_completo, a.fecha, a.asistencia
                FROM asistencia a 
                INNER JOIN inscripcion_asignatura ia ON ia.alumno_legajo = a.inscripcion_asignatura_alumno_legajo 
                INNER JOIN alumno a2 ON a2.legajo = ia.alumno_legajo 
                WHERE a.fecha BETWEEN ? AND ? 
                AND a.carreras_idCarrera = ? 
                AND a.cursos_idcursos = ? 
                AND a.comisiones_idComisiones = ?
                ORDER BY a2.apellido_alumno, a2.nombre_alumno, a.fecha
            ";
            $stmt_asistencia_detalle = $conexion->prepare($consulta_asistencia);
            $stmt_asistencia_detalle->bind_param('ssiii', $fecha_inicio, $fecha_fin, $carrera, $curso, $comision);
            $stmt_asistencia_detalle->execute();
            $resultado_asistencia = $stmt_asistencia_detalle->get_result();

            $asistencias_por_alumno = [];
            while ($fila_asistencia = $resultado_asistencia->fetch_assoc()) {
                $nombre = mb_convert_encoding($fila_asistencia['nombre_completo'], 'ISO-8859-1', 'UTF-8');
                $fecha = $fila_asistencia['fecha'];
                $asistencia = $fila_asistencia['asistencia'];

                if (!isset($asistencias_por_alumno[$nombre])) {
                    $asistencias_por_alumno[$nombre] = [];
                }

                $asistencias_por_alumno[$nombre][$fecha] = $asistencia == 'Presente' ? 'P' : 'A';
            }

            $contador = 1;
            $ancho_maximo = 40;

            foreach ($asistencias_por_alumno as $nombre => $asistencias) {
                $tiene_asistencia = false;
                foreach ($fechas_asistencia as $fecha_asistencia) {
                    if (isset($asistencias[$fecha_asistencia])) {
                        $tiene_asistencia = true;
                        break;
                    }
                }

                if ($tiene_asistencia) {
                    $pdf->Cell(6, 7, $contador++, 1);
                    $ancho_nombre = $pdf->GetStringWidth($nombre);
                    $nombre_cortado = $ancho_nombre > $ancho_maximo ? mb_substr($nombre, 0, floor($ancho_maximo / $pdf->GetStringWidth('A'))) : $nombre;
                    $pdf->Cell(44, 7, $nombre_cortado, 1);

                    foreach ($fechas_asistencia as $fecha) {
                        $asistencia = isset($asistencias[$fecha]) ? $asistencias[$fecha] : 'A';
                        $pdf->Cell(10, 7, $asistencia, 1, 0, 'C');
                    }
                    $pdf->Ln();
                }
            }

            $nombre_archivo = 'Asistencia_' . $subtitulo . '_' . $fecha_inicio . '_al_' . $fecha_fin . '.pdf';
            $nombre_archivo = mb_convert_encoding($nombre_archivo, 'ISO-8859-1', 'UTF-8');

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename="' . $nombre_archivo . '"');
            header('Cache-Control: max-age=0');

            $pdf->Output('D', $nombre_archivo);
            exit;
        } else {
            echo "No hay registros de asistencia para las fechas especificadas.";
        }
    } else {
        echo "Error: Por favor, seleccione la fecha de inicio, la fecha de fin, la carrera, el curso y la comisión.";
    }
} else {
    echo "Error: Método de solicitud no válido.";
}
?>

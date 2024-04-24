<?php
require '../indexs/exel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include '../conexion/conexion.php';

$legajo = $_GET['legajo'];
// Definir el nombre del archivo
$filename = 'datos_alumno_' . $legajo . '.xlsx';
try {
    // Crear una nueva instancia de Spreadsheet
    $spreadsheet = new Spreadsheet();

    // Crear hojas de cálculo para cada sección
    $sheet_alumno = $spreadsheet->createSheet(0);
    $sheet_alumno->setTitle('Datos del Alumno');
    $sheet_asistencias = $spreadsheet->createSheet(1);
    $sheet_asistencias->setTitle('Asistencias');
    $sheet_justificaciones = $spreadsheet->createSheet(2);
    $sheet_justificaciones->setTitle('Justificaciones');
    $sheet_ratificaciones = $spreadsheet->createSheet(3);
    $sheet_ratificaciones->setTitle('Reirado antes de tiempo');

    // Escribir datos del alumno en la hoja correspondiente
    $sheet_alumno->setCellValue('A1', 'Apellido');
    $sheet_alumno->setCellValue('B1', 'Nombre');
    $sheet_alumno->setCellValue('C1', 'DNI');
    $sheet_alumno->setCellValue('D1', 'Legajo');
    $sheet_alumno->setCellValue('E1', 'Edad');
    $sheet_alumno->setCellValue('F1', 'Observaciones');
    $sheet_alumno->setCellValue('G1', 'Trabajo');
    $sheet_alumno->setCellValue('H1', 'Celular');
    $sheet_alumno->setCellValue('I1', 'Carrera');

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

    $rowIndex = 2; // Empieza en la fila 2 para evitar sobreescribir los encabezados
    while ($row_datos_alumno = mysqli_fetch_assoc($query_datos_alumno)) {
        // Escribir datos del alumno en la hoja correspondiente
        $sheet_alumno->setCellValue('A' . $rowIndex, $row_datos_alumno['apellido_alumno'] ?? '');
        $sheet_alumno->setCellValue('B' . $rowIndex, $row_datos_alumno['nombre_alumno'] ?? '');
        $sheet_alumno->setCellValue('C' . $rowIndex, $row_datos_alumno['dni_alumno'] ?? '');
        $sheet_alumno->setCellValue('D' . $rowIndex, $legajo);
        $sheet_alumno->setCellValue('E' . $rowIndex, $row_datos_alumno['edad'] ?? '');
        $sheet_alumno->setCellValue('F' . $rowIndex, $row_datos_alumno['observaciones'] ?? '');
        $sheet_alumno->setCellValue('G' . $rowIndex, $row_datos_alumno['Trabaja_Horario'] ?? '');
        $sheet_alumno->setCellValue('H' . $rowIndex, $row_datos_alumno['celular'] ?? '');
        $sheet_alumno->setCellValue('I' . $rowIndex, $row_datos_alumno['nombre_carrera'] ?? '');
        $rowIndex++;
    }

    // Escribir tabla de asistencias en la hoja correspondiente
    $sheet_asistencias->setCellValue('A1', 'Materia');
    $sheet_asistencias->setCellValue('B1', 'Porcentaje Presente (1er Horario)');
    $sheet_asistencias->setCellValue('C1', 'Porcentaje Ausente (1er Horario)');
    $sheet_asistencias->setCellValue('D1', 'Porcentaje Presente (2do Horario)');
    $sheet_asistencias->setCellValue('E1', 'Porcentaje Ausente (2do Horario)');

    // Obtener los ID de carrera asociados al alumno
    $sql_id_carrera = "SELECT 
                            a.inscripcion_asignatura_carreras_idCarrera,
                            c.nombre_carrera,
                            m.Nombre,
                            SUM(CASE WHEN a.1_Horario = 'Presente' THEN 1 ELSE 0 END) AS asistencias_1er_horario,
                            SUM(CASE WHEN a.1_Horario = 'Ausente' THEN 1 ELSE 0 END) AS ausencias_1er_horario,
                            SUM(CASE WHEN a.2_Horario = 'Presente' THEN 1 ELSE 0 END) AS asistencias_2do_horario,
                            SUM(CASE WHEN a.2_Horario = 'Ausente' THEN 1 ELSE 0 END) AS ausencias_2do_horario,
                            COUNT(*) AS total_clases
                        FROM 
                            asistencia a
                        INNER JOIN 
                            carreras c ON a.inscripcion_asignatura_carreras_idCarrera = c.idCarrera
                        INNER JOIN 
                            materias m ON a.materias_idMaterias = m.idMaterias
                        WHERE 
                            a.inscripcion_asignatura_alumno_legajo = '$legajo'
                        GROUP BY 
                            a.inscripcion_asignatura_carreras_idCarrera, c.nombre_carrera, m.Nombre";

    $query_id_carrera = mysqli_query($conexion, $sql_id_carrera);

    if (!$query_id_carrera) {
        throw new Exception("Error al obtener los ID de carrera: " . mysqli_error($conexion));
    }

    $rowIndex = 2; // Reiniciamos el índice de fila para la nueva hoja
    while ($row_id_carrera = mysqli_fetch_assoc($query_id_carrera)) {
        // Calcular porcentaje de asistencia y ausencia para cada horario
        $porcentaje_asistencia_1er_horario = $row_id_carrera['asistencias_1er_horario'] * 100.0 / $row_id_carrera['total_clases'];
        $porcentaje_ausencia_1er_horario = $row_id_carrera['ausencias_1er_horario'] * 100.0 / $row_id_carrera['total_clases'];
        $porcentaje_asistencia_2do_horario = $row_id_carrera['asistencias_2do_horario'] * 100.0 / $row_id_carrera['total_clases'];
        $porcentaje_ausencia_2do_horario = $row_id_carrera['ausencias_2do_horario'] * 100.0 / $row_id_carrera['total_clases'];

        // Agregar fila a la tabla de asistencias
        $sheet_asistencias->setCellValue('A' . $rowIndex, $row_id_carrera['Nombre']);
        $sheet_asistencias->setCellValue('B' . $rowIndex, $porcentaje_asistencia_1er_horario);
        $sheet_asistencias->setCellValue('C' . $rowIndex, $porcentaje_ausencia_1er_horario);
        $sheet_asistencias->setCellValue('D' . $rowIndex, $porcentaje_asistencia_2do_horario);
        $sheet_asistencias->setCellValue('E' . $rowIndex, $porcentaje_ausencia_2do_horario);
        $rowIndex++;
    }

    // Escribir tabla de justificaciones en la hoja correspondiente
    $sheet_justificaciones->setCellValue('A1', 'Carrera');
    $sheet_justificaciones->setCellValue('B1', 'Apellido');
    $sheet_justificaciones->setCellValue('C1', 'Nombre');
    $sheet_justificaciones->setCellValue('D1', 'Materia');
    $sheet_justificaciones->setCellValue('E1', 'Motivo');
    $sheet_justificaciones->setCellValue('F1', 'Fecha');

    // Consulta para obtener las justificaciones del alumno
    $sql_justificaciones = "SELECT 
                                c.nombre_carrera,
                                a2.nombre_alumno,
                                a2.apellido_alumno,
                                m.Nombre AS materia,
                                a.Motivo,
                                a.fecha 
                            FROM 
                                alumnos_justificados a
                            INNER JOIN 
                                carreras c ON c.idCarrera = a.inscripcion_asignatura_carreras_idCarrera
                            INNER JOIN 
                                alumno a2 ON a.inscripcion_asignatura_alumno_legajo = a2.legajo
                            INNER JOIN 
                                materias m ON m.idMaterias = a.materias_idMaterias
                            WHERE 
                                a.inscripcion_asignatura_alumno_legajo = '$legajo'";

    $query_justificaciones = mysqli_query($conexion, $sql_justificaciones);

    if (!$query_justificaciones) {
        throw new Exception("Error al obtener las justificaciones: " . mysqli_error($conexion));
    }

    $rowIndex = 2; // Reiniciamos el índice de fila para la nueva hoja
    while ($row_justificacion = mysqli_fetch_assoc($query_justificaciones)) {
        // Agregar fila a la tabla de justificaciones
        $sheet_justificaciones->setCellValue('A' . $rowIndex, $row_justificacion['nombre_carrera']);
        $sheet_justificaciones->setCellValue('B' . $rowIndex, $row_justificacion['apellido_alumno']);
        $sheet_justificaciones->setCellValue('C' . $rowIndex, $row_justificacion['nombre_alumno']);
        $sheet_justificaciones->setCellValue('D' . $rowIndex, $row_justificacion['materia']);
        $sheet_justificaciones->setCellValue('E' . $rowIndex, $row_justificacion['Motivo']);
        $sheet_justificaciones->setCellValue('F' . $rowIndex, $row_justificacion['fecha']);
        $rowIndex++;
    }

    // Escribir tabla de ratificaciones en la hoja correspondiente
    $sheet_ratificaciones->setCellValue('A1', 'Legajo');
    $sheet_ratificaciones->setCellValue('B1', 'Apellido');
    $sheet_ratificaciones->setCellValue('C1', 'Nombre');
    $sheet_ratificaciones->setCellValue('D1', 'Carrera');
    $sheet_ratificaciones->setCellValue('E1', 'Materia');
    $sheet_ratificaciones->setCellValue('F1', 'Profesor');
    $sheet_ratificaciones->setCellValue('G1', 'Motivo');
    $sheet_ratificaciones->setCellValue('H1', 'Fecha');

    // Consulta para obtener las ratificaciones del alumno
    $sql_ratificaciones = "SELECT 
                                a2.legajo, 
                                a2.apellido_alumno,
                                a2.nombre_alumno,
                                c.nombre_carrera,
                                m.Nombre AS materia,
                                p.nombre_profe,
                                a.motivo,
                                a.fecha 
                            FROM 
                                alumnos_rat a
                            INNER JOIN 
                                alumno a2 ON a.alumno_legajo = a2.legajo
                            INNER JOIN 
                                carreras c ON a.carreras_idCarrera = c.idCarrera
                            INNER JOIN 
                                materias m ON a.materias_idMaterias = m.idMaterias
                            INNER JOIN 
                                profesor p ON a.profesor_idProrfesor = p.idProrfesor
                            WHERE 
                                a.alumno_legajo = '$legajo'";

    $query_ratificaciones = mysqli_query($conexion, $sql_ratificaciones);

    if (!$query_ratificaciones) {
        throw new Exception("Error al obtener las ratificaciones: " . mysqli_error($conexion));
    }

    $rowIndex = 2; // Reiniciamos el índice de fila para la nueva hoja
    while ($row_ratificacion = mysqli_fetch_assoc($query_ratificaciones)) {
        // Agregar fila a la tabla de ratificaciones
        $sheet_ratificaciones->setCellValue('A' . $rowIndex, $row_ratificacion['legajo']);
        $sheet_ratificaciones->setCellValue('B' . $rowIndex, $row_ratificacion['apellido_alumno']);
        $sheet_ratificaciones->setCellValue('C' . $rowIndex, $row_ratificacion['nombre_alumno']);
        $sheet_ratificaciones->setCellValue('D' . $rowIndex, $row_ratificacion['nombre_carrera']);
        $sheet_ratificaciones->setCellValue('E' . $rowIndex, $row_ratificacion['materia']);
        $sheet_ratificaciones->setCellValue('F' . $rowIndex, $row_ratificacion['nombre_profe']);
        $sheet_ratificaciones->setCellValue('G' . $rowIndex, $row_ratificacion['motivo']);
        $sheet_ratificaciones->setCellValue('H' . $rowIndex, $row_ratificacion['fecha']);
        $rowIndex++;
    }

  // Guardar el archivo Excel en un buffer de salida
    ob_start();
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    $excelFileContent = ob_get_clean();

    // Descargar el archivo
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    echo $excelFileContent;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

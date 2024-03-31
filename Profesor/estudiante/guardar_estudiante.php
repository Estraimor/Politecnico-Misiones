<?php


$server='localhost';
$user='u756746073_root';
$pass='POLITECNICOmisiones2023.';
$bd='u756746073_politecnico';
$conexion=mysqli_connect($server,$user,$pass,$bd, '3306');

if ($conexion) { echo ""; } else { echo "conexion not connected"; }



if (isset($_POST['enviar'])) {
    if (!empty($_POST['nombre_alu']) && !empty($_POST['apellido_alu']) && !empty($_POST['dni_alu']) && !empty($_POST['legajo']) && !empty($_POST['celular'])&& !empty($_POST['edad'])&& !empty($_POST['observaciones'])
    && !empty($_POST['Trabajo_Horario'])&& !empty($_POST['inscripcion_carrera'])) {
        $nombre_alu = $_POST['nombre_alu'];
        $apellido_alu = $_POST['apellido_alu'];
        $dni_alu = $_POST['dni_alu'];
        $legajo = $_POST['legajo'];
        $celular = $_POST['celular'];
        $edad = $_POST['edad'];
        $observaciones = $_POST['observaciones'];
        $trabajo_hs=$_POST['Trabajo_Horario'];
        $inscripcion_carrera = $_POST['inscripcion_carrera'];


        $fecha_nacimiento = $_POST['edad'];

// Convertir la fecha de nacimiento a un objeto DateTime
$fecha_nacimiento_dt = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);

// Verificar si se creó correctamente el objeto DateTime
if ($fecha_nacimiento_dt instanceof DateTime) {
    // Obtener la fecha actual
    $fecha_actual = new DateTime();
    
    // Calcular la diferencia en años entre la fecha actual y la fecha de nacimiento
    $diff = $fecha_actual->diff($fecha_nacimiento_dt);
    
    // Calcular la edad restando el año de nacimiento del año actual
    $edad = $fecha_actual->format('Y') - $fecha_nacimiento_dt->format('Y');
    
    // Verificar si la fecha de nacimiento ya ha ocurrido este año
    if ($fecha_actual < $fecha_nacimiento_dt->add(new DateInterval('P'.$edad.'Y'))) {
        $edad--;
    }
    
    // Imprimir la edad
    
} else {
    // Si $fecha_nacimiento_dt no es un objeto DateTime válido
   
}



        

      // Verificar si ya existe un alumno con las mismas variables
        
         $sql_verificar = "SELECT * FROM alumno 
        where nombre_alumno = '$nombre_alu' 
       and apellido_alumno = '$apellido_alu'  
      and dni_alumno = '$dni_alu' 
        and estado = '1' 
       and celular= '$celular'
         and legajo = '$legajo'
         and edad= '$edad'
         and observaciones = '$formacion_P'
        and edad= '$trabajo_hs'";
         $query_verificar = mysqli_query($conexion, $sql_verificar);
        
         if (!$query_verificar) {
             echo '<div class="alert alert-danger" role="alert">
             Error al ejecutar la consulta de verificación: ' . mysqli_error($conexion) . '
             </div>';
            exit; // Detener la ejecución si hay un error en la consulta
        }
        
         $existe_alumno = mysqli_num_rows($query_verificar);

         if ($existe_alumno > 0) {
             echo '<div class="alert alert-danger" role="alert">
                 ¡Ya existe un alumno con las mismas variables!
             </div>';
         } else {
             // Insertar el nuevo alumno en la base de datos
             $sql_insertar = "INSERT INTO alumno (nombre_alumno, apellido_alumno, dni_alumno,celular, estado, legajo,edad,observaciones,Trabaja_Horario) 
             VALUES ('$nombre_alu', '$apellido_alu', '$dni_alu','$celular', '1', '$legajo','$edad','$observaciones','$trabajo_hs')";
             $query_insertar = mysqli_query($conexion, $sql_insertar);


            $sql_insertar_alumno_carrera = "INSERT INTO inscripcion_asignatura (carreras_idCarrera, alumno_legajo) 
             VALUES ('$inscripcion_carrera', '$legajo')";
           $insertar_alumno_carrera = mysqli_query($conexion, $sql_insertar_alumno_carrera);
            

             if ($query_insertar) {
                echo '<script>mostrarAlertaExitosa();</script>';

            } else {
               echo '<div class="alert alert-danger" role="alert">
                    Error al insertar el alumno.
                </div>';
                echo '<script>mostrarAlertaError();</script>';
             }
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">
            ¡Campos Vacíos!
         </div>';
        
    }
 }
?>

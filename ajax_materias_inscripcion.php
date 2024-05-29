<?php
include './conexion/conexion.php'; // Asegúrate de que este archivo contiene la conexión a la base de datos

if (isset($_POST['carreraId'])) {
  $carreraId = intval($_POST['carreraId']);
  
  $materias = array();

  // Dependiendo del ID de la carrera, se seleccionan diferentes materias
  switch ($carreraId) {
    case 18:
      // Carrera 1, seleccionar todas las materias
      $sql = "SELECT m.idMaterias,m.Nombre 
      FROM materias m 
      WHERE m.carreras_idCarrera = 18";
      $resultado = $conexion->query($sql);
      while ($row = $resultado->fetch_assoc()) {
        $materias[] = $row;
      }
      break;
    case 33:
      // Carrera 2, seleccionar todas las materias
      $sql = "SELECT m.idMaterias,m.Nombre 
      FROM materias m 
      WHERE m.carreras_idCarrera = 33";
      $resultado = $conexion->query($sql);
      while ($row = $resultado->fetch_assoc()) {
        $materias[] = $row;
      }
      break;
    // Añadir más casos según sea necesario
    default:
      break;
  }

  echo json_encode($materias);
}
?>

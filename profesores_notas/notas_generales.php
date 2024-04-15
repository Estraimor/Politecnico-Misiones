<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../login/login.php');}
?>
<?php include'../conexion/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Situación Académica</title>
<link rel="icon" href="../politecnico.ico">
<link rel="stylesheet" href="../Profesor/notas/login_notas/estilos_notas.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>

<nav class="navbar">
    <div class="dropdown">
        <button class="dropbtn">Carreras <i class="fas fa-caret-down"></i></button>
        <div class="dropdown-content">
            <div class="sub-dropdown">
                <a href="#" class="sub-dropbtn">Enfermería <i class="fas fa-caret-right"></i></a>
                <div class="sub-dropdown-content">
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_enfermeria_comision_a.php">Comisión A</a>
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_enfermeria_comision_b.php">Comisión B</a>
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_enfermeria_comision_c.php">Comisión C</a>
                </div>
            </div>
            <div class="sub-dropdown">
                <a href="#" class="sub-dropbtn">Automatización y Robótica <i class="fas fa-caret-right"></i></a>
                <div class="sub-dropdown-content">
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_robotica_comision_a.php">Comisión A</a>
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_robotica_comision_b.php">Comisión B</a>
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_robotica_comision_c.php">Comisión C</a>
                </div>
            </div>
            <div class="sub-dropdown">
                <a href="#" class="sub-dropbtn">Comercialización y Marketing <i class="fas fa-caret-right"></i></a>
                <div class="sub-dropdown-content">
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_marketing_comision_a.php">Comisión A</a>
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_marketing_comision_b.php">Comisión B</a>
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_marketing_comision_c.php">Comisión C</a>
                </div>
            </div>
            <div class="sub-dropdown">
                <a href="#" class="sub-dropbtn">Acompañamiento Terapéutico <i class="fas fa-caret-right"></i></a>
                <div class="sub-dropdown-content">
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_at_comision_a.php">Comisión A</a>
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_at_comision_b.php">Comisión B</a>
                    <a href="../Profesor/notas/login_notas/notas_materias/materias_at_comision_c.php">Comisión C</a>
                </div>
            </div>
        </div>
    </div> 
    
</div>
    <a href="#" class="btn-cerrar-sesion">Cerrar Sesión</a>
</nav>


</body>
</html>
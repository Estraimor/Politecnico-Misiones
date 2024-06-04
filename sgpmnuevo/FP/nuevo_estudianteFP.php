<?php
session_start();
if (empty($_SESSION["id"])){header('Location: ../../login/login.php');}

// Set inactivity limit in seconds
$inactivity_limit = 1200;

// Check if the user has been inactive for too long
if (isset($_SESSION['time']) && (time() - $_SESSION['time'] > $inactivity_limit)) {
    // User has been inactive, so destroy the session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: ../../login/login.php");
    exit; // Terminar el script después de redireccionar
} else {
    // Update the session time to the current time
    $_SESSION['time'] = time();
}
?>
<?php include'../../conexion/conexion.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SGPM</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../assets/img/Logo ISPM 2 transparante.png" type="image/x-icon"/>
	<!-- DATA TABLES -->
    <link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
     <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
	<!-- Fonts and icons -->
	<script src="../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['../assets/css/fonts.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/azzara.min.css">
	<link rel="stylesheet" href="../assets/css/estilos.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="../assets/css/demo.css">
</head>
<body>
	<div class="wrapper">
		
		<div class="main-header" data-background-color="red">
			<div class="logo-header">
				
				<a href="../index.php" class="logo">
					<img src="../assets/img/Logo ISPM 2 transparante.png" width="45px" alt="navbar brand" class="navbar-brand">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="fa fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded">
						<i class="fa fa-bars"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg">
				
				<div class="container-fluid">
					<div class="collapse" id="search-nav">
						<form class="navbar-left navbar-form nav-search mr-md-3">
							
						</form>
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
						
						
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="../assets/img/1361728.png" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<li>
									<div class="user-box">
										<div class="avatar-lg"><img src="../assets/img/1361728.png" alt="image profile" class="avatar-img rounded"></div>
										<div class="u-text">
											<h4>$usuario</h4>
											<p class="text-muted">#Correo Electronico</p><a href="profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
										</div>
									</div>
								</li>
								<li>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">Mi Perfil</a>
									<a class="dropdown-item" href="#">Cambiar Contraseña</a>
									<a class="dropdown-item" href="#">Cerrar Sesión</a>
								</li>
							</ul>
						</li>
						
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>
		<!-- Sidebar -->
		<div class="sidebar">
			
			<div class="sidebar-wrapper scrollbar-inner">
				<div class="sidebar-content">
					
					 
					<ul class="nav">
						<li class="nav-item">
							<a href="../index.php">
								<i class="fas fa-home"></i>
								<p>Manu Principal</p>
								
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Herramientas</h4>
						</li>
						<li class="nav-item active submenu">
                        <a data-toggle="collapse" href="#base">
								<i class="fas fa-child"></i>
								<p>Estudiantes</p>
								<span class="caret"></span>
							</a>
							<div class="collapse show" id="base">
								<ul class="nav nav-collapse">
                                <li >
										<a href="">
											<span class="sub-item">Nuevo Estudiante</span>
										</a>
									</li>
									<li>
										<a href="active">
											<span class="sub-item">Nuevo Estudiante FP</span>
										</a>
									</li>
									<li class="">
										<a href="#">
											<span class="sub-item">Lista Estudiantes</span>
										</a>
									</li>
									<li>
										<a href="">
											<span class="sub-item">Lista Estudiantes FP</span>
										</a>
									</li>
									<li>
										<a href="">
											<span class="sub-item">Informe de Asistencias Técnicaturas</span>
										</a>
									</li>
									<li>
										<a href="">
											<span class="sub-item">Informe de Asistencias FP</span>
										</a>
									</li>
									<li>
										<a href="">
											<span class="sub-item">Imprimir Lista de Estudiantes Técnicaturas</span>
										</a>
									</li>
									<li>
										<a href="">
											<span class="sub-item">Imprimir Lista de Estudiantes FP</span>
										</a>
									</li>
									<li>
										<a href="">
											<span class="sub-item">Retirados Antes de Tiempo</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#forms">
								<i class="fas fa-pen-square"></i>
								<p>Tomar Asistencia</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="forms">
								<ul class="nav nav-collapse">
									<li>
										<a href="">
											<span class="sub-item">Estudiantes Técnicaturas</span>
										</a>

									</li>
									<li>
										<a href="">
											<span class="sub-item">Estudiantes FP</span>
										</a>
										
									</li>
									
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#tables">
								<i class="fas fa-chalkboard-teacher"></i>
								<p>Personal</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="tables">
								<ul class="nav nav-collapse">
									<li>
										<a href="">
											<span class="sub-item">Profesores</span>
										</a>
									</li>
									<li>
										<a href="">
											<span class="sub-item">Preceptores</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						
		</div>
		<!-- End Sidebar -->

       
		
		
		<!-- End Custom template -->
	</div>
</div>
<div class="contenido">
<?php
    
    // Consulta para obtener las carreras
    $sql_carreras = "SELECT * FROM carreras c WHERE c.idCarrera IN ('8','14','15','64','65')";
    $resultado_carreras = mysqli_query($conexion, $sql_carreras);
    $carreras = array(); // Almacenar las carreras en un array

    while ($informacion_carrera = mysqli_fetch_assoc($resultado_carreras)) {
        $carreras[] = $informacion_carrera; // Añadir cada carrera al array
    }
?>
    <span class="close-student-fp">&times;</span>
    <form action="./FP/ABM_FP/guardar_alumnofp.php" method="post">
    <h2>Registro de FP</h2>
        <?php
        // Consulta para obtener el último número de legajo
        $sql_legajo = "SELECT MAX(legajo_afp) AS max_legajo FROM alumnos_fp";
        $resultado_legajo = $conexion->query($sql_legajo);
        $fila_legajo = $resultado_legajo->fetch_assoc();
        $nuevo_legajo = $fila_legajo['max_legajo'] + 1; // Nuevo legajo es el último más uno
    ?>
    <!-- Campo de legajo con el valor obtenido de la base de datos -->
    <input type="text" name="legajo" placeholder="N° Legajo"  value="<?php echo $nuevo_legajo; ?>" class="form-container__input" >
        <input type="text" name="nombre" placeholder="Nombre" class="form-container__input" autocomplete="off">
        <input type="text" name="apellido" placeholder="Apellido" class="form-container__input" autocomplete="off">
        <input type="number" name="dni" placeholder="DNI" class="form-container__input" autocomplete="off">
        <input type="number" name="celular" placeholder="Celular" class="form-container__input" autocomplete="off">
        <input type="text" name="observaciones" placeholder="Observaciones" class="form-container__input" autocomplete="off">
        <input type="text" name="trabaja" placeholder="Trabaja" class="form-container__input" autocomplete="off">
        <!-- PHP code to generate options goes here -->
        <select name="FP1" class="form-container__input">
        <?php foreach ($carreras as $carrera) { ?>
        <option value="65" hidden selected>Selecciona un curso</option>
            <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
            <?php } ?>
        </select>
        <select name="FP2" class="form-container__input">
        <?php foreach ($carreras as $carrera) { ?>
            <option value="65" hidden selected>Selecciona un curso</option>
            <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
            <?php } ?>
        </select>
        <select name="FP3" class="form-container__input">
        <?php foreach ($carreras as $carrera) { ?>
            <option value="65" hidden selected>Selecciona un curso</option>
            <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
            <?php } ?>
        </select>
        <select name="FP4" class="form-container__input">
        <?php foreach ($carreras as $carrera) { ?>
            <option value="65" hidden selected>Selecciona un curso</option>
            <option value="<?php echo $carrera['idCarrera'] ?>"><?php echo $carrera['nombre_carrera'] ?></option>
            <?php } ?>
        </select>
        <input type="submit" name="enviar" value="Enviar" class="form-container__input">
    </form>
    </div>

<!--   Core JS Files   -->
<script src="../assets/js/core/jquery.3.2.1.min.js"></script>

<script src="../assets/js/core/bootstrap.min.js"></script>


<!-- jQuery UI -->
<script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>


<!-- jQuery Scrollbar -->
<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Azzara JS -->
<script src="../assets/js/ready.min.js"></script>

<script>
    
// dataTables de Alumnos //

</script>

</body>
</html>


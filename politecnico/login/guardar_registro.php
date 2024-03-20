<?php
include'../conexion/conexion.php';
 if (isset($_POST['enviar']))
 {
    if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['dni']) ||  empty($_POST['celular']) | empty($_POST['usuario']) || empty($_POST['password'])){
        echo '<div class="alert alert-danger" role="alert">
        !! CAMPOS VACIOS !!
      </div>' ;
    } else {
        $nombre=$_POST['nombre'];
        $apellido=$_POST['apellido']; 
        $dni=$_POST['dni']; 
        $celular=$_POST['celular']; 
        $usuario=$_POST['usuario'];
        $password=$_POST['password'];
        $sql="INSERT INTO politecnico.profesor (nombre_profe, apellido_profe, dni_profe, celular, usuario, pass) 
        VALUES ( '$nombre', '$apellido', '$dni', '$celular', '$usuario', '$password');";
        $query=mysqli_query($conexion,$sql);
        if ($query){echo 'conected';}else{echo 'failed';}
        header("Location: ./login.php");

        
        
        
        
    }
    
 }
?>
 
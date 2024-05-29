<?php
session_start();
include'../../../conexion/conexion.php';
if (isset($_POST['enviar']))
{
    if (!empty($_POST['usuario']) && !empty($_POST['password'])){
        $usuario=$_POST['usuario'];
        $pass=$_POST['password'];
        $sql=$conexion->query("SELECT * FROM profesor where usuario = '$usuario' and pass = '$pass'");
    if ($datos=$sql->fetch_object()) {
        $_SESSION["id"]=$datos->idProrfesor;
        $_SESSION["nombre"]=$datos->nombre_profe;
        $_SESSION["apellido"]=$datos->apellido_profe;
        $_SESSION["dni"]=$datos->dni_profe;
        $_SESSION["celular"]=$datos->celular;
        $_SESSION["usuario"]=$datos->usuario;
        $_SESSION["contraseña"]=$datos->pass;
        header("Location: index_nota.php");
    } else {
        echo '<div class="alert alert-dangery" style="background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        margin-top: 20px;" role="alert">
        !! ACCESO DENEGADO !!
      </div>' ;
    }
    
    } else{
        
        echo '<div class="alert alert-danger" role="alert">
        !! HAY CAMPOS VACIOS !!
      </div>' ;
    }
}?>

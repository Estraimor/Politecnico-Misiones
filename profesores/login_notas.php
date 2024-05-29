<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../login/stilos-login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="icon" href="../politecnico.ico">
    <title>login</title>
    
</head>
<body>
    
    <form action="" method="post">
        
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="" autocomplete="off">
                    <h2>Inicio de Sesión</h2>
                    <?php include'./controlar_login_notas.php';?>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" required name="usuario" id="usuario" autocomplete="off" >     
                         <label for="usuario" autocomplete="off"> Usuario </label>
                    </div>
                    <div class="inputbox">
                    <ion-icon class="eye" name="eye-off-outline" onclick="togglePassword()"></ion-icon>
                        <input type="password" id="password" required name="password">
                        <label for="password"  autocomplete="off">Contraseña</label>
                    </div>
                    
                    <button type="submit" name="enviar" class="submit-button">Iniciar Sesión</button>
                    <div class="register">
                        <p> <a href="./login-register.php">Crear Cuenta </a></p>
                    </div>
                </form>
               
            </div>
        </div>
    </section>            
    </form>

    <script>
       function togglePassword() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.querySelector(".eye");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.name = "eye-outline"; // Cambia el icono a ojo abierto
    } else {
        passwordInput.type = "password";
        eyeIcon.name = "eye-off-outline"; // Cambia el icono a ojo cerrado
    }
}
    </script>


<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
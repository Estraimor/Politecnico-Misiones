
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../politecnico.ico">
<link rel="stylesheet" href="./estilos2.css">

    <title>Registro Docente</title>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</head>
<body>
<form action="" method="post">
        <div class="registration-box">
    <?php  include'./guardar_registro.php';?>
    <center>
                <input type="text" name="nombre" placeholder="Ingrese su nombre"><br><br>
                <input type="text" name="apellido" placeholder="Ingrese su apellido"><br><br>
                <input type="number" name="dni" placeholder=" Ingrese su DNI "><br><br>
                <input type="number" name="celular" placeholder=" Ingrese su Celular "><br><br>
                <input type="text" name="usuario" placeholder="Ingrese su usuario "><br><br>
                <input type="password" id="password"  name="password" placeholder="Ingrese su contraseña">
                <span id="password-toggle" onclick="togglePassword()">
                    <i id="eye-icon" class="fas fa-eye"></i>
                </span>
                <br><br>
                <button class="cancel-button"><a href="./login.php" style="text-decoration: none; color: black;">Cancelar</a></button>
                <button class="register-button" name="enviar" type="submit">Registrarse</button>
            </center>
        </div>
    </form>









    
</body>
</html>
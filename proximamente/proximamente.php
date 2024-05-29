<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximamente</title>
    <link rel="icon" href="../politecnico.ico">
    <style>
        body{
         background-image: url(../imagenes/simulacion-y-automatizacion-de-robotica.jpg);
         background-repeat: no-repeat;
         background-size: cover;
        }

       html {

            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url(../imagenes/simulacion-y-automatizacion-de-robotica.jpg);
        }
        .container {
            background-color: white;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: 'arial';
        }
        .boton {
            background-color: red;
            color: white;
            padding: 10px 20px;
            
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .boton:hover {
            background-color: #cc0000;
        }
        .boton:active {
            background-color: #990000;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Este apartado estará disponible próximamente</h1>
    <button class="boton" onclick="volverAlMenuPrincipal()">Volver al menú principal</button>
</div>

<script>
    function volverAlMenuPrincipal() {
        // Aquí puedes redirigir al usuario al menú principal. Por ejemplo:
        window.location.href = '../Profesor/controlador_preceptormodificar.php';
    }
</script>

</body>
</html>
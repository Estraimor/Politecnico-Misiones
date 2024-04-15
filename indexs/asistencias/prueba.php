<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Nuevo formulario para justificar falta -->
<div id="justificadoForm" style="display: none;">
    <h2>Justificación de falta</h2>
    <form id="formularioJustificado" action="justificado.php" method="post">
        <!-- Campos ocultos con los datos del formulario principal -->
        <input type="hidden" id="legajo" name="legajo">
        <input type="hidden" id="materia" name="materia">
        <input type="hidden" id="carrera" name="carrera">
        <input type="hidden" id="fechaFalta" name="fechaFalta">
        
        <!-- Campo para el motivo de la falta -->
        <div>
             <p>Motivo de justificación:</p>
             <input type="text" class="form-container__input" required />
             <button type="submit" name="enviado">Confirmar</button>
        </div>
    </form>
</div>
</body>
</html>
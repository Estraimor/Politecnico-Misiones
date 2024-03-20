<?php
session_start();
if (empty($_SESSION["id"])) {
    header('Location: ./login/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>navbar Dos</title>
    <link rel="stylesheet" href="./pruebah.css">
</head>
<body>
    <header class="header">
        <div class="logo">
<!---->            <img src="img/Mountain.png" alt="Logo de la marca">
        </div>
        <nav>
           <ul class="nav-links">
                <li><a href="#">Services</a></li>
                <li><a href="#">Projects</a></li>
                <li><a href="#">About</a></li>
           </ul>            
        </nav>
        <a class="btn" href="#"><button>Contact</button></a>

<!---->        <a onclick="openNav()" class="menu" href="#"><button>Menu</button></a>

<!---->        <div id="mobile-menu" class="overlay">
<!---->            <a onclick="closeNav()" href="" class="close">&times;</a>
<!---->            <div class="overlay-content">
<!---->                <a href="#">Services</a>
<!---->                <a href="#">Projects</a>
<!---->                <a href="#">About</a>
<!---->                <a href="#">Contact</a>
<!---->            </div>
<!---->        </div>

    </header>


<!---->    <script type="text/javascript" src="./navjs.js"></script>

</body>
</html>
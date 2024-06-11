<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>.body-custom-bg {
        background-color: #dfdddd; /* Color personalizado en hexadecimal */
    }
    
    </style>

    <script type="text/javascript">
        function login() {
            window.location.href = "login.html";
        }
        function sign_in(){
          window.location.href = "sign_in.html";
        }
    </script>
</head>
<body class="body-custom-bg">

  <!-- BARRA DE NAVEGACION DE CABECERA -->

  <?php


    if (isset($_SESSION['nombre']) and isset($_SESSION['nivel_cuenta'])) {
        echo('<header>
        <nav class="navbar bg-body-tertiary">
          <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
              <img src="logo.jpg" alt="Logo" width="40" height="35" class="d-inline-block align-text-top">
              Net Tech
            </a>
              <div class="display 7" >Bienvenido '. htmlspecialchars($_SESSION['nombre']) . '</div>
              <form class="d-flex" action="cerrar_sesion.php">
              <button class="btn btn-danger ms-md-1" style="--bs-btn-padding-x: 1rem;">Cerrar Sesion</button>
          </form>
          <form class="d-flex" action="solicitudes.php">
              <button class="btn btn-danger ms-md-1" style="--bs-btn-padding-x: 1rem;">SOLICITUDES</button>
          </form>
          <div class="display-7"> para asistencia personalizada : +52000000</div>
          </div>
        </nav>
        <h2 style="padding-left:2rem; position: sticky; color: rgb(252, 57, 57);">Nuestros Planes:</h2>
      </header>
      
      <div class="container" style="padding-top: 2rem; padding-bottom: 1rem;">
        <a href="agregar_plan.php" type="button" class="btn btn-primary">AGREGAR PLAN</a>
      </div>
      
      ');
      include ('functions.php');
      mostrar_plan_admin();
    }
    else if (isset($_SESSION['nombre']) and !isset($_SESSION['nivel_cuenta'])) {
      echo('<header>
      <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="logo.jpg" alt="Logo" width="40" height="35" class="d-inline-block align-text-top">
            Net Tech
          </a>
            <div class="display 7" >Bienvenido '. htmlspecialchars($_SESSION['nombre']) . '</div>
            <form class="d-flex" action="cerrar_sesion.php">
            <button class="btn btn-danger ms-md-1" style="--bs-btn-padding-x: 1rem;">Cerrar Sesion</button>
        </form>
        <div class="display-7"> para asistencia personalizada : +52000000</div>
        </div>
      </nav>
      <h2 style="padding-left:2rem; position: sticky; color: rgb(252, 57, 57);">Nuestros Planes:</h2>
    </header>
    
    ');
    include ('functions.php');
    mostrar_plan();
  } else {
        // Si no hay sesión iniciada, pide al usuario que inicie sesión
        echo ('<header>
        <nav class="navbar bg-body-tertiary">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">
              <img src="logo.jpg" alt="Logo" width="40" height="35" class="d-inline-block align-text-top">
              Net Tech
            </a>
              <button onclick="sign_in()" class="btn btn-light" style="--bs-btn-padding-x: 1rem;"><u>Registrarme</u></button>
            <form class="d-flex" action="login.html">
              <button onclick="login()" class="btn btn-danger ms-md-1" style="--bs-btn-padding-x: 1rem;">Iniciar Sesion</button>
          </form>
          <a> para asistencia personalizada : +52000000</a>
          </div>
        </nav>
      
      </header>');
      include ('functions.php');
      mostrar_plan();
    }
    ?>

    
    <script src="./js/bootstrap.min.js"></script>
</body>
</html>
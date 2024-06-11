<?php
session_start();
include 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <script>
      function cargarDatos() {
            // Obtener el precio almacenado en LocalStorage
            var precio = 750;
            var direccion = localStorage.getItem("direccion");
            var codigo_postal = localStorage.getItem("codigo_postal");
            var colonia = localStorage.getItem("colonia");
            var ciudad = localStorage.getItem("ciudad");
            var nombre_plan = localStorage.getItem("nombre_plan");
            var megas = localStorage.getItem("megas");
            var descripcion = localStorage.getItem("descripcion");

            
            var direccion_string = direccion + " " + codigo_postal;
            document.getElementById("direccion").innerText =direccion_string;

            var numero_servicio = Math.floor(Math.random() * 200) + 1000;
            document.getElementById("numero_servicio").innerText = numero_servicio;
            document.getElementById("numero_orden_servicio").innerText = numero_servicio;

        }


    </script>

    <style>.body-custom-bg {
        background-color: #dfdddd; /* Color personalizado en hexadecimal */
    }
    
    </style>
</head>
<body class="body-custom-bg" onload="cargarDatos()">

  <!-- BARRA DE NAVEGACION DE CABECERA -->
  <?php
    if (isset($_SESSION['nombre'])) {
        echo('<header>
        <nav class="navbar bg-body-tertiary">
          <div class="container-fluid">
            <a class="navbar-brand" href="home.html">
              <img src="logo.jpg" alt="Logo" width="40" height="35" class="d-inline-block align-text-top">
              Net Tech
            </a>
            <form class="d-flex">
              <p>'. htmlspecialchars($_SESSION['nombre']) . '</p>
          </form>
          </div>
        </nav>
      
      </header>');
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
          </div>
        </nav>
      
      </header>');
    }
    ?>

    <h2 style="padding-left: 2rem ;position:sticky;color: rgb(252, 57, 57);">Plan seleccionado:</h2>
    <!-- LISTA DE PLANES DISPONIBLES -->

    <?php
    $plan_id = $_SESSION['plan_id'];
    $direccion = $_GET['direccion'];
    $colonia = $_GET['colonia'];
    $codigo_postal = $_GET['codigo_postal'];
    $_SESSION['direccion'] = $direccion;
    include 'conexion.php';
    $sql = "SELECT * FROM Plan WHERE id = '$plan_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      echo('<div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
      <div class="container rounded-4 bg-light" style="padding: 2rem;">
        <h3 style="color: rgb(252, 57, 57);" id="nombre_plan" value"'.htmlspecialchars($row['nombre']).'">'.htmlspecialchars($row['nombre']).'</h3>
        <div class="row ">
          <div class="col d-flex justify-content-center text-end display-5 align-items-center" style="color: rgb(252, 57, 57);" id="megas" value="'.htmlspecialchars($row['megas']).'">
            '.htmlspecialchars($row['megas']).'
          </div>
          <div class="col-6 d-flex text-start align-items-center">
            <div class="row" id="descripcion" value="'.htmlspecialchars($row['descripcion']).'">
              '.htmlspecialchars($row['descripcion']).'
            </div>     
          </div>
          <div  class="col d-flex text-start align-items-center">cantidad de equipos: 
          '.htmlspecialchars($row['equipos']).' y cubre '.htmlspecialchars($row['metros']).' metros cuadrados
          </div>
          <div class="col d-flex justify-content-center text-end display-6 align-items-center" style="color: rgb(252, 57, 57);" id="precio" value="'.htmlspecialchars($row['precio']).'">
          $'.htmlspecialchars($row['precio']).'
          </div>
        </div>
        </div>
      </div>
      
      <div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
            <div class="container rounded-4 bg-light" style="padding: 2rem;">
                <p id="direccion"></p>
                <form action="registro_instalaciones.php" method="get">
                <input type="hidden" id="numero_servicio">
                <p>(recuerda que el precio final esta sujeto a modificaciones realizadas en la pantalla anterior, uno de nuestros tecnicos lo revisara y se pondra en contacto contigo)</p>
                <div class="row" style="padding: 2rem;">
                    <div class="col text-center">
                      
                        <button type="submit" class="btn btn-danger" style="width: 10rem;" action="registro_instalaciones.php" >HACER SOLICITUD</button>
                      </form>
                      </div>
                </div>
            </div>
        </div>  ');
    
    } else {
      echo "no se encontro ningun plan";
    }

    ?>

        <!-- <div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
            <div class="container rounded-4 bg-light" style="padding: 2rem;">
                <p id="direccion"></p>
                <div id="numero_servicio" style="padding-top: 2rem;"></div>
                <p>(recuerda que el precio final esta sujeto a modificaciones realizadas en la pantalla anterior, uno de nuestros tecnicos lo revisara y se pondra en contacto contigo)</p>
                <div class="row" style="padding: 2rem;">
                    <div class="col text-center">
                      <form action="registro_instalaciones.php" method="get">
                        <button type="submit" class="btn btn-danger" style="width: 10rem;" action="registro_instalaciones.php" >HACER SOLICITUD</button>
                      </form>
                      </div>
                </div>
            </div>
        </div>   -->


    <script src="./js/bootstrap.min.js"></script>
</body>
</html
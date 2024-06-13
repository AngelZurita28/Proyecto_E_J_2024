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
            <a class="navbar-brand" href="home.php">
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
    $_SESSION['direccion'] = $_GET['direccion'];
    $_SESSION['colonia'] = $_GET['colonia'];
    $_SESSION['codigo_postal'] = $_GET['codigo_postal'];
   
    include 'conexion.php';
    $sql = "EXECUTE obtenerProducto_id $plan_id;";
    $stmt = sqlsrv_query($conn, $sql);
    sqlsrv_execute($stmt);
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
      echo('<div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
      <div class="container rounded-4 bg-light" style="padding: 2rem;">
        <div class="row ">
          <div class="col d-flex text-start display-6" style="color: rgb(252, 57, 57);">
      '.htmlspecialchars($row['nombre']).'
      </div>
      <div class="col-6 d-flex text-start align-items-center">
        <div class="row" style="padding: 1rem;">
        '.htmlspecialchars($row['descripcion']).'
        </div>
      </div>
      <div class="col d-flex text-end align-items-center"> '.htmlspecialchars($row['nombre_proveedor']).'</div>
      <div class="col d-flex justify-content-center text-end display-6 align-items-center" style="color: rgb(252, 57, 57);">
      $'.htmlspecialchars($row['precio']).'</div>
        </div>
        </div>
      </div>
      
      <div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
            <div class="container rounded-4 bg-light" style="padding: 2rem;">
                <p id="direccion">'.htmlspecialchars($_SESSION['direccion']).' C.P.'.htmlspecialchars($_SESSION['codigo_postal']).', Colonia '.htmlspecialchars($_SESSION['colonia']).'</p>
                <form action="registro_instalaciones.php" method="get">
                <input type="hidden" id="numero_servicio">
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

    <script src="./js/bootstrap.min.js"></script>
</body>
</html
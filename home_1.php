<?php
session_start();
$_SESSION['home'] = 'home_1.php';
$companyId = 1;
$companyName = "Compañía 1";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>.body-custom-bg {
        background-color:#f5f5f5 ; /* Color personalizado en hexadecimal */
    }
        .card {
        transition: transform 0.3s ease-in-out;
    }

        .card:hover {
        transform: scale(1.05);
    }

    </style>
</head>
<body class="body-custom-bg">

  <!-- BARRA DE NAVEGACION DE CABECERA -->

  <?php
    if (isset($_SESSION['nombre']) and isset($_SESSION['nivel'])) {
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
          <form class="d-flex" action="reporte_anual.php">
              <button class="btn btn-danger ms-md-1" style="--bs-btn-padding-x: 1rem;">REPORTE</button>
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

      echo ('
      <div class="container mt-5">
        
        <form id="companySelector" method="GET" action="selector.php" class="mb-4">
            <label for="company" class="form-label">Seleccione la compañía:</label>
            <select name="company" id="company" class="form-select" onchange="this.form.submit()">
                <option value="1"'); echo ($companyId == 1) ? 'selected' : ''; echo('>Compañía 1</option>
                <option value="2"'); echo ($companyId == 2) ? 'selected' : ''; echo('>Compañía 2</option>
            </select>
        </form>

    </div>
      ');
      include ('functions.php');
      mostrar_plan_admin();
    }
    else if (isset($_SESSION['nombre'])) {
      echo('<header>
      <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="logo.jpg" alt="Logo" width="40" height="35" class="d-inline-block align-text-top">
            Net Tech
          </a>
          <form class="d-flex" action="solicitudes_usuario.php">
              <button class="btn btn-primary ms-md-1" style="--bs-btn-padding-x: 1rem;">MIS SOLICITUDES</button>
          </form>
            <a class="display 6" style:"color: rgb(252, 57, 57);" >Bienvenido '. htmlspecialchars($_SESSION['nombre']) . '</a>
            <form class="d-flex" action="cerrar_sesion.php">
            <button class="btn btn-danger ms-md-1" style="--bs-btn-padding-x: 1rem;">Cerrar Sesion</button>
        </form>
        
        <div class="display-7"> para asistencia personalizada : +52000000</div>
        </div>
      </nav>
      <h2 style="padding-left:2rem; position: sticky; color: rgb(252, 57, 57);">Nuestros Planes:</h2>
    </header>
    
    ');

    echo ('
      <div class="container mt-5">
        
        <form id="companySelector" method="GET" action="selector.php" class="mb-4">
            <label for="company" class="form-label">Seleccione la compañía:</label>
            <select name="company" id="company" class="form-select" onchange="this.form.submit()">
                <option value="1"'); echo ($companyId == 1) ? 'selected' : ''; echo('>Compañía 1</option>
                <option value="2"'); echo ($companyId == 2) ? 'selected' : ''; echo('>Compañía 2</option>
            </select>
        </form>

    </div>
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
              <a href="sign_in.html" class="btn btn-light" style="--bs-btn-padding-x: 1rem;"><u>Registrarme</u></a>
            <form class="d-flex" action="login.html">
              <button onclick="login()" class="btn btn-danger ms-md-1" style="--bs-btn-padding-x: 1rem;">Iniciar Sesion</button>
          </form>
          <a> para asistencia personalizada : +52000000</a>
          </div>
        </nav>
      
      </header>
      
      ');

      echo ('
      <div class="container mt-5">
        
        <form id="companySelector" method="GET" action="selector.php" class="mb-4">
            <label for="company" class="form-label">Seleccione la compañía:</label>
            <select name="company" id="company" class="form-select" onchange="this.form.submit()">
                <option value="1"'); echo ($companyId == 1) ? 'selected' : ''; echo('>Compañía 1</option>
                <option value="2"'); echo ($companyId == 2) ? 'selected' : ''; echo('>Compañía 2</option>
            </select>
        </form>

    </div>
      ');
      include ('functions.php');
      
      mostrar_plan();
    }
    ?>
    

    
    <script src="./js/bootstrap.min.js"></script>
</body>
</html>
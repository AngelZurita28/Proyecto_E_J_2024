<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['nombre'])){
  header('LOCATION: login.html');
}
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
<body class="body-custom-bg">

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

  <?php
    $plan_id = $_GET['plan_id'];
    $_SESSION['plan_id'] = $plan_id;
    include 'conexion.php';

    $sql = "EXECUTE obtenerProducto_id $plan_id;";
    $stmt = sqlsrv_query($conn, $sql);
    sqlsrv_execute($stmt);
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
      $_SESSION['precio'] = $row['precio'];
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
      <form action="registro_instalaciones.php" method="get">
      <div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
        <div class="container rounded-4 bg-light" style="padding: 2rem;">
              <p style="padding-top: 2rem;">Direccion de instalacion</p>
            <div class="row g-2">
                <div class="col-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="nombre de la calle #0000">
                    <label for="direccion">Direccion</label>
                  </div>
                </div>
                <div class="col-2">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="codigo postal">
                      <label for="codigo_postal">Codigo Postal</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="colonia" name="colonia" placeholder="colonia">
                      <label for="colonia">Colonia</label>
                    </div>
                </div>
              </div>

            <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="ciudad" placeholder="Ciudad">
                    <label for="ciudad">Ciudad</label>
                  </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="estado" placeholder="estado">
                      <label for="estado">Estado</label>
                    </div>
                </div>
            </div> 

            

            <div class="row" style="padding: 2rem;">
                <div class="col text-center">
                    <input type="submit" class="btn btn-danger" style="width: 10rem;" value="contratar" action="registro_instalaciones.php">
                </div>
            </div>
        </form>
        </div>
    </div>' );
    
    } else {
      echo "no se encontro ningun plan";
    }
    ?>
    <script src="./js/bootstrap.min.js"></>
</body>
</html>
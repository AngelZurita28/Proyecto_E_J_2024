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

    <script>
        function actualizarPrecio() {
            // Obtener el valor del input numérico
            const equipos = document.getElementById('equipos').value;
            const equipos = document.getElementById('precio').value;
            // Calcular el nuevo precio
            const nuevoPrecio = precio + (50 * equipos);
            
            // Actualizar el precio mostrado en la página
            document.getElementById('precio').textContent = nuevoPrecio;
        }
    </script>

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
          <div class="col d-flex justify-content-center text-end display-6 align-items-center" style="color: rgb(252, 57, 57);" id="precio" name="precio">
          '.htmlspecialchars($row['precio']).'
          </div>
        </div>
        </div>
      </div>
      <form action="pago.php" method="get">
      <div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
        <div class="container rounded-4 bg-light" style="padding: 2rem;">
            <p>Modificar especificaciones del plan</p>
            <p> cualquier alteracion hara que el precio este sujeto a una revision de uno de nuestros tecnicos</p>
            <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="equipos" name="equipos" placeholder="1" min="0" value="'.htmlspecialchars($row['equipos']).'" oninput="actualizarPrecio()">
                    <label for="cantidad_equipos">Cantidad de equipos EXTRAS</label>
                  </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="number" class="form-control" id="area_instalacion" placeholder="1" min="0" value="'.htmlspecialchars($row['metros']).'">
                      <label for="area_instalacion">Area de instalacion (m2)</label>
                    </div>
                  </div>
              </div>
              <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="plantas" placeholder="1" min="0" value="1">
                    <label for="plantas">Plantas</label>
                  </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="number" class="form-control" id="ancho_banda" placeholder="1" min="1000" step="1000" value="1000">
                      <label for="ancho_banda">Ancho de banda en red local (Mbps)</label>
                    </div>
                  </div>
              </div>
              
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

            <p style="padding-top: 2rem;">Datos personales</p>
            <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nombre" placeholder="nombre">
                    <label for="ciudad">Nombre completo</label>
                  </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="numero_telefono" pattern="\d*" inputmode="numeric" placeholder="numero de telefono">
                      <label for="estado">Numero de telefono</label>
                    </div>
                </div>
            </div> 

            <div class="row" style="padding: 2rem;">
                <div class="col text-center">
                    <input type="submit" class="btn btn-danger" style="width: 10rem;" value="contratar" action="pago.php">
                </div>
            </div>
        </form>
        </div>
    </div>' );
    
    } else {
      echo "no se encontro ningun plan";
    }


    ?>

    <!-- <div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
        <div class="container rounded-4 bg-light" style="padding: 2rem;">
            <p>Modificar especificaciones del plan</p>
            <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="cantidad_equipos" placeholder="1" min="0" value="0" oninput="actualizarPrecio()">
                    <label for="cantidad_equipos">Cantidad de equipos EXTRAS</label>
                  </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="number" class="form-control" id="area_instalacion" placeholder="1" min="0" value="0">
                      <label for="area_instalacion">Area de instalacion (m2)</label>
                    </div>
                  </div>
              </div>
              <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="plantas" placeholder="1" min="0" value="0">
                    <label for="plantas">Plantas</label>
                  </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="number" class="form-control" id="ancho_banda" placeholder="1" min="1000" step="1000" value="0">
                      <label for="ancho_banda">Ancho de banda en red local (Mbps)</label>
                    </div>
                  </div>
              </div>

              <p style="padding-top: 2rem;">Direccion de instalacion</p>
            <div class="row g-2">
                <div class="col-6">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="direccion" placeholder="nombre de la calle #0000">
                    <label for="direccion">Direccion</label>
                  </div>
                </div>
                <div class="col-2">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="codigo_postal" placeholder="codigo postal">
                      <label for="codigo_postal">Codigo Postal</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="colonia" placeholder="colonia">
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

            <p style="padding-top: 2rem;">Datos personales</p>
            <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nombre" placeholder="nombre">
                    <label for="ciudad">Nombre completo</label>
                  </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="numero_telefono" pattern="\d*" inputmode="numeric" placeholder="numero de telefono">
                      <label for="estado">Numero de telefono</label>
                    </div>
                </div>
            </div> 

            <div class="row" style="padding: 2rem;">
                <div class="col text-center">
                   <form action="pago.php" method="get">
                    <input type="submit" class="btn btn-danger" style="width: 10rem;" value="contratar" onclick="irAPagina2()">
                  </form>
                </div>
            </div>
        
        </div>
    </div> -->
       

    <script src="./js/bootstrap.min.js"></>
</body>
</html>
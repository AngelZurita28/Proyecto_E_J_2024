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
<div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
        <a href="home.php" type="button" class="btn btn-primary"> &lt; REGRESAR </a>
      </div>
<div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
<form action="plan_agregado.php" method="get">
        <div class="container rounded-4 bg-light" style="padding: 2rem;">
            <p>Agregar especificaciones del plan</p>
            <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="1" min="0" value="0" oninput="actualizarPrecio()">
                    <label for="cantidad_equipos">Nombre del Plan</label>
                  </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="1" min="0" value="0">
                      <label for="area_instalacion">Descripcion del Plan</label>
                    </div>
                  </div>
              </div>
              <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="megas" name="megas" placeholder="1" step="10" value="0">
                    <label for="plantas">Cantidad Megas</label>
                  </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="number" class="form-control" id="precio" name="precio" placeholder="1" value="0">
                      <label for="ancho_banda">Precio</label>
                    </div>
                  </div>
              </div>
              <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="equipos" name="equipos" placeholder="1" value="0">
                    <label for="plantas">Cantidad de equipos en Red</label>
                  </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                      <input type="number" class="form-control" id="metros" name="metros" placeholder="1" step="10" value="0">
                      <label for="ancho_banda">Metros cuadrados de instalacion</label>
                    </div>
                  </div>
              </div>

    </div>
    <div style="padding-top:2rem;">

        <input type="submit" class="btn btn-danger text" style="width: 10rem;" value="AGREGAR" >
      </div>
    </form>

</div>



</body>
</html>
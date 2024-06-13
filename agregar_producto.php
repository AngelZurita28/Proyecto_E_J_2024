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
</head>
<body class="body-custom-bg">
<div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
        <a href="home_2.php" type="button" class="btn btn-primary"> &lt; REGRESAR </a>
      </div>
<div class="container" style="padding-top: 1rem; padding-bottom: 1rem;">
<form action="producto_agregado.php" method="get">
        <div class="container rounded-4 bg-light" style="padding: 2rem;">
            <p>Agregar especificaciones del Producto</p>
            <div class="row g-2">
                <div class="col-md">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nombre" name="nombre" value="">
                    <label for="Nombre_Producto">Nombre del Producto</label>
                  </div>
                </div>
                <div class="col-md">
                  <div class="form-floating">
                  <input type="text" class="form-control" id="descripcion" name="descripcion">
                  <label for="Descripcion">Descripcion</label>
                  </div>
                </div>
            </div>
            
              <div class="row g-2">
                
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
                      <input type="number" class="form-control" id="inventario" name="inventario" placeholder="1" min="1" value="0">
                      <label for="ancho_banda">Inventario</label>
                    </div>
                  </div>
              </div>

    </div>
    <div style="padding-top:2rem;">

        <input type="submit" class="btn btn-primary text" style="width: 10rem;" value="AGREGAR" >
      </div>
    </form>

</div>



</body>
</html>
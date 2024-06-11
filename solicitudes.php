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
        <a href="home.php" type="button" class="btn btn-primary"> &lt; REGRESAR </a>
      </div>

<div class="container text-center alaign-items-center bg-light rounded-4">

<div class="row">
            <div class="col d-flex">
            ID
            </div>
            <div class="col d-flex">
            numero de orden
            </div>
            <div class="col d-flex">
            id del plan
            </div>
            <div class="col d-flex">
            Estado de solicitud
            </div>
            <div class="col d-flex">
            Direccion
            </div>
        
        </div>

    <?php


include 'conexion.php';
    
$sql = "SELECT * FROM Instalaciones WHERE estado = 1";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo('
        <div class="row">
            <div class="col d-flex">
            '.htmlspecialchars($row['id']).'
            </div>
            <div class="col d-flex">
            '.htmlspecialchars($row['numero_orden']).'
            </div>
            <div class="col d-flex">
            '.htmlspecialchars($row['id_plan']).'
            </div>
            <div class="col d-flex">
            '.htmlspecialchars($row['estado']).'
            </div>
            <div class="col d-flex">
            '.htmlspecialchars($row['direccion']).'
            </div>
        
        </div>
        ');

    }
} else {
    echo "<p>No hay productos disponibles.</p>";
}



?>



</div>

</body>
</html>
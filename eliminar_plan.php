<?php
include 'conexion.php';
    
$plan_id = $_GET['plan_id'];

$sql = "UPDATE Plan SET estado_plan = 0 WHERE id='$plan_id'";
$result = $conn->query($sql);

echo('
<h1> PLAN DESACTIVADO</h1>
<p>volver al inicio</p>
<form action="home.php" method="get">
        <button type="submit" class="button">Ir a Home</button>
    </form>

');

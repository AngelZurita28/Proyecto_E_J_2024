<?php

$nombre = $_GET['nombre'];
$megas = $_GET['megas'];
$precio = $_GET['precio'];
$equipos = $_GET['equipos'];
$metros = $_GET['metros'];

include 'conexion.php';
    
    $sql = "EXECUTE InsertarProducto '$nombre', '$megas', '$equipos', '$metros' , 1, 1, '$precio';";
    $stmt = sqlsrv_query($conn, $sql);
    

header('LOCATION: home_1.php');
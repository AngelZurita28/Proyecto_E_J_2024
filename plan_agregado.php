<?php

$nombre = $_GET['nombre'];
$descripcion = $_GET['descripcion'];
$megas = $_GET['megas'];
$precio = $_GET['precio'];
$equipos = $_GET['equipos'];
$metros = $_GET['metros'];

include 'conexion.php';
    
    $sql = "INSERT INTO Plan (nombre, descripcion, megas, precio, equipos, metros) 
    VALUES ('$nombre', '$descripcion','$megas', '$precio', '$equipos', '$metros')";
    $result = $conn->query($sql);
    

header('LOCATION: home.php');
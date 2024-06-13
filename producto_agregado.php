
<?php
session_start();

include 'conexion.php';
$nombre = $_GET['nombre'];
$descripcion = $_GET['descripcion'];
$precio = $_GET['precio'];
$inventario= $_GET['inventario'];

    $sql = "EXECUTE InsertarProducto2 '$nombre', '$descripcion', 1, 2, '$precio', '$inventario';";
    $stmt = sqlsrv_query($conn, $sql);
    
header('LOCATION: home_2.php');
exit();

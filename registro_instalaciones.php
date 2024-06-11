<?php
session_start();
include 'conexion.php';

$numero_servicio = mt_rand(1, 10000);;
$plan_id = (INT)$_SESSION['plan_id'];
$direccion = $_SESSION['direccion'];

    $sql = "INSERT INTO Instalaciones (numero_orden, id_plan, direccion) VALUES ('$numero_servicio', '$plan_id', '$direccion')";
    $result = $conn->query($sql);

    echo ('solicitud exitosa');

    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión
    header("Location: home.php"); // Redirige al usuario a la página de inicio de sesión
    exit();

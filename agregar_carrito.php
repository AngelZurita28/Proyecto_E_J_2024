<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id_producto = $_GET["id_producto"];

    if (!isset($_SESSION["carrito"])) {
        $_SESSION["carrito"] = array();
    }

    if (!array_key_exists($id_producto, $_SESSION["carrito"])) {
        $_SESSION["carrito"][$id_producto] = 1;
    } else {
        $_SESSION["carrito"][$id_producto] += 1;
    }
}

header("Location: carrito.php");

<?php
session_start();
include 'conexion.php';

$id_cliente = $_SESSION['id_cliente'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id_compania = 2;  // Id de la compañía fija
    $id_sucursal = 2;
    $fecha = date("Y-m-d H:i:s");
    $total = 0;

    // Calcular el total del carrito
    foreach ($_SESSION["carrito"] as $id_producto => $cantidad) {
        $sql = "SELECT precio FROM Producto WHERE id_producto = ?";
        $params = array($id_producto);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $precio = $row["precio"];
            $total += $precio * $cantidad;
        }

        sqlsrv_free_stmt($stmt);
    }

    // Llamar al procedimiento almacenado InsertarOrden
    $sql = "EXECUTE InsertarOrden ?, ?, ?, ?, ?";
    $params = array(
        array(&$id_compania, SQLSRV_PARAM_IN),
        array(&$id_cliente, SQLSRV_PARAM_IN),
        array(&$id_sucursal, SQLSRV_PARAM_IN),
        array(&$fecha, SQLSRV_PARAM_IN),
        array(&$precio, SQLSRV_PARAM_IN)
    );
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    $result = sqlsrv_execute($stmt);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Obtener el id_orden resultante
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC);
    $id_orden = $row[0]; // Obtener el id_orden generado

    // Insertar los productos en la tabla Orden_Producto
    foreach ($_SESSION["carrito"] as $id_producto => $cantidad) {
        $sql = "INSERT INTO Orden_Producto (id_orden, id_producto, id_proveedor_producto, id_compania) VALUES (?, ?, (SELECT id_proveedor FROM Producto WHERE id_producto = ?), ?)";
        $params = array($id_orden, $id_producto, $id_producto, $id_compania);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    // Obtener el nombre del cliente
    $sql = "SELECT nombre FROM Cliente WHERE id_cliente = ?";
    $params = array($id_cliente);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $nombre_cliente = "";
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $nombre_cliente = $row["nombre"];
    }

    // Obtener detalles de los productos
    $productos = [];
    foreach ($_SESSION["carrito"] as $id_producto => $cantidad) {
        $sql = "SELECT nombre, precio FROM Producto WHERE id_producto = ?";
        $params = array($id_producto);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $productos[] = [
                "nombre" => $row["nombre"],
                "precio" => $row["precio"],
                "cantidad" => $cantidad,
                "total" => $row["precio"] * $cantidad
            ];
        }
    }

    // Limpiar el carrito
    unset($_SESSION["carrito"]);

    sqlsrv_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Compra</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="my-4">Resumen de Compra</h1>
    <div class="card">
        <div class="card-header">
            <h3>Detalles de la Orden</h3>
        </div>
        <div class="card-body">
            <p><strong>Nombre del Comprador:</strong> <?php echo $nombre_cliente; ?></p>
            <p><strong>ID Compañía:</strong> <?php echo $id_compania; ?></p>
            <p><strong>Número de Orden:</strong> <?php echo $id_orden; ?></p>
            <p><strong>Total:</strong> $<?php echo $total; ?></p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo $producto["nombre"]; ?></td>
                            <td><?php echo $producto["cantidad"]; ?></td>
                            <td>$<?php echo $producto["precio"]; ?></td>
                            <td>$<?php echo $producto["total"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="home_2.php" class="btn btn-primary mt-3">Volver a la Tienda</a>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

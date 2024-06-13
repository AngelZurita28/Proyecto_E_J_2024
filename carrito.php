<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="my-4">Carrito de Compras</h1>
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
        <?php
        session_start();
        include 'conexion.php';

        $total = 0;

        if (isset($_SESSION["carrito"]) && !empty($_SESSION["carrito"])) {
            foreach ($_SESSION["carrito"] as $id_producto => $cantidad) {
                $sql = "SELECT nombre, precio FROM Producto WHERE id_producto = ?";
                $params = array($id_producto);
                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $nombre = $row["nombre"];
                    $precio = $row["precio"];
                    $total_producto = $precio * $cantidad;
                    $total += $total_producto;

                    echo '<tr>';
                    echo '<td>' . $nombre . '</td>';
                    echo '<td>' . $cantidad . '</td>';
                    echo '<td>$' . $precio . '</td>';
                    echo '<td>$' . $total_producto . '</td>';
                    echo '</tr>';
                }

                sqlsrv_free_stmt($stmt);
            }
        } else {
            echo '<tr>';
            echo '<td colspan="4" class="text-center">No hay productos en el carrito</td>';
            echo '</tr>';
        }

        sqlsrv_close($conn);
        ?>
        </tbody>
    </table>
    <h3>Total: $<?php echo $total; ?></h3>
    <a href="home_2.php" class="btn btn-primary">Seguir Comprando</a>
    <a href="checkout.php" class="btn btn-success">Proceder al Pago</a>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

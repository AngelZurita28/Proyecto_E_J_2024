<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Orden</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
<?php
session_start();
include 'conexion.php';

date_default_timezone_set("America/Mexico_City");

$id_cliente = $_SESSION['id_cliente'];
$id_compania = 1; // Tu código original establece este valor, asegúrate de cambiarlo si es dinámico
$id_sucursal = 1;
$precio = $_SESSION['precio'];
$fecha = date("Y-m-d H:i:s");
$direccion = $_GET['direccion'];
$codigo_postal = $_GET['codigo_postal'];
$colonia = $_GET['colonia'];

// Insertar la orden
$sql = "EXECUTE InsertarOrden ?, ?, ?, ?, ?";
$params = array(
    array(&$id_compania, SQLSRV_PARAM_IN),
    array(&$id_cliente, SQLSRV_PARAM_IN),
    array(&$id_sucursal, SQLSRV_PARAM_IN),
    array(&$fecha, SQLSRV_PARAM_IN),
    array(&$precio, SQLSRV_PARAM_IN)
);

$stmt = sqlsrv_prepare($conn, $sql, $params);
if (!$stmt) {
    echo "Error al preparar la consulta de InsertarOrden: " . sqlsrv_errors();
} else {
    $result = sqlsrv_execute($stmt);
    if ($result) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC);
        $id_orden = $row[0]; // Obtener el id_orden generado

        // Obtener el nombre y apellido del comprador (cliente)
        $sql_cliente = "SELECT nombre, apellido FROM Cliente WHERE id_cliente = ?";
        $params_cliente = array(array(&$id_cliente, SQLSRV_PARAM_IN));
        $stmt_cliente = sqlsrv_query($conn, $sql_cliente, $params_cliente);
        if ($stmt_cliente === false) {
            echo "Error al ejecutar la consulta de nombre y apellido del cliente: " . sqlsrv_errors();
        } else {
            $row_cliente = sqlsrv_fetch_array($stmt_cliente, SQLSRV_FETCH_ASSOC);
            $nombre_cliente = $row_cliente['nombre'];
            $apellido_cliente = $row_cliente['apellido'];

            // Obtener el nombre de la compañía
            $sql_compania = "SELECT nombre FROM Compania WHERE id_compania = ?";
            $params_compania = array(array(&$id_compania, SQLSRV_PARAM_IN));
            $stmt_compania = sqlsrv_query($conn, $sql_compania, $params_compania);
            if ($stmt_compania === false) {
                echo "Error al ejecutar la consulta de nombre de compañía: " . sqlsrv_errors();
            } else {
                $row_compania = sqlsrv_fetch_array($stmt_compania, SQLSRV_FETCH_ASSOC);
                $nombre_compania = $row_compania['nombre'];

                // Insertar los detalles de instalación
                $sql_instalacion = "INSERT INTO InstalacionesPlanes (direccion, codigo_postal, colonia, id_orden, id_compania, id_cliente) VALUES (?, ?, ?, ?, ?, ?)";
                $params_instalacion = array(
                    array(&$direccion, SQLSRV_PARAM_IN),
                    array(&$codigo_postal, SQLSRV_PARAM_IN),
                    array(&$colonia, SQLSRV_PARAM_IN),
                    array(&$id_orden, SQLSRV_PARAM_IN),
                    array(&$id_compania, SQLSRV_PARAM_IN),
                    array(&$id_cliente, SQLSRV_PARAM_IN)
                );

                $stmt_instalacion = sqlsrv_prepare($conn, $sql_instalacion, $params_instalacion);
                if (!$stmt_instalacion) {
                    echo "Error al preparar la consulta de detalles de instalación: " . sqlsrv_errors();
                } else {
                    $result_instalacion = sqlsrv_execute($stmt_instalacion);
                    if ($result_instalacion) {
                        ?>

                        <div class="container">
                            <h2 class="mt-5">Resumen de la Orden</h2>
                            <p>Fecha: <?php echo $fecha; ?></p>
                            <p>Comprador: <?php echo $nombre_cliente . " " . $apellido_cliente; ?></p>
                            <p>Compañía: <?php echo $nombre_compania; ?></p>
                            <p>Precio: $<?php echo number_format($precio, 2); ?></p>
                            <p>Dirección: <?php echo $direccion; ?></p>
                            <p>Código Postal: <?php echo $codigo_postal; ?></p>
                            <p>Colonia: <?php echo $colonia; ?></p>
                        </div>

                        <div class="container mt-3">
                            <a href="home_1.php" class="btn btn-primary">Regresar a la página de inicio</a>
                        </div>

                        <?php
                    } else {
                        echo "Error al ejecutar la consulta de detalles de instalación: " . sqlsrv_errors();
                    }
                }
            }
        }
    } else {
        echo "Error al ejecutar la consulta de InsertarOrden: " . sqlsrv_errors();
    }
}

// Cerrar la conexión y limpiar los recursos
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

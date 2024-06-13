<?php
session_start();

$home = $_SESSION['home'];
include 'conexion.php'; // Incluye el archivo de conexión a SQL Server

// Obtener el id_producto desde $_GET
$id_producto = $_GET['plan_id'];

// Preparar la consulta SQL para eliminar el producto
$sql = "DELETE FROM Producto WHERE id_producto = ?";
$params = array($id_producto);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    // Si hay un error en la consulta
    echo "Error en la ejecución de la consulta.\n";
    die(print_r(sqlsrv_errors(), true));
}

// Verificar si se eliminó correctamente al menos una fila
$rows_affected = sqlsrv_rows_affected($stmt);
if ($rows_affected === false) {
    // Manejar el caso de error en la verificación de filas afectadas
    echo "Error al obtener las filas afectadas.\n";
    die(print_r(sqlsrv_errors(), true));
}

// Verificar si se eliminó al menos una fila
if ($rows_affected > 0) {
    echo '
    <h1>Producto Eliminado</h1>
    <p>Volver al inicio</p>
    <form action="'.$home.'" method="get">
        <button type="submit" class="button">Ir a Home</button>
    </form>
    ';
} else {
    echo '<h1>No se encontró el producto especificado o no se pudo eliminar.</h1>';
}

// Cerrar la conexión y liberar recursos
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

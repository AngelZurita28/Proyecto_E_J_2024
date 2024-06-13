<?php
include 'conexion.php';

session_start();
$home = $_SESSION['home'];
// Obtener el año, mes y la compañía seleccionados, o valores por defecto
$year = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");
$month = isset($_GET['month']) ? (int)$_GET['month'] : date("n");
$id_compania = isset($_GET['id_compania']) ? $_GET['id_compania'] : 'todas';
$id_compania = $id_compania === 'todas' ? null : (int)$id_compania;

// Obtener lista de compañías
$sql_companias = "SELECT id_compania, nombre FROM Compania";
$stmt_companias = sqlsrv_query($conn, $sql_companias);

$companias = [];
while ($row = sqlsrv_fetch_array($stmt_companias, SQLSRV_FETCH_ASSOC)) {
    $companias[] = $row;
}

// Llamar al procedimiento almacenado detallado
$sql = "{CALL sp_reporte_ventas_detallado(?, ?, ?)}";
$params = array(
    array($year, SQLSRV_PARAM_IN),
    array($month, SQLSRV_PARAM_IN),
    array($id_compania, SQLSRV_PARAM_IN)
);

$stmt = sqlsrv_query($conn, $sql, $params);

$reporte_ventas_detallado = [];

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // Convertir el objeto DateTime a formato deseado para mostrar
    $fecha_formateada = $row['fecha']->format('Y-m-d');

    // Agregar la fila al array
    $reporte_ventas_detallado[] = [
        'id_orden' => $row['id_orden'],
        'nombre_compania' => $row['nombre_compania'],
        'id_sucursal' => $row['id_sucursal'],
        'id_cliente' => $row['id_cliente'],
        'fecha' => $fecha_formateada,
        'total' => $row['total']
    ];
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Órdenes</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <style>
        .body-custom-bg {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body class="body-custom-bg">
<div class="container mt-5">
    <h1 class="mb-4">Detalle de Órdenes del Mes <?php echo $month; ?> - Año <?php echo $year; ?></h1>
    
    <form method="GET" action="" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="year" class="form-label">Seleccione el año:</label>
            <select name="year" id="year" class="form-select" onchange="this.form.submit()">
                <?php
                // Generar opciones para los últimos 10 años
                $current_year = date("Y");
                for ($i = $current_year; $i >= $current_year - 10; $i--) {
                    $selected = ($i == $year) ? 'selected' : '';
                    echo "<option value=\"$i\" $selected>$i</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="month" class="form-label">Seleccione el mes:</label>
            <select name="month" id="month" class="form-select" onchange="this.form.submit()">
                <?php
                // Generar opciones para los meses
                $nombres_meses = [
                    1 => "Enero", 2 => "Febrero", 3 => "Marzo",
                    4 => "Abril", 5 => "Mayo", 6 => "Junio",
                    7 => "Julio", 8 => "Agosto", 9 => "Septiembre",
                    10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
                ];
                foreach ($nombres_meses as $m => $nombre_mes) {
                    $selected = ($m == $month) ? 'selected' : '';
                    echo "<option value=\"$m\" $selected>$nombre_mes</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="id_compania" class="form-label">Seleccione la compañía:</label>
            <select name="id_compania" id="id_compania" class="form-select" onchange="this.form.submit()">
                <option value="todas" <?php echo ($id_compania === null) ? 'selected' : ''; ?>>Todas las compañías</option>
                <?php
                // Generar opciones para las compañías
                foreach ($companias as $compania) {
                    $selected = ($compania['id_compania'] == $id_compania) ? 'selected' : '';
                    echo "<option value=\"{$compania['id_compania']}\" $selected>{$compania['nombre']}</option>";
                }
                ?>
            </select>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID Orden</th>
                <th>Nombre Compañía</th>
                <th>ID Sucursal</th>
                <th>ID Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($reporte_ventas_detallado as $orden) {
                echo "<tr>";
                echo "<td>{$orden['id_orden']}</td>";
                echo "<td>{$orden['nombre_compania']}</td>";
                echo "<td>{$orden['id_sucursal']}</td>";
                echo "<td>{$orden['id_cliente']}</td>";
                echo "<td>{$orden['fecha']}</td>"; // Mostrar fecha formateada
                echo "<td>{$orden['total']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="container">
  <div class="row">
    <div class="col">
        <?php
        echo('<a href="'.$home.'" class="btn btn-primary">REGRESAR</a>');
      ?>
    </div>
    <div class="col">
      <a href="reporte_anual.php" class="btn btn-secondary">REPORTE ANUAL</a>
    </div>
  </div>
</div>

<script src="./js/bootstrap.min.js"></script>
</body>
</html>

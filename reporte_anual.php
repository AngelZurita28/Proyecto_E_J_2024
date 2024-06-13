<?php
include 'conexion.php';
session_start();
$home = $_SESSION['home'];

// Obtener el año y la compañía seleccionados, o valores por defecto
$year = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");
$id_compania = isset($_GET['id_compania']) ? $_GET['id_compania'] : 'todas';
$id_compania = $id_compania === 'todas' ? null : (int)$id_compania;

// Obtener lista de compañías
$sql_companias = "SELECT id_compania, nombre FROM Compania";
$stmt_companias = sqlsrv_query($conn, $sql_companias);

$companias = [];
while ($row = sqlsrv_fetch_array($stmt_companias, SQLSRV_FETCH_ASSOC)) {
    $companias[] = $row;
}

// Llamar al procedimiento almacenado
$sql = "{CALL reporte_ventas(?, ?)}";
$params = array(
    array($year, SQLSRV_PARAM_IN),
    array($id_compania, SQLSRV_PARAM_IN)
);

$stmt = sqlsrv_query($conn, $sql, $params);

$reporte_ventas = [];

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $reporte_ventas[] = $row;
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas del Año <?php echo $year; ?></title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <style>
        .body-custom-bg {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body class="body-custom-bg">
<div class="container mt-5">
    <h1 class="mb-4">Reporte de Ventas del Año <?php echo $year; ?></h1>
    
    <form method="GET" action="" class="row g-3 mb-4">
        <div class="col-md-6">
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

        <div class="col-md-6">
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
                <th>Mes</th>
                <th>Total de Órdenes</th>
                <th>Total de Dinero</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Inicializar array con los nombres de los meses
            $nombres_meses = [
                1 => "Enero", 2 => "Febrero", 3 => "Marzo",
                4 => "Abril", 5 => "Mayo", 6 => "Junio",
                7 => "Julio", 8 => "Agosto", 9 => "Septiembre",
                10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
            ];

            // Mostrar filas de la tabla
            foreach ($nombres_meses as $mes => $nombre_mes) {
                $total_ordenes = 0;
                $total_dinero = 0;

                foreach ($reporte_ventas as $venta) {
                    if ($venta['mes'] == $mes) {
                        $total_ordenes = $venta['total_ordenes'];
                        $total_dinero = $venta['total_dinero'];
                        break;
                    }
                }

                echo "<tr>";
                echo "<td>{$nombre_mes}</td>";
                echo "<td>{$total_ordenes}</td>";
                echo "<td>{$total_dinero}</td>";
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
      <a href="reporte_mensual.php" class="btn btn-secondary">REPORTE MENSUAL</a>
    </div>
  </div>
</div>


<script src="./js/bootstrap.min.js"></script>
</body>
</html>

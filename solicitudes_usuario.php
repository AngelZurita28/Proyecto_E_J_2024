<?php
session_start();

include 'conexion.php';

$id_cliente = $_SESSION['id_cliente'];
$sql = "SELECT InstalacionesPlanes.*, Orden.fecha
        FROM InstalacionesPlanes
        JOIN Orden ON InstalacionesPlanes.id_orden = Orden.id_orden
        ;";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        body {
            background-color: #dfdddd; /* Color de fondo personalizado */
        }
        .container {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        .card {
            background-color: #fff; /* Fondo de la tarjeta */
            border: 1px solid rgba(0,0,0,.125); /* Borde de la tarjeta */
            border-radius: .25rem; /* Borde redondeado */
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15); /* Sombra */
            padding: 1rem; /* Espaciado interior */
        }
    </style>
</head>
<body>

<div class="container">
    <a href="home_1.php" class="btn btn-primary">&lt; REGRESAR</a>
</div>

<div class="container">
    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Instalación</th>
                        <th>Número de Orden</th>
                        <th>Fecha</th>
                        <th>Dirección</th>
                        <th>Código Postal</th>
                        <th>Colonia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_instalacion']) ?></td>
                            <td><?= htmlspecialchars($row['id_orden']) ?></td>
                            <td><?= htmlspecialchars($row['fecha']->format('Y-m-d H:i:s')) ?></td>
                            <td><?= htmlspecialchars($row['direccion']) ?></td>
                            <td><?= htmlspecialchars($row['codigo_postal']) ?></td>
                            <td><?= htmlspecialchars($row['colonia']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="./js/bootstrap.min.js"></script>

</body>
</html>

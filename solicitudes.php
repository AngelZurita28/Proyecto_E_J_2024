<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Instalaciones y Órdenes</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #dfdddd; /* Color de fondo personalizado */
        }
        .container {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .card-container {
            background-color: #ffffff; /* Color de fondo del contenedor */
            border-radius: 10px; /* Bordes redondeados */
            padding: 1.5rem; /* Espaciado interno */
            margin-top: 2rem; /* Margen superior */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra ligera */
        }
        .card-header {
            background-color: #f0f0f0; /* Color de fondo del encabezado */
            padding: 1rem; /* Espaciado interno del encabezado */
            border-radius: 8px 8px 0 0; /* Bordes redondeados en la parte superior */
            margin-bottom: 1rem; /* Margen inferior */
        }
        .card-body {
            padding: 0; /* Eliminar el espaciado interno del cuerpo */
        }
        .table th, .table td {
            vertical-align: middle; /* Alineación vertical centrada */
        }
    </style>
</head>
<body>

<div class="container">
    <a href="home_1.php" class="btn btn-primary">&lt; REGRESAR</a>
</div>

<div class="container card-container">
    <div class="card-header">
        <h4 class="text-center">Listado de Instalaciones</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>ID Cliente</th>
                        <th>ID Instalación</th>
                        <th>Número de Orden</th>
                        <th>Fecha</th>
                        <th>Dirección</th>
                        <th>Código Postal</th>
                        <th>Colonia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'conexion.php';

                    $sql = "SELECT InstalacionesPlanes.*, Orden.fecha
                            FROM InstalacionesPlanes
                            JOIN Orden ON InstalacionesPlanes.id_orden = Orden.id_orden";
                    $stmt = sqlsrv_query($conn, $sql);
                    if ($stmt === false) {
                        die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
                    }

                    // Iterar sobre los resultados e imprimir cada fila de la tabla
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $formattedDate = $row['fecha']->format('Y-m-d H:i:s');
                        echo '
                        <tr>
                            <td>'.htmlspecialchars($row['id_cliente']).'</td>
                            <td>'.htmlspecialchars($row['id_instalacion']).'</td>
                            <td>'.htmlspecialchars($row['id_orden']).'</td>
                            <td>'.htmlspecialchars($formattedDate).'</td>
                            <td>'.htmlspecialchars($row['direccion']).'</td>
                            <td>'.htmlspecialchars($row['codigo_postal']).'</td>
                            <td>'.htmlspecialchars($row['colonia']).'</td>
                        </tr>
                        ';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

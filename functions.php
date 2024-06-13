<?php 

function mostrar_plan_admin() {
    include('conexion.php');

    // Ejecutar la consulta
    $sql = "EXECUTE obtenerProducto;";
    $stmt = sqlsrv_query($conn, $sql);

    // Verificar si la consulta fue exitosa
    if ($stmt === false) {
        die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
    }

    // Iterar sobre los resultados e imprimir cada producto
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
?>
        <div class="col-md-12 mb-4" style="padding-left: 3rem;padding-right: 3rem;">
            <div class="card border rounded" style="padding: 1rem;">
                <div class="card-body" style="padding: 2rem;">
                    <h1 class="card-title text-danger"><?= htmlspecialchars($row['nombre']) ?></h1>
                    <h4 class="card-text"><?= htmlspecialchars($row['descripcion']) ?></h4>
                    <p class="card-text">Proveedor: <?= htmlspecialchars($row['nombre_proveedor']) ?></p>
                    <p class="card-text text-danger">$<?= htmlspecialchars($row['precio']) ?></p>
                </div>
                <div class="card-footer">
                    <form action="eliminar_plan.php" method="get">
                        <input type="hidden" name="plan_id" value="<?= htmlspecialchars($row['id_producto']) ?>">
                        <button type="submit" class="btn btn-danger btn-block">ELIMINAR</button>
                    </form>
                </div>
            </div>
        </div>
<?php
    } // Fin del bucle while
}
?>

<?php
function mostrar_plan() {
    include('conexion.php');

    // Ejecutar la consulta
    $sql = "EXECUTE obtenerProducto;";
    $stmt = sqlsrv_query($conn, $sql);

    // Verificar si la consulta fue exitosa
    if ($stmt === false) {
        die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
    }

    // Iterar sobre los resultados e imprimir cada producto
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
?>
        <div class="col-md-12 mb-4" style="padding-left: 3rem;padding-right: 3rem;">
            <div class="card border rounded" style="padding: 1rem;">
                <div class="card-body" style="padding: 2rem;">
                    <h1 class="card-title text-danger"><?= htmlspecialchars($row['nombre']) ?></h1>
                    <h4 class="card-text"><?= htmlspecialchars($row['descripcion']) ?></h4>
                    <p class="card-text">Proveedor: <?= htmlspecialchars($row['nombre_proveedor']) ?></p>
                    <p class="card-text text-danger">$<?= htmlspecialchars($row['precio']) ?></p>
                </div>
                <div class="card-footer">
                    <form action="plan.php" method="get">
                        <input type="hidden" name="plan_id" value="<?= htmlspecialchars($row['id_producto']) ?>">
                        <button type="submit" class="btn btn-primary btn-block">Lo Quiero!</button>
                    </form>
                </div>
            </div>
        </div>
<?php
    } // Fin del bucle while
}
?>






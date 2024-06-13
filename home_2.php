<?php
session_start();
$_SESSION['home'] = 'home_2.php';
$companyId = 2;
$companyName = "Compañía 2";
include 'conexion.php';

$sql = "{CALL ObtenerProductosCategoria2}";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die("Error al ejecutar el procedimiento almacenado: " . print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>.body-custom-bg {
        background-color:#f5f5f5 ; /* Color personalizado en hexadecimal */
    }
    
    </style>
</head>
<body class="body-custom-bg">

<!-- Barra de Navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Mi Tienda</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav ">
        <?php if (isset($_SESSION['nombre'])) : ?>
          <!-- Mostrar nombre de usuario y botón de cerrar sesión si la sesión está iniciada -->
          <li class="nav-item mx-2">
            <span class="navbar-text mr-3">Bienvenido, <?php echo $_SESSION['nombre']; ?></span>
          </li>
          <?php if ($_SESSION['nivel'] == 1) : ?>
            <li class="nav-item mx-2">
            <a class="btn btn-light mr-3" href="reporte_anual.php">REPORTE</a>
          </li>
            <!-- Mostrar botón para añadir producto solo si es administrador (nivel 1) -->
            <li class="nav-item mx-2">
              <a class="btn btn-primary mr-3" href="agregar_producto.php">Añadir Producto</a>
            </li>
          <?php endif; ?>
          <li class="nav-item mx-2">
            <a class="btn btn-danger" href="cerrar_sesion.php">Cerrar Sesión</a>
          </li>
        <?php else : ?>
          <!-- Mostrar botones de inicio de sesión y registro si la sesión no está iniciada -->
          <li class="nav-item mx-2">
            <a class="btn btn-light mr-3" href="login.html">Iniciar Sesión</a>
          </li>
          <li class="nav-item mx-2">
            <a class="btn btn-light" href="registrarse.html">Registrarse</a>
          </li>
          
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Contenido principal -->
<div class="container mt-5">
        <h1>Bienvenido a <?php echo $companyName; ?></h1>
        
        <form id="companySelector" method="GET" action="selector.php" class="mb-4">
            <label for="company" class="form-label">Seleccione la compañía:</label>
            <select name="company" id="company" class="form-select" onchange="this.form.submit()">
                <option value="1" <?php echo ($companyId == 1) ? 'selected' : ''; ?>>Compañía 1</option>
                <option value="2" <?php echo ($companyId == 2) ? 'selected' : ''; ?>>Compañía 2</option>
            </select>
        </form>

        <!-- Contenido específico de la compañía 2 -->
        <p>Este es el contenido para la Compañía 2.</p>
    </div>
<div class="container mt-5">
    <div class="row">
        <?php
        // Iterar sobre los resultados del procedimiento almacenado y mostrar los productos
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo '
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row['nombre']) . '</h5>
                        <p class="card-text">' . htmlspecialchars($row['descripcion']) . '</p>
                        <p class="card-text">Inventario: ' . htmlspecialchars($row['inventario']) . '</p>
                        <p class="card-text">Proveedor: ' . htmlspecialchars($row['nombre_proveedor']) . '</p>
                        <p class="card-text">Precio: $' . htmlspecialchars($row['precio']) . '</p>';

            // Mostrar botón "Añadir al Carrito" para usuarios comunes
            if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] != 1) {
                echo '
                <a href="agregar_carrito.php?id_producto=' . htmlspecialchars($row['id_producto']) . '" class="btn btn-success">Añadir al Carrito</a>';
            } else {
                // Mostrar botón "Eliminar" para administradores
                echo '
                <a href="eliminar_plan.php?plan_id=' . htmlspecialchars($row['id_producto']) . '" class="btn btn-danger">Eliminar</a>';
            }

            echo '
                    </div>
                </div>
            </div>
            ';
        }
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        ?>
    </div>
</div>

<!-- Bootstrap JS y otros scripts -->    
 <script src="./js/bootstrap.min.js"></script>
</body>
</html>


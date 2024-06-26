<?php
session_start();
$home = $_SESSION['home'];

include('conexion.php');

// Verificar si se recibieron las variables a través del método POST
if (isset($_POST['correo']) && isset($_POST['clave'])) {
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    // Asegurarse de que la conexión se haya establecido correctamente
    if ($conn === false) {
        die("Error en la conexión a la base de datos: " . print_r(sqlsrv_errors(), true));
    }

    // Consulta SQL para verificar si el correo existe
    $sql = "SELECT * FROM Cliente WHERE correo = ?";
    $params = array($correo);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt === false) {
        die("Error al preparar la consulta: " . print_r(sqlsrv_errors(), true));
    }

    // Ejecutar la consulta
    if (sqlsrv_execute($stmt)) {
        // Verificar si se encontró un usuario con el correo proporcionado
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Verificar si la clave es correcta
            $hashedPassword = $row['clave'];
            if (password_verify($clave, $hashedPassword)) {
                echo "Inicio de sesión exitoso!";
                $_SESSION['id_cliente'] = $row['id_cliente'];
                $_SESSION['nombre'] = $row['nombre'];
                header('LOCATION: '.$home);
            } else {
                echo "Clave incorrecta.";
                header('LOCATION: login.html');

            }
        } else {
            echo "El usuario no existe.";
            header('LOCATION: login.html');
        }
    } else {
        die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
    }

    // Liberar recursos
    sqlsrv_free_stmt($stmt);
} else {
    echo "Por favor, proporcione correo y clave.";
    header('LOCATION: '.$home);
}

// Cerrar la conexión
sqlsrv_close($conn);

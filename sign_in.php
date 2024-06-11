<?php
include('conexion.php');

// Verificar si se recibieron las variables a través del método POST
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo']) && isset($_POST['clave'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    // Asegurarse de que la conexión se haya establecido correctamente
    if ($conn === false) {
        die("Error en la conexión a la base de datos: " . print_r(sqlsrv_errors(), true));
    }

    // Hashear la clave
    $hashedPassword = password_hash($clave, PASSWORD_DEFAULT);

    // Llamar al stored procedure para insertar el nuevo cliente
    $sql = "EXECUTE insertar_cliente ?, ?, ?, ?";
    $params = array(
        array(&$nombre, SQLSRV_PARAM_IN),
        array(&$apellido, SQLSRV_PARAM_IN),
        array(&$correo, SQLSRV_PARAM_IN),
        array(&$hashedPassword, SQLSRV_PARAM_IN)
    );

    $stmt = sqlsrv_query($conn, $sql, $params);
    // Obtener el resultado del stored procedure
        $result = sqlsrv_get_field($stmt, 0);
        if ($result == 0) {
            echo "El correo ya está registrado.";
            header('LOCATION: login.html');
        } else {
            echo "Registro exitoso!";
        }
    

    // Liberar recursos
    sqlsrv_free_stmt($stmt);
} else {
    echo "Por favor, proporcione nombre, apellido, correo y clave.";
}

// Cerrar la conexión
sqlsrv_close($conn);

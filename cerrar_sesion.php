<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$home = $_SESSION['home'];
// Eliminar todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, también se debe eliminar la cookie de sesión.
// Nota: Esto destruirá la sesión, y no sólo los datos de la sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión
session_destroy();
echo'se elimino la sesion';

header("Location:".$home);
exit();


<?php
session_start();

if (isset($_GET['company'])) {
    $companyId = (int)$_GET['company'];
    switch ($companyId) {
        case 1:
            header("Location: home_1.php");
            break;
        case 2:
            header("Location: home_2.php");
            break;
        default:
            header("Location: home_1.php");
            break;
    }
    exit();
} else {
    header("Location: home_1.php");
    exit();
}

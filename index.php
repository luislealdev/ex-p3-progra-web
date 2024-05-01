<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['role'])) {
    header('location: ./auth/index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MyZoo</title>
    <link rel="stylesheet" href="./public/global.css">
    <link rel="stylesheet" href="https://luisrrleal.com/styles/leal-styles.css">
</head>

<body>
    <main class="m-100">
        <h1>¡Hola! <?= $_SESSION["nombre"] ?></h1>
        <p>Trabajos...</p>
        <?= include "./class/comida.php"; ?>
    </main>
</body>

</html>
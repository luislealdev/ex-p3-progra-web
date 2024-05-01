<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['role'])) {
    header('location: ../auth/index.php');
}

include '../components/navbar.php';
include "../class/comida.php";
?>

</main>
</body>

</html>
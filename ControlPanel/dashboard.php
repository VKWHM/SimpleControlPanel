<?php
    session_start();
    if (!isset($_SESSION['Username'])) {
        header("Location: index.php");
        exit();
    }
    $pageTitle = "Dashboard";
    include "ini.php";
    echo "Hello World";
    include $tpl . "footer.php";
?>

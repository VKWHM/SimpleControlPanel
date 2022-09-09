<?php
    // Router
    $tpl = "include/template/";
    $css = "layout/css/";
    $js = "layout/js/";
    $lng = "include/languages/";
    $func = "include/functions/";
    // Database Connect File Include
    include "connect.php";
    // Functions Include
    include $func . "functions.php";
    // Page Includes 
    include $lng . "english.php";
    include $tpl . "header.php";
    if (!isset($noNavBar)) {include $tpl . "navbar.php";}
?>

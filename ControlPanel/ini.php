<?php
    // Router
    $tpl = "include/template/";
    $css = "layout/css/";
    $js = "layout/js/";
    $lng = "include/languages/";
    // Database Connect File Include
    include "connect.php";
    // Page Includes 
    include $lng . "english.php";
    include $tpl . "header.php";
    if (!isset($noNavBar)) {include $tpl . "navbar.php";}
?>

<?php
    /*
     * Title Function That Echo The Page TItle In Case The Page
     * Has The Variable $pageTitle And Echo Defualt Title For Other Pages
     */
    
    function getTitle() {
        global $pageTitle;

        if (isset($pageTitle)) {
            return $pageTitle;
        } else {
            return "Default";
        }

    }
/*
 * Redirect Function [ This Function Accept Parameteres ]
 * $errorMsg = ehco The Error Message
 * $seconds = Seconds Before Redirecting
 */
function redirect_home($errMsg, $sec = 3) {
    echo "<div class='alert alert-danger'>$errMsg </div>";
    echo "<div class='alert alert-info'> You Will Be Redirect To Homepage After $sec Seconds.</div>";
    header("refresh:$sec;url=index.php");
    exit();
}

<?php
    /*
     * Get Title Function v1.0
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
 * 
 * Redirect Function v1.0
 * [ This Function Accept Parameteres ]
 * $errorMsg = ehco The Error Message
 * $seconds = Seconds Before Redirecting
 */
function redirect_home($errMsg, $sec = 3) {
    echo "<div class='alert alert-danger'>$errMsg </div>";
    echo "<div class='alert alert-info'> You Will Be Redirect To Homepage After $sec Seconds.</div>";
    header("refresh:$sec;url=index.php");
    exit();
}

/*
 * Check Items Function v1.0
 * Function to Check Item In Database [ Function Accept Parameters ]
 * $select = The Item To Select [ Example: user, item, category ]
 * $from = The Table To Select From [Example: users, categorys, items]
 * $where = The Value Of Select [ Example: osama, Electronics, Box ]
 */
function checkItem($select, $from, $value) {
    global $db;
    $statement = $db->prepare("SELECT $select FROM $from WHERE $select = :value;");
    $statement->execute(array('value' => $value));
    $count = $statement->rowCount();
    if ($count == 0) {
        return True;
    } 
    return False;
}

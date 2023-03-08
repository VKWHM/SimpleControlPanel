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
 * Redirect Function v2.0
 * [ This Function Accept Parameteres ]
 * $theMsg = Echo The Message [Error, Success, Warning]
 * $url = The Link You Want To Redirect To
 * $seconds = Seconds Before Redirecting
 */
function redirectHome($theMsg, $url = 'index.php', $sec = 2) {
    echo $theMsg;
    $link = 'Home Page';
    if (strtolower($url) == 'back' and isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
        $url = $_SERVER['HTTP_REFERER'];
        $link = 'Previous Page';
    }
    echo "<div class='alert alert-info'> You Will Be Redirect To $link After $sec Seconds.</div>";
    header("refresh:$sec;url=$url");
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

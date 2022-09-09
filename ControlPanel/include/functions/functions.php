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


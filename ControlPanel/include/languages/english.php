<?php
    function lang( $phrase ) {
        static $lang = array(
            "MESSAGE"       => "Welcome",
            "ADMIN"         => "Administrator",
            // Navbar Links
            "HOME"          => "Home",
            "CATEGORIES"    => "Categories",
            "STATISTICS"    => "Statistics",
            "ITEMS"         => "Items",
            "MEMBERS"       => "Members",
            "LOGS"          => "Logs",
            "PROFILE"       => "Edit Profile",
            "SETTINGS"      => "Settings",
            "LOGOUT"        => "Logout"
        );
        return $lang[$phrase];
    }
?>

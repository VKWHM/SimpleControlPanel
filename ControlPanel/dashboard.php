<?php
    session_start();
    if (!isset($_SESSION['Username'])) {
        header("Location: index.php");
        exit();
    }
    $pageTitle = "Dashboard";
    include "ini.php";
    

?>

    <div class="home-stats">
        <div class="container text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                    Total Members
                    <a href="members.php"><span><?php echo countItems('users', 'UserID'); ?></span></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                    Pending Members
                    <a href="members.php?do=Manage&page=Pending"><span><?php echo countItems('users', 'RegStatus', '0') ?></span></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">
                    Total Items
                    <span>1500</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                    Total Comments
                    <span>3500</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="latest">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i>
                            Latest Registered Users
                        </div>
                        <div class="panel-body">
                            Test
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i>
                            Latest Items
                        </div>
                        <div class="panel-body">
                            Test
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php  
    include $tpl . "footer.php";
?>

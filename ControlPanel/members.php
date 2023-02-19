<?php
    session_start();

    if (!isset($_SESSION["Username"])) {
        header("Location: index.php");
        exit();
    }

    /*
     ** Manage Members Page
     ** You Can Add | Edit | Delete Members From Here
    */
    include "ini.php";
    $do = isset($_GET["do"]) ? $_GET["do"] : "Manage";

    switch ($do) {

        case "Add": ?> 
                <h1 class="text-center">Add New Member</h1>
                <div class="container">

                    <form class="form-horziontal" action="?do=Insert" method="POST">
                        <!--Start Username Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Username</label>
                            <div class="col-sm-7">
                            <input class="form-control" type="text" name="username"  autocomplete="off" required='required' placeholder='Username To Login Into Shop'>
                            </div>
                        </div>
                        <!--End Username Input-->

                        <!--Start Password Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Password</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="password" name="password" autocomplete="new-password" required='required' placeholder='Password Must Be Hard & Complex'>
                                <i class="show-pass fa fa-eye "></i>
                            </div>
                        </div>
                        <!--End Pasword Input-->

                        <!--Start Email Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Email</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="email" name="email" autocomplete="off" required='required' placeholder='Email Must Be Valid'>
                            </div>
                        </div>
                        <!--End Email Input-->

                        <!--Start Full Name Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Full Name</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" name="fname" autocomplete="off" required='required' placeholder='Full Name Appear In You Profile Page'>
                            </div>
                        </div>
                        <!--End Full Name Input-->

                        <!--Start Submit Buttom-->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-7">
                                <input class="btn btn-primary btn-lg" type="submit" value="Add Member">
                            </div>
                        </div>
                        <!--End Submit Buttom-->
                    </form>
                </div>
      <?php break;
        case "Insert": ?>
            <h1 class="text-center">Insert Member</h1>
            <div class="container">

        <?php if ($_SERVER['REQUEST_METHOD'] === "POST") {
                // Get Post Item
                $username = $_POST["username"];
                $email = $_POST["email"];
                $fname = $_POST["fname"];
                $password = $_POST["password"];

                // Validate Form

                $formErrors = array();
                
                if (strlen($username) < 3) {
                    $formErrors[] = 'Username Cant Be Less Then 4 Character'; 
                }

                if (strlen($username) > 20) {
                    $formErrors[] = 'Username Cant Be More Then 20 Character'; 
                }

                if (empty($username)) {
                    $formErrors[] = 'Username Cant Be Empty'; 
                }

                if (empty($password)) {
                    $formErrors[] = 'Password Cant Be Empty';
                }

                if (strlen($password) < 3) {
                    $formErrors[] = 'Password Cant Be Less Then 4 Character'; 
                }

                foreach (['/\w/', '/\d/', '/\W/'] as $pattern) {
                    if (!preg_match($pattern, $password)) {
                        $formErrors[] = 'Passwort Must Be More Complex An Adding Digit, Character And Special Character';
                        break;
                    }
                }

                if (empty($email)) {
                    $formErrors[] = 'Email Cant Be empty';
                }
                    
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $formErrors[] = 'Invaild Email';
                }

                if (empty($fname)) {
                    $formErrors[] = 'Full Name Cant Be empty';
                }

                if ($formErrors) {
                    foreach ($formErrors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    $hashPass = password_hash($password, PASSWORD_BCRYPT);
                    $argument = array($username, $email, $fname, $hashPass);
                    // Update Data

                    $stmt = $db->prepare("INSERT INTO users (Username, Email, FullName, Password) VALUES (?, ?, ?, ?);");
                    $stmt->execute($argument);
                    echo "<div class='alert alert-success'>" .$stmt->rowCount() . " Record Inserted". "</div>";
                } ?>

            </div>

        <?php } else {
                header("Location: members.php?do=Manage");
            }
            break;
        case "Edit":
            // Check If Request has userid and is numaric & get integer value from of it
            $userid = isset($_GET["userid"]) && is_numeric($_GET['userid']) ? $_GET['userid'] : 0;
            $stmt = $db->prepare("SELECT * FROM users WHERE UserID = ?");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            if ($stmt->rowCount() > 0) { ?>
                <h1 class="text-center">Edit Member</h1>

                <div class="container">

                    <form class="form-horziontal" action="?do=Update" method="POST">
                        <!--Hidden Input For User ID-->
                        <input type="hidden" name="userid" value="<?php echo $userid ?>">

                        <!--Start Username Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Username</label>
                            <div class="col-sm-7">
                            <input class="form-control" type="text" name="username" value=<?php echo $row["Username"] ?> autocomplete="off" required='required'>
                            </div>
                        </div>
                        <!--End Username Input-->

                        <!--Start Password Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Password</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="password" name="newPassword" autocomplete="new-password" placeholder="Leave Blank If You Don't Want To Change">
                                <input class="form-control" type="hidden" name="oldPassword" value="<?php echo $row['Password'] ?>">
                            </div>
                        </div>
                        <!--End Pasword Input-->

                        <!--Start Email Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Email</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="email" name="email" value=<?php echo $row["Email"] ?> autocomplete="off" required='required'>
                            </div>
                        </div>
                        <!--End Email Input-->

                        <!--Start Full Name Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Full Name</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" name="fname" value='<?php echo $row["FullName"] ?>' autocomplete="off" required='required'>
                            </div>
                        </div>
                        <!--End Full Name Input-->

                        <!--Start Submit Buttom-->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-7">
                                <input class="btn btn-primary btn-lg" type="submit" value="Update">
                            </div>
                        </div>
                        <!--End Submit Buttom-->
                    </form>
                </div>
            <?php } else {
                    echo "Theres No Such ID";
                }
                break;
        case "Delete":
            echo "Delete Section";
            break;
        case "Update": ?>
            <h1 class="text-center">Update Member</h1>
            <div class="container">

        <?php if ($_SERVER['REQUEST_METHOD'] === "POST") {
                // Get Post Item
                $id = $_POST["userid"];
                $username = $_POST["username"];
                $email = $_POST["email"];
                $fname = $_POST["fname"];

                // Validate Form

                $formErrors = array();

                if (strlen($username) < 3) {
                    $formErrors[] = 'Username Cant Be Less Then 4 Character'; 
                }

                if (strlen($username) > 20) {
                    $formErrors[] = 'Username Cant Be More Then 20 Character'; 
                }

                if (empty($username)) {
                    $formErrors[] = 'Username Cant Be Empty'; 
                }

                if (empty($email)) {
                    $formErrors[] = 'Email Cant Be empty';
                }

                if (empty($fname)) {
                    $formErrors[] = 'Full Name Cant Be empty';
                }

                if ($formErrors) {
                    foreach ($formErrors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    // Password Trick
                    $hashPass = empty($_POST["newPassword"]) ? $_POST['oldPassword'] : password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
                    $argument = array($username, $email, $fname, $hashPass);
                    // Update Data

                    $stmt = $db->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
                    $stmt->execute($argument);
                    echo "<div class='alert alert-success'>" .$stmt->rowCount() . " Record Updated". "</div>";
                } ?>

            </div>

        <?php } else {
                header("Location: members.php?do=Manage");
            }
            break;
        case "Manage":
        default: ?> 
            <a href="members.php?do=Add">Add New Member</a>
      <?php break;
    }


    include $tpl . "footer.php";

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
    $pageTitle = 'Members';
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

                    if (!preg_match('/[a-zA-Z0-9\.]{1,}@[a-zA-Z0-9]{1,}\.[a-z]{1,}/', $email)) {
                        $formErrors[] = 'Invaild Email';
                    }

                    if (empty($fname)) {
                        $formErrors[] = 'Full Name Cant Be empty';
                    }
                    if (checkItem('Username', 'users', $username)) {
                        $formErrors[] = 'The Username Must Be Exists';
                    }

                    if ($formErrors) {
                        foreach ($formErrors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        $hashPass = password_hash($password, PASSWORD_BCRYPT);
                        $argument = array(
                            'user' => $username,
                            'email' => $email,
                            'fname' => $fname,
                            'pass' => $hashPass
                        );
                        // Update Data

                        $stmt = $db->prepare("INSERT INTO users (Username, Email, FullName, Password, DateTime, RegStatus) VALUES (:user, :email, :fname, :pass, now(), 1);");
                        $stmt->execute($argument);
                        $msg =  "<div class='alert alert-success'>" .$stmt->rowCount() . " Record Inserted". "</div>";
                        redirectHome($msg, 'back');
                    } ?>

                </div>

            <?php } else {
                    echo "<div class='container'>";
                    $msg = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Directly</div>';
                    redirectHome($msg);
                    echo "</div>";
                }
                break;
            case "Edit":
                // Check If Request has userid and is numaric & get integer value from of it
                $userid = isset($_GET["userid"]) && is_numeric($_GET['userid']) ? (int)$_GET['userid'] : 0;
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
                        $msg =  "<div class='alert alert-danger'>Theres No Such ID</div>";
                        redirectHome($msg, 'back', 3);
                    }
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
                    if (checkItem('Username', 'users', $username)) {
                        $formErrors[] = 'The Username Must Be Exists';
                    }

                    if ($formErrors) {
                        foreach ($formErrors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                    } else {
                        // Password Trick
                        $hashPass = empty($_POST["newPassword"]) ? $_POST['oldPassword'] : password_hash($_POST['newPassword'], PASSWORD_BCRYPT);
                        $argument = array($username, $email, $fname, $hashPass, $id);
                        // Update Data

                        $stmt = $db->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
                        $stmt->execute($argument);
                        $msg =  "<div class='alert alert-success'>" .$stmt->rowCount() . " Record Updated". "</div>";
                        redirectHome($msg, 'back');
                    } ?>

                </div>

            <?php } else {
                    echo "<div class='container'>";
                    $msg = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Directly</div>';
                    redirectHome($msg);
                    echo "</div>";
                }
                break;
            case "Delete": ?>
                <h1 class="text-center">Delete Member</h1>
                <div class="container">
          <?php // Check If UserID is Integer And Check If It Exist In Database
                $userid = isset($_GET["userid"]) && is_numeric($_GET['userid']) ? (int)$_GET['userid'] : 0;
                if (checkItem('UserID', 'users', $userid)) {
                    $stmt = $db->prepare('DELETE FROM users WHERE UserID = :userID');
                    $stmt->bindParam(':userID', $userid);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    $msg =  "<div class='alert alert-success'>$count Record Deleted</div>";
                    redirectHome($msg, 'back');
                } else {
                    $msg =  "<div class='alert alert-danger'>There No Such ID Found</div>";
                    redirectHome($msg, 'back');
                } ?>
                </div>
          <?php break;
            case "Activate": ?>
                <h1 class="text-center">Activate Member</h1>
                <div class="container">
          <?php // Check If UserID is Integer And Check If It Exist In Database
                $userid = isset($_GET["userid"]) && is_numeric($_GET['userid']) ? (int)$_GET['userid'] : 0;
                if (checkItem('UserID', 'users', $userid)) {
                    $stmt = $db->prepare('UPDATE users SET RegStatus = 1 WHERE UserID = :userID;');
                    $stmt->bindParam(':userID', $userid);
                    $stmt->execute();
                    $count = $stmt->rowCount();
                    $msg =  "<div class='alert alert-success'>$count Record Updated</div>";
                    redirectHome($msg, 'back');
                } else {
                    $msg =  "<div class='alert alert-danger'>There No Such ID Found</div>";
                    redirectHome($msg, 'back');
                } ?>
                </div>
          <?php break;
            case "Manage": // Manage Members Page
            default: 
                // Select All Users Expect Admins
                $query = isset($_GET['page']) && $_GET['page'] === 'Pending' ? 'AND RegStatus = 0' : '';
                $stmt = $db->prepare("SELECT * FROM users WHERE GroupID != 1 $query;");
                $stmt->execute(); ?> 

                <h1 class="text-center">Manage Members</h1>
                <div class="container">
                <div class="table-responsive">
                    <table class="main-table table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Full Name</th>
                                <th>Registred Date</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbody>

            <?php while ($row = $stmt->fetch()) { ?>
                            <tr>
                                <td><?php echo $row['UserID']; ?></td>
                                <td><?php echo $row['Username'] ?></td>
                                <td><?php echo $row['Email'] ?></td>
                                <td><?php echo $row['FullName'] ?></td>
                                <td><?php echo $row['DateTime'] ?></td>
                                <td>
                                    <a class="btn btn-success" href="members.php?do=Edit&userid=<?php echo $row['UserID'] ?>"><i class='fa fa-edit'></i> Edit</a>
                                    <a class="btn btn-danger confirm" href="members.php?do=Delete&userid=<?php echo $row['UserID'] ?>"><i class='fa fa-close'></i> Delete</a>
                                <?php if (!$row['RegStatus']) { ?>
                                    <a class="btn btn-info" href="members.php?do=Activate&userid=<?php echo $row['UserID'] ?>"><i class='fa fa-check'></i> Activate</a>
                                <?php } ?>
                                </td>
                            </tr>
            <?php } ?>
                        </tbody>
                    </table>
                </div>
                    <a class='btn btn-primary' href="members.php?do=Add"><i class="fa fa-plus"></i> Add New Member</a>
            </div>
      <?php break;
    }

    include $tpl . "footer.php";

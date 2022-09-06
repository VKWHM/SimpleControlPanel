<?php
    session_start();
    if (isset($_SESSION['Username'])) { // Redirect To DashBoard Page
        header("Location: dashboard.php");
        exit();
    }
    $noNavBar = '';
    include "ini.php";

    // Check If User Coming From Post Request
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST["user"];
        $password = $_POST["pass"];
        $hashedPass = sha1($password);

        // Check IF User Exist In Database
        $stmt = $db->prepare('SELECT Username, Password FROM users WHERE Username= ? AND Password = ? AND GroupID = 1');
        $stmt->execute(array($username, $hashedPass));
        if ($stmt->rowCount() > 0) {
            $_SESSION['Username'] = $username;
            header('Location: dashboard.php');
            exit();
        }

    }
?>
    <form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>", method="POST">
            <h4 class="text-center">Admin Login</h4>
            <input class="form-control", type="text", name="user", placeholder="Username", autocomplete="off">
            <input class="form-control", type="password", name="pass", placeholder="Password", autocomplete="new-password">
            <input class="btn btn-primary btn-block", type="submit", value="Login">
        </form>

<?php
   include $tpl . "footer.php";
?>

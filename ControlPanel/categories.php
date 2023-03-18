<?php
    session_start();

    if (!isset($_SESSION["Username"])) {
        header("Location: index.php");
        exit();
    }

    /*
     ** Categories Page
    */
    $pageTitle = 'Categories';
    include "ini.php";
    $do = isset($_GET["do"]) ? $_GET["do"] : "Manage";

    switch ($do) {
        case "Add": ?> 
                <h1 class="text-center">Add New Categories</h1>
                <div class="container">

                    <form class="form-horziontal" action="?do=Insert" method="POST">
                        <!--Start Name Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Name</label>
                            <div class="col-sm-7">
                            <input class="form-control" type="text" name="name"  autocomplete="off" required='required' placeholder='Name Of The Categories'>
                            </div>
                        </div>
                        <!--End Name Input-->

                        <!--Start Description Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Description</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" name="description" required='required' placeholder='Descripe The Category'>
                            </div>
                        </div>
                        <!--End Description Input-->

                        <!--Start Ordering Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Ordering</label>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" name="ordering" placeholder='Number To Arrange The Categories'>
                            </div>
                        </div>
                        <!--End Ordering Input-->

                        <!--Start Visibility Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Visible</label>
                            <div class="col-sm-7">
                                <div>
                                    <input id='vis-yes' type="radio" name="visibility" value="0" checked>
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id='vis-no' type="radio" name="visibility" value="1">
                                    <label for="vis-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!--End Visibility Input-->
                        <!--Start Commenting Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Allow Commenting</label>
                            <div class="col-sm-7">
                                <div>
                                    <input id='com-yes' type="radio" name="commenting" value="0" checked>
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id='com-no' type="radio" name="commenting" value="1">
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!--End Commenting Input-->
                        <!--Start Advertise Input-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 col-sm-offset-1 control-label" for="">Allow Ads</label>
                            <div class="col-sm-7">
                                <div>
                                    <input id='ads-yes' type="radio" name="ads" value="0" checked>
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id='ads-no' type="radio" name="ads" value="1">
                                    <label for="ads-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!--End Visibility Input-->

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
            <h1 class="text-center">Insert Categorie</h1>
            <div class="container">

        <?php if ($_SERVER['REQUEST_METHOD'] === "POST") {
                // Get Post Item
                $name = $_POST["name"];
                $description = $_POST["description"];
                $order = (int)$_POST["ordering"];
                $visible = $_POST["visibility"];
                $comment = $_POST["commenting"];
                $ads = $_POST["ads"];

                // Validate Form

                $formErrors = array();
                

                if (empty($name)) {
                    $formErrors[] = 'Categorie Name Cant Be Empty'; 
                }

                if (empty($description)) {
                    $formErrors[] = 'Description Cant Be empty';
                }


                if (checkItem('Name', 'categories', $name)) {
                    $formErrors[] = 'The Categorie Name Must Be Exists';
                }

                if ($formErrors) {
                    foreach ($formErrors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    $argument = array(
                        'name' => $name,
                        'desc' => $description,
                        'order' => $order,
                        'vis' => $visible,
                        'com' => $comment,
                        'ads' => $ads
                    );
                    // Update Data

                    $stmt = $db->prepare("INSERT INTO categories (Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads) VALUES (:name, :desc, :order, :vis, :com, :ads);");
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
        case "Update":
        case "Activate":
        case "Delete":
        case "Manager":
        default:
            $a = '';
    }


    include $tpl . 'footer.php';

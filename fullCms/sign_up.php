<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>


<?php
if (isset($_POST["submit"])) {
    $Username = $_POST["Username"];
    $Name = $_POST["Name"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];
    $uppercase = preg_match('@[A-Z]@', $Password);
    $lowercase = preg_match('@[a-z]@', $Password);
    $number = preg_match('@[0-9]@', $Password);
    $specialChars = preg_match('@[^\w]@', $Password);
    $admin = $_SESSION["Username"];
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime = time(); // Assign the current timestamp to $CurrentTime
    $DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);


    if (empty($Username) || empty($Password) || empty($ConfirmPassword)) {
        $_SESSION["error"] = "All fields are required";
        Redirect_to("admins.php");
    } elseif ($Password !== $ConfirmPassword) {
        $_SESSION["error"] = "Password does not Match!";
        Redirect_to("admins.php");
    } elseif (strlen($Password) < 8) {
        $_SESSION["passwordError"] = "Password should be at least 8 characters in length !";
        Redirect_to("admins.php");
    } elseif (!$uppercase) {
        $_SESSION["passwordError"] = "Password should contain uppercase !";
        Redirect_to("admins.php");
    } elseif (!$lowercase) {
        $_SESSION["passwordError"] = "Password should contain lowercase !";
        Redirect_to("admins.php");
    } elseif (!$number) {
        $_SESSION["passwordError"] = "Password should contain number(s) !";
        Redirect_to("admins.php");
    } elseif (!$specialChars) {
        $_SESSION["passwordError"] = "Password should contain special characters !";
        Redirect_to("admins.php");
    } elseif (CheckUsernameExistsOrNot($Username)) {
        $_SESSION["error"] = "Try another Username!";
        Redirect_to("admins.php");
    } else {
        // Query to insert a new Admin in the DB when everything is fine
        global $conn;
        $sql = "INSERT INTO admins (datetime, username, password, aname, addedby) ";
        $sql .= "VALUES (:dateTime, :userName, :password, :aName, :adminName)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':userName', $Username);
        $stmt->bindValue(':password', $Password);
        $stmt->bindValue(':aName', $Name);
        $stmt->bindValue(':adminName', $admin);
        $Execute = $stmt->execute();

        if ($Execute) {
            $_SESSION["success"] = "New Admin with the name of " . $Name . " added successfully.";
            Redirect_to("admins.php");
        } else {
            $_SESSION["error"] = "Something Went Wrong. Try Again !";
            Redirect_to("admins.php");
        }
    }
} // End of Submit Button if-Condition
?>

<!doctype html>
<html lang="en">

<head>
    <title>Admin Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--Font Awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


    <!--Navbar-->
    <div style="height: 2px; background: #27aae1;"></div>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="#" class="navbar-brand">ACTPRESS.COM</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link"><i class="fa-solid fa-user text-success"></i> My
                            Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="admins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php?page=1" class="nav-link">Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="logout.php" class="nav-link"><i
                                class="fa-solid fa-user-xmark text-danger"></i> Logout</a></li>
                </ul>
            </div>
        </div>
        </div>
    </nav>
    <div style="height: 2px; background: #27aae1;"></div>
    <!--Navbar End-->

    <!--Header Start-->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-user text-primary"></i> Manage Admins</h1>
                </div>
            </div>
        </div>
    </header>
    <!--Header End-->

    <!--Main Area Start-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-10 offset-lg-1" style="min-height: 400px;">
                <?php
                echo error();
                echo success();
                echo passwordError();
                ?>
                <form class="" action="admins.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="username"> <span class="fieldInfo"> Username: </span></label>
                                <input class="form-control" type="text" name="Username" id="username" value="">
                            </div>
                            <div class="form-group">
                                <label for="name"> <span class="fieldInfo"> Name: </span></label>
                                <input class="form-control" type="text" name="Name" id="name" value="">
                                <small class="text-warning text-muted">Optional</small>
                            </div>
                            <div class="form-group">
                                <label for="password"> <span class="fieldInfo"> Password: </span></label>
                                <input class="form-control" type="password" name="Password" id="password" value="">
                            </div>
                            <div class="form-group">
                                <label for="ConfirmPassword"> <span class="fieldInfo"> Confirm Password: </span></label>
                                <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword"
                                    value="">
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="dashboard.php" class="btn btn-primary btn-lg btn-block"><i
                                            class="fas fa-arrow-left"></i> Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="submit" class="btn btn-success btn-lg btn-block">
                                        <i class="fas fa-check"></i> Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>



            </div>
        </div>
    </section>
    <!--Main Area End-->

    <!--Footer Start-->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme By | Michael Ndue | <span id="year"></span> &copy; - All Rights
                        Reserved.</p>
                    <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;"
                            href="http://jazebakram.com/coupons/" target="_blank">
                            This site is used for Study purpose jazebakram.com have all rights. No one is allowed to
                            distribute copies other than <br>&trade; jazebkram.com &trade; Udemy; &trade; Skillshare ;
                            &trade; Stackskills</a></p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height: 3px; background: #27aae1;"></div>
    <!--Footer End-->



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>

</html>
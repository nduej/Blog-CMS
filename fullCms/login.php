<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>


<?php
//Restricting Login Page
if (isset($_SESSION["UserId"])) {
    Redirect_to("dashboard.php");
}

?>
<?php

if (isset($_POST["submit"])) {
    $Username = $_POST["Username"];
    $Password = $_POST["Password"];
    if (empty($Username) || empty($Password)) {
        $_SESSION["error"] = "All Fields are Required";
        Redirect_to("login.php");
    } else {
        // Code for Checking Username and Password From Database
        $found_account = Login_Attempt($Username, $Password);
        if ($found_account) {
            $_SESSION["UserId"] = $found_account["id"];
            $_SESSION["Username"] = $found_account["username"];
            $_SESSION["AdminName"] = $found_account["aname"];
            $_SESSION["success"] = "Welcome " . $_SESSION["AdminName"];
            if (isset($_SESSION["TrackingURL"])) {
                Redirect_to($_SESSION["TrackingURL"]);
            } else {
                Redirect_to("dashboard.php");
            }
        } else {
            $_SESSION["error"] = "Incorrect Username Or Password"; //Don't Specify Which
            Redirect_to("login.php");
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
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

                </div>
            </div>
        </div>
    </header>
    <!--Header End-->


    <!--Main Area Start-->

    <section class="container py-2 mb-4">

        <div class="row">

            <div class="col-sm-6 offset-sm-3" style="min-height:500px;">
                <br><br><br>
                <?php
                echo error();
                echo success();
                ?>
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h4 class="text-center">Welcome Back !</h4>
                    </div>
                    <div class="card-body bg-dark">

                        <form class="" action="login.php" method="post">
                            <div class="form-group">
                                <label for="username"><span class="fieldInfo">Username:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i
                                                class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="Username" id="username" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password"><span class="fieldInfo">Password:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i
                                                class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="Password" id="password" value="">
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-info btn-block" value="Login">
                        </form>
                    </div>
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
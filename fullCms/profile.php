<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>

<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

Confirm_Login();
?>
<?php
//Fetching the Existing Admin Data Start
$AdminId = $_SESSION["UserId"];
$conn;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $conn->query($sql);
while ($DataRows = $stmt->fetch()) {
    $ExistingName = $DataRows['aname'];
    $ExistingUsername = $DataRows['username'];
    $ExistingHeadline = $DataRows['aheadline'];
    $ExistingBio = $DataRows['abio'];
    $ExistingImage = $DataRows['aimage'];
}
//Fetching the Existing Admin Data End

if (isset($_POST["submit"])) {
    $AName = $_POST["Name"];
    $AHeadline = $_POST["Headline"];
    $ABio = $_POST["Bio"];
    $Image = $_FILES["Image"]["name"];
    $Target = "images/" . basename($_FILES["Image"]["name"]);
    $CurrentTime = time(); // Assign the current timestamp to $CurrentTime
    $DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);

    if (strlen($AHeadline) > 30) {
        $_SESSION["error"] = "Headline Should be Less than 30 Characters!";
        Redirect_to("profile.php");
    } elseif (strlen($ABio) > 500) {
        $_SESSION["error"] = "Bio Should be Less than 500 Characters!";
        Redirect_to("profile.php");
    } else {
        // Query to Update Admin Data in DB When everything is fine
        global $conn;

        $updates = []; // Initialize the array to hold update statements

        if (!empty($AName)) {
            $updates[] = "aname='$AName'";
        }
        if (!empty($AHeadline)) {
            $updates[] = "aheadline='$AHeadline'";
        }
        if (!empty($ABio)) {
            $updates[] = "abio='$ABio'";
        }

        // Construct the update query
        $updatesStr = implode(', ', $updates);
        if (!empty($_FILES["Image"]["name"])) {
            $updatesStr .= ", aimage='$Image'";
            move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
        }

        $sql = "UPDATE admins SET $updatesStr WHERE id='$AdminId'";
        $Execute = $conn->query($sql);

        if ($Execute) {
            $_SESSION["success"] = "Details Updated Successfully !";
            Redirect_to("profile.php");
        } else {
            $_SESSION["error"] = "Something Went Wrong !";
            Redirect_to("profile.php");
        }
    }
} // End of Submit Button if-Condition
?>

<!doctype html>
<html lang="en">

<head>
    <title>My Profile</title>
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
                <div class="col-md-12 mr-2">
                    <h1><i class="fas fa-user text-success"></i> @
                        <?php echo htmlentities($ExistingUsername); ?>
                    </h1>
                </div>
            </div>
        </div>
    </header>
    <!--Header End-->

    <!--Main Area Start-->
    <section class="container py-2 mb-4">
        <div class="row">
            <!--Left Area Start-->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3>
                            <?php echo htmlentities($ExistingName); ?>
                        </h3>
                    </div>
                    <div class="card-body ">
                        <div class="circular-portrait">
                            <img src="images/<?php echo htmlentities($ExistingImage); ?>" class="block img-fluid rounded-circle mb-3"
                                alt="">
                        </div>
                        <h3 class="text-center text-bold">
                            <?php echo htmlentities($ExistingHeadline); ?>
                        </h3>
                        <div class="">
                            <?php echo htmlentities($ExistingBio); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--Left Area End-->

            <!--Right Area Start-->
            <div class="col-md-9" style="min-height: 400px;">
                <?php
                echo error();
                echo success();
                ?>
                <form class="" action="profile.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-dark text-light">
                        <div class="card-header bg-secondary text-light">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control" type="text" name="Name" id="title" value=""
                                    placeholder="Your name">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="title" placeholder="Headline"
                                    name="Headline">
                                <small class="text-muted">Add a Professional Headline like, 'Engineer' at XYZ</small>
                                <span class="text-danger">Not more than 30 Characters</span>
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" id="Post" name="Bio" rows="8" cols="80"
                                    placeholder="Bio"></textarea>
                            </div>

                            <div class="form-group">
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
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
            <!--Right Area End-->
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
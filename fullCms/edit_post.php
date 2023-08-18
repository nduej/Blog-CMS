<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>


<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

Confirm_Login();
?>

<?php
$SearchQueryParameter = $_GET['id'];
if (isset($_POST["submit"])) {
    $PostTitle = $_POST["PostTitle"];
    $Category = $_POST["Category"];
    $Image = $_FILES["Image"]["name"];
    $Target = "uploads/" . basename($_FILES["Image"]["name"]);
    $PostText = $_POST["PostDescription"];
    $admin = "Michael";
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime = time(); // Assign the current timestamp to $CurrentTime
    $DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);


    if (empty($PostTitle)) {
        $_SESSION["error"] = "Title can't be empty";
        Redirect_to("posts.php");
    } elseif (strlen($PostTitle) < 5) {
        $_SESSION["error"] = "Post Title Should be Greater than 5 characters";
        Redirect_to("posts.php");
    } elseif (strlen($PostText) > 9999) {
        $_SESSION["error"] = "Post Description Should be Less than 250 characters";
        Redirect_to("posts.php");
    } else {
        // Query to Update Post in DB When everything is fine
        global $conn;
        $sql = (!empty($_FILES["Image"]["name"])) ? "UPDATE posts SET title='$PostTitle', category='$Category', image='$Image', post='$PostText'
            WHERE id='$SearchQueryParameter'" : "UPDATE posts SET title='$PostTitle', category='$Category', post='$PostText'
            WHERE id='$SearchQueryParameter'";

        $Execute = $conn->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);

        if ($Execute) {
            $_SESSION["success"] = "Post Updated Successfully.";
            Redirect_to("posts.php");
        } else {
            $_SESSION["error"] = "Something went Wrong. Try Again !";
            Redirect_to("posts.php");
        }


    }

} // End of Submit Button if-Condition
?>

<!doctype html>
<html lang="en">

<head>
    <title>Edit Post</title>
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
                    <h1><i class="fas fa-edit text-primary"></i> Edit Post</h1>
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
                //Fetching existing content according to our database
                global $conn;
                if (isset($_GET["id"])) {
                    $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
                    $stmt = $conn->query($sql);
                    while ($DataRows = $stmt->fetch()) {
                        $TitleToBeUpdated = $DataRows['title'];
                        $CategoryToBeUpdated = $DataRows['category'];
                        $ImageToBeUpdated = $DataRows['image'];
                        $PostToBeUpdated = $DataRows['post'];
                    }
                } else {
                    // Handle the case when the "id" parameter is not set
                    // For example, redirect the user or display an error message.
                    // For redirection, you can use the header() function:
                    header("Location: posts.php");
                    exit; // Make sure to exit to prevent further execution of the code.
                }

                ?>
                <form class="" action="edit_post.php?id=<?php echo $SearchQueryParameter; ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">

                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="fieldInfo"> Post Title: </span></label>
                                <input class="form-control" type="text" name="PostTitle" id="title"
                                    value="<?php echo $TitleToBeUpdated; ?>" placeholder="Type title.....">
                            </div>
                            <div class="form-group">
                                <span class="fieldInfo">Existing Category: </span>
                                <?php echo $CategoryToBeUpdated; ?> <br>
                                <label for="CategoryTitle"><span class="fieldInfo">Choose Category:</span></label>
                                <select class="form-control" id="CategoryTitle" name="Category">
                                    <?php
                                    //Fetching all the categories from category table
                                    global $conn;
                                    $sql = "SELECT id,title FROM category";
                                    $stmt = $conn->query($sql);
                                    while ($DataRows = $stmt->fetch()) {
                                        $Id = $DataRows["id"];
                                        $CategoryName = $DataRows["title"];

                                        ?>
                                        <option>
                                            <?php echo $CategoryName; ?>
                                        </option>
                                    <?php } ?>
                                </select>

                            </div>








                            <div class="form-group mb-1">
                                <span class="fieldInfo">Existing Image: </span>
                                <img class="mb-2" src="uploads/<?php echo $ImageToBeUpdated; ?>" Width="170px;"
                                    height="70px;"> <br>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Post"> <span class="fieldInfo"> Post: </span></label>
                                <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                                <?php echo $PostToBeUpdated; ?></textarea>
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
<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"]; ?>


<?php
/*Make Sure to put all the codes, plus the php tag, at the beginning of the page, 
so that these Files should execute every single code before reaching to the actual form, 
at the time when the User would add the Comment!*/
if (isset($_POST["submit"])) {
    $Name = $_POST["CommenterName"];
    $Email = $_POST["CommenterEmail"];
    $Comment = $_POST["CommentBox"];
    date_default_timezone_set("Africa/Lagos");
    $CurrentTime = time(); // Assign the current timestamp to $CurrentTime
    $DateTime = strftime("%Y-%m-%d %H:%M:%S", $CurrentTime);


    if (empty($Name) || empty($Email) || empty($Comment)) {
        $_SESSION["error"] = "All fields are required";
        Redirect_to("full_post.php?id={$SearchQueryParameter}");
    } elseif (strlen($Comment) > 500) {
        $_SESSION["error"] = "Comment length should be less than 500 characters";
        Redirect_to("full_post.php?id={$SearchQueryParameter}");
    } else {
        // Query to insert Comment in DB when everything is fine
        $conn;
        $sql = "INSERT INTO comments (datetime,name,email,comment,approvedby,status,post_id) ";
        $sql .= "VALUES (:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':name', $Name);
        $stmt->bindValue(':email', $Email);
        $stmt->bindValue(':comment', $Comment);
        $stmt->bindValue(':postIdFromURL', $SearchQueryParameter);
        $Execute = $stmt->execute();
        if ($Execute) {
            $_SESSION["success"] = "Comment Registered Successfully.";
            Redirect_to("full_post.php?id={$SearchQueryParameter}");
        } else {
            $_SESSION["error"] = "Something Went Wrong. Try Again!";
            Redirect_to("full_post.php?id={$SearchQueryParameter}");
        }
    }
} // End of Submit Button if-Condition
?>


<!doctype html>
<html lang="en">

<head>
    <title>Full Post</title>
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
                        <a href="blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form class="form-inline d-none d-sm-block" action="blog.php">
                        <div class="form-group">

                        </div>
                        <div class="form-group">
                            <input class="form-control mr-2" type="text" name="Search" value=""
                                placeholder="Search here">
                            <button class="btn btn-primary" name="SearchButton">Go</button>

                        </div>
                    </form>
                </ul>
            </div>
        </div>
        </div>
    </nav>
    <div style="height: 2px; background: #27aae1;"></div>
    <!--Navbar End-->

    <!--Header Start-->
    <div class="container">
        <div class="row mt-4">

            <!--Main Area Start-->
            <div class="col-sm-8">
                <h1>The Complete Responsive CMS Blog</h1>
                <h1 class="lead">The Complete blog by Using PHP by Michael Ndue</h1>
                <?php
                echo error();
                echo success();
                ?>

                <?php
                $conn;

                //SQL Query When Search button is active
                if (isset($_GET["SearchButton"])) {
                    $search = $_GET["Search"];
                    $sql = "SELECT * FROM posts WHERE datetime LIKE :search
                    OR title LIKE :search 
                    OR  category LIKE :search
                    OR post LIKE :search";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':search', '%' . $search . '%'); // % Representing the whole column Where SQL is lookin for Search
                    $stmt->execute();

                }
                // The Default SQL Query
                else {
                    $PostIdFromURL = $_GET["id"];
                    if (!isset($PostIdFromURL)) {
                        $_SESSION["error"] = "Bad Request !";
                        Redirect_to("blog.php");
                    }
                    $sql = "SELECT * FROM posts WHERE id='$PostIdFromURL'";
                    $stmt = $conn->query($sql);
                    $Result = $stmt->rowCount();
                    if ($Result != 1) {
                        $_SESSION["error"] = "Bad Request !";
                        Redirect_to("blog.php?page=1");
                    }
                }

                while ($DataRows = $stmt->fetch()) {
                    $PostId = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $admin = $DataRows["author"];
                    $Image = $DataRows["image"];
                    $PostDescription = $DataRows["post"];

                    ?>
                    <div class="card">
                        <img class="img-fluid card-top" style="max-height: 450px;"
                            src="uploads/<?php echo htmlentities($Image); ?>" />
                        <div class="card-body">
                            <h4 class="card-title">
                                <?php echo htmlentities($PostTitle); ?>
                            </h4>
                            <small class="text-muted">
                                Category:
                                <a href="blog.php?category=<?php echo htmlentities($Category); ?>">
                                    <span class="text-dark">
                                        <?php echo htmlentities($Category); ?>
                                    </span></a>, Written by
                                <span class="text-dark">
                                    <?php echo htmlentities($admin); ?>
                                </span> On
                                <span class="text-dark">
                                    <?php echo htmlentities($DateTime); ?>
                                </span>
                            </small>

                            <hr>
                            <p class="card-text">
                                <?php
                                //To insert actual html code in Edit section
                                echo nl2br($PostDescription); ?>
                            </p>

                        </div>
                    </div>
                <?php } ?>




                <!--Comment Section Start-->
                <!--Fetching Existing Comment Start-->
                <span class="fieldInfo">Comments</span>
                <br><br>
                <?php
                $conn;
                $sql = "SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";
                $stmt = $conn->query($sql);
                while ($DataRows = $stmt->fetch()) {
                    $CommentDate = $DataRows['datetime'];
                    $CommenterName = $DataRows['name'];
                    $CommentContent = $DataRows['comment'];

                    ?>
                    <div>

                        <div class="media CommentBlock">
                            <img class="d-block align-self-start img-fluid" src="images/profiledefault.jpg" alt="">
                            <div class="media-body ml-2">
                                <h6 class="lead">
                                    <?php echo $CommenterName; ?>
                                </h6>
                                <p class="small">
                                    <?php echo $CommentDate; ?>
                                </p>
                                <p>
                                    <?php echo $CommentContent; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <!--Fetching Existing Comment End-->
                <div class="">
                    <form class="" action="full_post.php?id=<?php echo $SearchQueryParameter; base() ?>" method="post">

                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="fieldInfo">Drop your Comments below</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" type="text" name="CommenterName" placeholder="Name"
                                            value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" type="email" name="CommenterEmail"
                                            placeholder="Email" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="CommentBox" class="form-control" rows="5" cols="80"></textarea>
                                </div>
                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
                <!--Comment Section End-->

            </div>
            <!--Main Area End-->
            <?php require_once("footer.php") ?>
        </div>
        <!--Header End-->
        <br>
<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>


<!doctype html>
<html lang="en">

<head>
    <title>Blog Page</title>
    <style>
        .heading {
            font-family: Bitter, Georgia, "Times New Roman", Times, serif;
            font-weight: bold;
            color: #005e90;
        }

        .heading:hover {
            color: #0090CB;
        }
    </style>
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
                            <li class="nav-item btn btn-success btn-sm ml-3">
                                <a href="sign_up.php" class="nav-link text-white">Sign Up</a>
                            </li>
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
                <?php
                echo error();
                echo success();
                ?>
                <h1>The Complete Responsive CMS Blog</h1>
                <h1 class="lead">The Complete blog by Using PHP by Michael Ndue</h1>
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

                } //Query When Pagination is Active i.e Blog.php?page=1
                elseif (isset($_GET["page"])) {
                    $Page = $_GET["page"];
                    $ShowPostFrom = ($Page == 0 || $Page < 1) ? 0 : ($Page * 3) - 3;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,3";
                    $stmt = $conn->query($sql);
                }
                //Query When Category is active in URL Tab
                elseif (isset($_GET["category"])) {
                    $Category = $_GET["category"];
                    $sql = "SELECT * FROM posts WHERE category=:categoryName";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':categoryName', $Category);
                    $stmt->execute();
                }

                // The Default SQL Query
                else {
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
                    $stmt = $conn->query($sql);
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
                            <small class="text-muted">Category:
                                <a href="blog.php?category=<?php echo htmlentities($Category); ?>">
                                    <span class="text-dark">
                                        <?php echo htmlentities($Category); ?>
                                    </span></a>, Written by
                                <span class="text-dark">
                                    <a href="publicProfile.php?username=<?php echo htmlentities($admin) ?>">
                                        <?php echo htmlentities($admin); ?>
                                    </a>
                                </span> On
                                <span class="text-dark">
                                    <?php echo htmlentities($DateTime); ?>
                                </span>
                            </small>
                            <span class="float-right badge badge-dark text-light">
                                Comments:
                                <?php echo ApprovedCommentsAccordingToPost($PostId); ?>
                            </span>
                            <hr>
                            <p class="card-text">
                                <?php
                                if (strlen($PostDescription) > 150) {
                                    $PostDescription = substr($PostDescription, 0, 150) . "...";
                                }
                                echo nl2br($PostDescription); ?>
                            </p>
                            <a href="full_post.php?id=<?php echo $PostId; ?>" class="float-right">
                                <span class="btn btn-info">Read More >> </span>
                            </a>
                        </div>
                    </div>
                <?php } ?>


                <!--Pagination Start-->

                <nav>

                    <ul class="pagination pagination-lg mt-2 justify-content-center">

                        <!--Creating Backward Button Start-->

                        <?php

                        if (isset($Page)) {

                            if ($Page > 0) {

                                ?>

                                <li class="page-item">
                                    <a href="blog.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo;</a>
                                </li>

                            <?php }
                        } ?>

                        <!--Creating Backward Button End-->

                        <?php

                        $conn;
                        $sql = "SELECT COUNT(*) FROM posts LIMIT 0,3";
                        $stmt = $conn->query($sql);
                        $RowPagination = $stmt->fetch();
                        $TotalPosts = array_shift($RowPagination);
                        // echo $TotalPosts . "<br>";
                        $PostPagination = $TotalPosts / 3;
                        $PostPagination = ceil($PostPagination);
                        //  echo $PostPagination;
                        for ($i = 1; $i <= $PostPagination; $i++) {

                            if (isset($Page)) {
                                if ($i == $Page) { ?>
                                    <li class="page-item active">
                                        <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>

                                    <?php

                                } else {

                                    ?>

                                    <li class="page-item">
                                        <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>



                                <?php }
                            }
                        } ?>


                        <!--Creating Forward Button Start-->

                        <?php

                        if (isset($Page) && !empty($Page)) {

                            if ($Page + 1 <= $PostPagination) {

                                ?>

                                <li class="page-item">
                                    <a href="blog.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo;</a>
                                </li>

                            <?php }
                        } ?>

                        <!--Creating Forward Button End-->
                    </ul>

                </nav>

                <!--Pagination End-->

            </div>
            <!--Main Area End-->

            <?php require_once("footer.php"); ?>


        </div>
        <!--Header End-->
        <br>

        <?php

        function base()
        {
            echo str_replace("blog.php", "", $_SERVER['PHP_SELF']);
        }

        $URL = explode("/", $_SERVER['QUERY_STRING']);

        if (file_exists($URL[0] . ".php")) {
            require_once($URL[0] . ".php");
        } else {
            require_once("404.php");
        }



        ?>
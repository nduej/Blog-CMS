<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>

<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

Confirm_Login();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Dashboard</title>
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
                    <h1><i class="fas fa-cog text-primary"></i> Dashboard</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="add_new_post.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Add New Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i> Add New category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="admins.php" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Approve Comments
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!--Header End-->

    <!---Main Area Start-->
    <section class="container py-2 mb-4">
        <div class="row">


            <!-- Left Side Area Start-->
            <div class="col-lg-2 d-none d-md-block">

                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Posts</h1>
                        <h4 class="dispay-5">
                            <i class="fas fa-readme"></i>
                            <?php
                            TotalPosts();

                            ?>
                        </h4>
                    </div>
                </div>

                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h4 class="dispay-5">
                            <i class="fas fa-folder"></i>
                            <?php
                            TotalCategories();
                            ?>
                        </h4>
                    </div>
                </div>

                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h4 class="dispay-5">
                            <i class="fas fa-users"></i>
                            <?php
                            TotalAdmins();

                            ?>
                        </h4>
                    </div>
                </div>

                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Comments</h1>
                        <h4 class="dispay-5">
                            <i class="fas fa-comment"></i>
                            <?php

                            TotalComments();
                            ?>
                        </h4>
                    </div>
                </div>

            </div>
            <!-- Left Side Area End-->

            <!-- Right Side Area Start-->

            <div class="col-lg-10">
                <?php
                echo error();
                echo success();
                ?>
                <h1>Top Posts</h1>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>

                            <th>No.</th>
                            <th>Title</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Details</th>

                        </tr>
                    </thead>
                    <?php
                    $SrNo = 0;
                    $conn;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt = $conn->query($sql);
                    while ($DataRows = $stmt->fetch()) {
                        $PostId = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $Author = $DataRows["author"];
                        $Title = $DataRows["title"];
                        $SrNo++;


                        ?>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo $SrNo; ?>
                                </td>
                                <td>
                                    <?php echo $Title; ?>
                                </td>
                                <td>
                                    <?php echo $DateTime; ?>
                                </td>
                                <td>
                                    <?php echo $Author; ?>
                                </td>
                                <td>

                                    <?php

                                    $Total = ApprovedCommentsAccordingToPost($PostId);
                                    if ($Total > 0) {
                                        ?>
                                        <span class="badge badge-success">
                                            <?php
                                            echo $Total; ?>
                                        </span>
                                        <?php
                                    }
                                    ?>

                                    <?php

                                    $Total = UnapprovedCommentsAccordingToPost($PostId);
                                    if ($Total > 0) {
                                        ?>
                                        <span class="badge badge-danger">
                                            <?php
                                            echo $Total; ?>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td><a target="_blank" href="full_post.php?id=<?php echo $PostId; ?>"><span
                                            class="btn btn-info">Preview</span></a></td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>

            </div>


            <!-- Right Side Area End-->

        </div>
    </section>
    <!---Main Area End-->
    <br>

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
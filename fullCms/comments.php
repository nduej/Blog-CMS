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
    <title>Comments</title>
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
                    <h1><i class="fas fa-text-height fa-comments text-primary"></i> Manage Comments</h1>
                </div>
            </div>
        </div>
    </header>
    <!--Header End-->

    <!--Main Area Start-->
    <section class="container py-2 mb-4">
        <div class="row" style="min-height:30px;">
            <div class="col-lg-12" style="min-height: 400px;">
                <?php
                echo error();
                echo success();
                ?>

                <h2>Approved Comments </h2>
                <table class="table table-striped table-hover">

                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>Name</th>
                            <th>Comments</th>
                            <th>Approve</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                    <?php
                    $conn;
                    $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                    $Execute = $conn->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CommentId = $DataRows["id"];
                        $DateTimeOfComment = $DataRows["datetime"];
                        $CommenterName = $DataRows["name"];
                        $CommentContent = $DataRows["comment"];
                        $CommentPostId = $DataRows["post_id"];
                        $SrNo++;
                        if (strlen($CommenterName) > 10) {
                            $CommenterName = substr($CommenterName, 0, 11) . '..';
                        }
                        if (strlen($DateTimeOfComment) > 10) {
                            $DateTimeOfComment = substr($DateTimeOfComment, 0, 11) . '..';
                        }
                        ?>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo htmlentities($SrNo); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($DateTimeOfComment); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($CommenterName); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($CommentContent); ?>
                                </td>
                                <td style="width: 140px;"> <a href="approve_comment.php?id=<?php echo $CommentId; ?>"
                                        class=" btn btn-success">Approve</a></td>
                                <td> <a href="delete_comment.php?id=<?php echo $CommentId; ?>"
                                        class=" btn btn-danger">Delete</a></td>
                                <td style="width: 140px;"> <a class="btn btn-primary"
                                        href="full_post.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live
                                        Preview</a></td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>



                <!--Disapprove Comments Section Start-->

                <h2> Disapprove Comments </h2>
                <table class="table table-striped table-hover">

                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>Name</th>
                            <th>Comments</th>
                            <th>Revert</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                    <?php
                    $conn;
                    $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                    $Execute = $conn->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CommentId = $DataRows["id"];
                        $DateTimeOfComment = $DataRows["datetime"];
                        $CommenterName = $DataRows["name"];
                        $CommentContent = $DataRows["comment"];
                        $CommentPostId = $DataRows["post_id"];
                        $SrNo++;
                        if (strlen($CommenterName) > 10) {
                            $CommenterName = substr($CommenterName, 0, 11) . '..';
                        }
                        if (strlen($DateTimeOfComment) > 10) {
                            $DateTimeOfComment = substr($DateTimeOfComment, 0, 11) . '..';
                        }
                        ?>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo htmlentities($SrNo); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($DateTimeOfComment); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($CommenterName); ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($CommentContent); ?>
                                </td>
                                <td style="width: 140px;"> <a href="disapprove_comment.php?id=<?php echo $CommentId; ?>"
                                        class=" btn btn-warning">Disapprove</a></td>
                                <td> <a href="delete_comment.php?id=<?php echo $CommentId; ?>"
                                        class=" btn btn-danger">Delete</a></td>
                                <td style="width: 140px;"> <a class="btn btn-primary"
                                        href="full_post.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live
                                        Preview</a></td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>

                <!--Disapprove Comments Section End-->

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
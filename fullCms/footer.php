<!--Side Area-->
<div class=" col-sm-4">
    <div class="card mt-4">
        <div class="card-body">
            <img src="images/start-blog.jpg" class="d-block img-fluid mb-3" alt="">
            <div class="text-center">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                labore et dolore magna aliqua.
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header bg-dark text-light">
            <h2 class="lead">Sign Up</h2>
        </div>
        <div class="card-body">
            <button name="button" class="btn btn-success btn-block text-center text-white mb-4">Join the
                Forum</button>
            <button name="button" class="btn btn-danger btn-block text-center text-white mb-4">Login</button>
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="" placeholder="Enter your Email" value="">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm text-center text-white">Subscribe Now</button>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <div class="card-header bg-primary text-light">
                <h2 class="lead">Categories</h2>
            </div>
            <div class="card-body">
                <?php
                $conn;
                $sql = "SELECT * FROM category ORDER BY id desc";
                $stmt = $conn->query($sql);
                while ($DataRows = $stmt->fetch()) {
                    $CategoryId = $DataRows["id"];
                    $CategoryName = $DataRows["title"];

                    ?>
                    <a href="blog.php?category=<?php echo $CategoryName; ?>">
                        <span class="heading">
                            <?php echo $CategoryName; ?>
                        </span></a><br>
                <?php } ?>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header bg-info text-white">
                <h2 class="lead">
                    Recent Posts
                </h2>
            </div>
            <div class="card-body">
                <?php
                $conn;
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                $stmt = $conn->query($sql);
                while ($DataRows = $stmt->fetch()) {
                    $Id = $DataRows['id'];
                    $Title = $DataRows['title'];
                    $DateTime = $DataRows['datetime'];
                    $Image = $DataRows['image'];

                    ?>
                    <div class="media">
                        <img src="uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start"
                            width="90" height="94" alt="">
                        <div class="media-body ml-2">
                            <a href="full_post.php?id=<?php echo htmlentities($Id); ?>" target="_blank">
                                <h6 class="lead">
                                    <?php echo htmlentities($Title); ?>
                                </h6>
                            </a>
                            <p class="small">
                                <?php echo htmlentities($DateTime); ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--Side Area End-->

<!--Footer Start-->
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center">Theme By | Michael Ndue | <span id="year"></span> &copy; - All
                    Rights
                    Reserved.</p>
                <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;"
                        href="http://jazebakram.com/coupons/" target="_blank">
                        This site is used for Study purpose jazebakram.com have all rights. No one is allowed to
                        distribute copies other than <br>&trade; jazebkram.com &trade; Udemy; &trade; Skillshare
                        ;
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
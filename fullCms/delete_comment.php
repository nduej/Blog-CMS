<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>


<?php

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    $conn;
    $sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
    $Execute = $conn->query($sql);
    if ($Execute) {
        $_SESSION["success"] = "Comment Deleted Successfully !";
        Redirect_to("comments.php?id={$SearchQueryParameter}");
    } else {
        $_SESSION["error"] = "Something Went Wrong. Try Again !";
        Redirect_to("comments.php");
    }
}

?>
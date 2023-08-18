<?php require_once("includes/db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>



<?php

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    $conn;
    $admin = $_SESSION["AdminName"];
    $sql = "UPDATE comments SET status='OFF', approvedby='$admin' WHERE id='$SearchQueryParameter'";
    $Execute = $conn->query($sql);
    if ($Execute) {
        $_SESSION["success"] = "Disapproved Successfully !";
        Redirect_to("comments.php?id={$SearchQueryParameter}");
    } else {
        $_SESSION["error"] = "Something Went Wrong. Try Again !";
        Redirect_to("comments.php");
    }
}

?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>


<?php

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    $conn;
    $sql = "DELETE FROM admins WHERE id='$SearchQueryParameter'";
    $Execute = $conn->query($sql);
    if ($Execute) {
        $_SESSION["success"] = "Admin Deleted Successfully !";
        Redirect_to("admins.php?id={$SearchQueryParameter}");
    } else {
        $_SESSION["error"] = "Something Went Wrong. Try Again !";
        Redirect_to("admins.php");
    }
}

?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/sessions.php"); ?>


<?php

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    $conn;
    $sql = "DELETE FROM category WHERE id='$SearchQueryParameter'";
    $Execute = $conn->query($sql);
    if ($Execute) {
        $_SESSION["success"] = "Category Deleted Successfully !";
        Redirect_to("categories.php?id={$SearchQueryParameter}");
    } else {
        $_SESSION["error"] = "Something Went Wrong. Try Again !";
        Redirect_to("categories.php");
    }
}

?>
<?php require_once("includes/db.php"); ?>

<?php

function Redirect_to($New_Location)
{
    header("Location:" . $New_Location);
    exit;
}

function CheckUsernameExistsOrNot($Username)
{
    global $conn;
    $sql = "SELECT username FROM admins WHERE username = :userName";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':userName', $Username); // Bind the parameter with the variable value
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ($Result == 1) {
        return true; // Username exists in the database
    } else {
        return false; // Username does not exist in the database
    }
}

function Login_Attempt($Username, $Password)
{
    // Code for Checking Username and Password From Database
    global $conn;
    $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':userName', $Username);
    $stmt->bindValue(':passWord', $Password);
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ($Result == 1) {
        return $found_account = $stmt->fetch();
    } else {
        return null;
    }
}

function Confirm_Login()
{
    if (isset($_SESSION["UserId"])) {
        return true;
    } else {
        $_SESSION["error"] = "Login Required !";
        Redirect_to("login.php");
    }
}

function TotalPosts()
{
    global $conn;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $conn->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
}

function TotalCategories()
{
    global $conn;
    $sql = "SELECT COUNT(*) FROM category";
    $stmt = $conn->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCategories = array_shift($TotalRows);
    echo $TotalCategories;

}

function TotalAdmins()
{
    global $conn;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $conn->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
}
function TotalComments()
{

    global $conn;
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $conn->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalComments = array_shift($TotalRows);
    echo $TotalComments;
}

function ApprovedCommentsAccordingToPost($PostId)
{
    global $conn;
    $sqlApproved = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
    $stmtApproved = $conn->query($sqlApproved);
    $RowsTotal = $stmtApproved->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}

function UnapprovedCommentsAccordingToPost($PostId)
{
    global $conn;
    $sqlUnapproved = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
    $stmtUnapproved = $conn->query($sqlUnapproved);
    $RowsTotal = $stmtUnapproved->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}
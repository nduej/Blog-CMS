<?php

session_start();

function error()
{
    if (isset($_SESSION["error"])) {
        $output = "<div class=\"alert alert-danger text-center\">";
        $output .= htmlentities($_SESSION["error"]);
        $output .= "</div>";
        $_SESSION["error"] = null;
        return $output;
    }


}

function passwordError()
{
    if (isset($_SESSION["passwordError"])) {
        $output = "<div class=\"alert alert-danger text-center\">";
        $output .= htmlentities($_SESSION["passwordError"]);
        $output .= "</div>";
        $_SESSION["passwordError"] = null;
        return $output;
    }
}

function success()
{
    if (isset($_SESSION["success"])) {
        $output = "<div class=\"alert alert-success text-center \">";
        $output .= htmlentities($_SESSION["success"]);
        $output .= "</div>";
        $_SESSION["success"] = null;
        return $output;
    }
}
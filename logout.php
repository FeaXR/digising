<?php
session_start();
$_SESSION["user_id"] = "";
session_destroy();

$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
if ($previous != "checkout.php") {
    header("Location: " . $previous);
} else {
    header("Location: index.php");
}

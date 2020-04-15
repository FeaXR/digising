<?php

namespace Phppot;

use \Phppot\Member;

$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
header("Location: " . $previous);

session_start();

if (!empty($_SESSION["userId"])) {
    require_once __DIR__ . './class/Member.php';
    $member = new Member();
    $memberResult = $member->getMemberById($_SESSION["userId"]);
    if (!empty($memberResult[0]["display_name"])) {
        $displayName = ucwords($memberResult[0]["display_name"]);
    } else {
        $displayName = $memberResult[0]["user_name"];
    }
} else {
    $displayName = "Login";
}

if ($displayName == "Login") {
    exit();
}

$itemid = $_REQUEST['id'];

$link = mysqli_connect("localhost", "root", "", "webshop");
// Check connection
if ($link === false) {
    exit();
}

mysqli_query($link, "insert into asd values (1)");


$sql = 'select * from items where id = ' . $itemid;


if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        $userid =  $_SESSION["userId"];
        $itemamount = $_POST["amount"];

        $sql = 'insert into cart values (' . $userid . ', ' . $row["id"] . ', ' . $itemamount . ')';
        mysqli_query($link, $sql);
    } else {
        exit();
    }
}
exit();

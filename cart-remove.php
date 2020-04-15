<?php

namespace Phppot;

use \Phppot\Member;

$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
header("Location: ". $previous);

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

$itemid = $_REQUEST['itemid'];

$content = file_get_contents("db.txt");
$arr = explode("\r\n", $content);
$ip = $arr[0];
$un = $arr[1];
$psw = $arr[2];
$db = $arr[3];       


$link = mysqli_connect($ip, $un, $psw, $db);
// Check connection
if ($link === false) {
    exit();
}

$sql = 'delete from cart where registered_users_id = '.$_SESSION["userId"].' and items_id = ' . $itemid;

mysqli_query($link, $sql);

exit();

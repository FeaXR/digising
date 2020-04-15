<?php

namespace Phppot;

use \Phppot\Member;

require_once "class/DataSource.php";

if (!empty($_POST["login"])) {
    session_start();
    $username = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
    $fullname = filter_var($_POST["fullname"], FILTER_SANITIZE_STRING);
    require_once(__DIR__ . "./class/Member.php");

    $content = file_get_contents("db.txt");
    $arr = explode("\r\n", $content);
    $ip = $arr[0];
    $un = $arr[1];
    $psw = $arr[2];
    $db = $arr[3];


    $link = mysqli_connect($ip, $un, $psw, $db);
    
    if ($link === false) {
        $_SESSION["errorMessage"] = "Can't connect to database!";
        header("Location: ./register.php");
        exit();
    }
    $sql = "select * FROM registered_users WHERE user_name = \"" . $username . "\"";
    // $row['vezeteknev']
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $_SESSION["errorMessage"] = "Username is already taken!";
            header("Location: ./register.php");
            exit();
        }
    }

    $sql = "select * FROM registered_users WHERE email = \"" . $email . "\"";
    // $row['vezeteknev']
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $_SESSION["errorMessage"] = "Email is already in use!";
            header("Location: ./register.php");
            exit();
        }
    }

    $passwordHash = md5($password);

    $sql = "insert into registered_users (user_name, display_name, password, email) values ( \"" . $username . "\", \"" . $fullname . "\", \"" . $passwordHash . "\",\"" . $email . "\");";

    $conn = mysqli_connect("localhost", "root", "", "webshop");

    // Check connection
    if (!$conn) {
        $_SESSION["errorMessage"] = "Can't connect to database!";
        header("Location: ./register.php");
        exit();
    }
    mysqli_query($conn, $sql);
    mysqli_commit($conn);
    mysqli_close($conn);

    $member = new Member();
    $isLoggedIn = $member->processLogin($username, $password);

    if (!$isLoggedIn) {
        $_SESSION["errorMessage"] = "Invalid Credentials";
    }
    header("Location: ./index.php");
    exit();
}

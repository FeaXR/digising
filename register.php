<?php

namespace Phppot;

use \Phppot\Member;

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

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>My Webshop</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style type="text/css">
        html,
        body,
        header,
        .carousel {
            height: 60vh;
        }

        @media (max-width: 740px) {

            html,
            body,
            header,
            .carousel {
                height: 100vh;
            }
        }

        @media (min-width: 800px) and (max-width: 850px) {

            html,
            body,
            header,
            .carousel {
                height: 100vh;
            }
        }
    </style>
</head>
<!-- Navbar -->
<?php
require_once 'fragments/registerNavbar.php';
?>
<!-- Navbar -->

<!-- Register Form -->
<div id="register">
    <div class="modal-dialog modal-login">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Register</h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                <form action="register-action.php" method="post" id="frmLogin" onSubmit="return validateRegister();">
                    <?php
                    if (isset($_SESSION["errorMessage"])) {
                    ?>
                        <div class="error-message"><?php echo $_SESSION["errorMessage"]; ?></div>
                    <?php
                        unset($_SESSION["errorMessage"]);
                    }
                    ?>
                    <div class="form-group">
                        <div>
                            <label for="username_Register">Username</label><span id="user_info_register" class="error-info"></span>
                        </div>
                        <input type="text" class="form-control error-info" name="user_name" id="user_name_register">
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="fullname_register">Full name</label><span id="fullname_info_register" class="error-info"></span>
                        </div>
                        <input type="text" class="form-control error-info" name="fullname" id="fullname_register">
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="password_register">Password</label><span id="password_info_register" class="error-info"></span>
                        </div>
                        <input type="password" class="form-control error-info" id="password_register" name="password">
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="password_again_register">Password again</label><span id="password_again_info_register" class="error-info"></span>
                        </div>
                        <input type="password" class="form-control error-info" id="password_again_register">
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="email_register">Email</label><span id="email_register_info" class="error-info"></span>
                        </div>
                        <input type="email" class="form-control error-info" name="email" id="email_register">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login" value="Login" class="btn btn-primary btn-lg btn-block login-btn">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validateRegister() {
        var $valid = true;
        document.getElementById("user_info_register").innerHTML = "";
        document.getElementById("password_info_register").innerHTML = "";

        var userName = document.getElementById("user_name_register").value;
        var fullName = document.getElementById("fullname_register").value;
        var password = document.getElementById("password_register").value;
        var passwordagain = document.getElementById("password_again_register").value;
        var email = document.getElementById("email_register").value;

        if (userName == "") {
            document.getElementById("user_info_register").innerHTML = " required";
            $valid = false;
        }
        if (fullName == "") {
            document.getElementById("fullname_info_register").innerHTML = " required";
            $valid = false;
        }
        if (password == "") {
            document.getElementById("password_info_register").innerHTML = " required";
            $valid = false;
        }
        if (password != passwordagain || passwordagain == "") {
            document.getElementById("password_again_info_register").innerHTML = " should be same";
            $valid = false;
        }
        if (email == "") {
            document.getElementById("email_register_info").innerHTML = " required";
            $valid = false;
        }
        if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("email_register").value))) {
            document.getElementById("email_register_info").innerHTML = " is invalid!";
            $valid = false;
        }

        //Store data so if some of them are invalid we can restore them
        if ($valid) {
            localStorage.setItem("username", userName);
            localStorage.setItem("fullname", fullName);
            localStorage.setItem("psw", password);
            localStorage.setItem("pswagain", passwordagain);
            localStorage.setItem("email", email);
        }

        return $valid;
    }
</script>

<script>
    //restore user data if previous registration attempt was unsuccesful
    function onLoad() {
        var userName = localStorage.getItem("username");
        var fullName = localStorage.getItem("fullname");
        var password = localStorage.getItem("psw");
        var passwordagain = localStorage.getItem("pswagain");
        var email = localStorage.getItem("email");

        if (!(userName === null)) {
            document.getElementById("user_name_register").value = userName;
        }
        if (!(fullName === null)) {

            document.getElementById("fullname_register").value = fullName;
        }
        if (!(password === null)) {

            document.getElementById("password_register").value = password;
        }
        if (!(passwordagain === null)) {

            document.getElementById("password_again_register").value = passwordagain;
        }
        if (!(email === null)) {

            document.getElementById("email_register").value = email;
        }
    }
</script>
<!-- Register Form -->

<!--Footer-->
<?php
require_once 'fragments/footer.html';
?>
<!--/.Footer-->

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- Initializations -->
<script type="text/javascript">
    // Animations initialization
    new WOW().init();
</script>
</body>

<body onload="onLoad()">

</html>
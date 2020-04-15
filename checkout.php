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

$previous = "javascript:history.go(-1)";
if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
if ($displayName == "Login") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php
            $content = file_get_contents("db.txt");
            $arr = explode("\r\n", $content);
            $ip = $arr[0];
            $un = $arr[1];
            $psw = $arr[2];
            $db = $arr[3];
            $shopname = $arr[4];
            echo $shopname . " - Checkout";

            $link = mysqli_connect($ip, $un, $psw, $db);
            // Check connection
            if ($link === false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            } ?></title>
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
</head>

<body>
    <div id="main-wrapper">
        <!-- Navbar -->
        <?php
        require_once 'fragments/mainNavbar.php';
        ?>
        <!-- Navbar -->

        <!--Main layout-->
        <main style="margin-top: 100px;;">
            <div class="container">
                <div class="container mb-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col"> </th>
                                            <th scope="col">Product</th>
                                            <th scope="col" class="text-center">Quantity</th>
                                            <th scope="col" class="text-right">Price</th>
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $sql = 'select it.name, items_id, it.price, it.photourl, sum(amount) from cart crt inner join items it on crt.items_id = it.id where crt.registered_users_id = ' . $_SESSION["userId"] . ' group by items_id;';
                                        $total = 0;
                                        if ($result = mysqli_query($link, $sql)) {
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo '
                                                <tr>
                                                <td><img src="' . $row["photourl"] . '" /> </td>
                                                <td>' . $row["name"] . '</td>
                                                <td class="text-right">' . $row["sum(amount)"] . '</td>
                                                <td class="text-right">' . $row["sum(amount)"] . 'x' . $row["price"] . ' $</td>
                                                <td class="text-right"><button onclick="deleteitem(' . $row["items_id"] . ')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button> </td>
                                            </tr>
                                                ';
                                                    $total += +$row["price"] * +$row["sum(amount)"];
                                                }
                                            }
                                        }

                                        ?>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><strong>Total</strong></td>
                                            <td class="text-right"><strong><?php echo $total . '$'; ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <script>
                                    function deleteitem(id) {

                                        $.ajax({
                                            url: 'cart-remove.php?itemid=' + id,
                                            type: 'POST'
                                        });

                                        setTimeout(() => {
                                            location.reload();
                                        }, 200);
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="row">
                                <div class="col-sm-12  col-md-6">
                                    <a href="index.php"><button class="btn btn-block btn-light">Continue Shopping</button></a>
                                </div>
                                <div class="col-sm-12 col-md-6 text-right">
                                    <button onclick="checkout()" class="btn btn-lg btn-block btn-success text-uppercase">Checkout</button>

                                    <script>
                                        function checkout() {

                                            $.ajax({
                                                url: 'cart-empty.php',
                                                type: 'POST'
                                            });

                                            setTimeout(() => {
                                                location.reload();
                                            }, 200);
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <!--Main layout-->

        <!--Footer-->
        <?php
        require_once 'fragments/footer.html';
        ?>
        <!--/.Footer-->
    </div>
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

</html>
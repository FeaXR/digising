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
    <title><?php
            $content = file_get_contents("db.txt");
            $arr = explode("\r\n", $content);
            $ip = $arr[0];
            $un = $arr[1];
            $psw = $arr[2];
            $db = $arr[3];
            $shopname = $arr[4];
            echo $shopname;

            $link = mysqli_connect($ip, $un, $psw, $db);
            // Check connection
            if ($link === false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            ?></title>
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

        <!-- Login Form -->
        <div class="loginform">
            <?php
            require_once 'fragments/loginform.html';
            ?>
        </div>
        <!-- Login Form -->

        <!--Main layout-->
        <main style="margin-top: 100px;">
            <div class="container">
                <!--Section: Products v.3-->
                <section class="text-center mb-4">

                    <?php
                    $sql = "select * from items";

                    // $row['vezeteknev']
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<div class="row">';
                            $i = -1;
                            while ($row = mysqli_fetch_array($result)) {
                                $i++;
                                if ($i == 4) {
                                    echo '
                        </div>
                        <div class="row wow fadeIn">
                        ';
                                    $i = 0;
                                }
                                echo '
                    <!--Grid column-->
                    
                    <div class="col-lg-3 col-md-6 mb-4">
          
                      <!--Card-->
                     
                      <div class="card">
          
                        <!--Card image-->
                        <div class="view overlay"> <a href="prod.php?id=' . $row["id"] . '" style="position:absolute; 
                    width:100%;
                    height:100%;
                    top:0;
                    left: 0;                  
                    z-index: 1;">
                    </a>
                          <img src="' . $row["photourl"] . '" " class="card-img-top"
                            alt="">
                          <a>
                            <div class="mask rgba-white-slight"></div>
                          </a>
                        </div>
                        <!--Card image-->
          
                        <!--Card content-->
                        <div class="card-body text-center">
                          <!--Category & Title-->
                          <h5 class="dark-grey-text">
                            <strong>
                              ' . $row["name"] . '
                            </strong>
                          </h5>
          
                          <h4 class="font-weight-bold blue-text">
                            <strong>' . $row["price"] . '$</strong>
                          </h4>
          
                        </div>
                        <!--Card content-->
          
                      </div>
                      <!--Card-->
          
                    </div>
                    <!--Grid column-->';
                            }
                            echo "</div>";
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo "Sorry, no items match your search";
                        }
                    } else {
                        echo "ERROR: Could not  execute $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>

                </section>
                <!--Section: Products v.3-->
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

    <script>
        //if user is after registration, clear stored credentials
        localStorage.clear();
    </script>
    <script>
        $(document).ready(function() {
            <?php
            if (isset($_SESSION["errorMessage"])) {
                if ($_SESSION["errorMessage"] == "Invalid Credentials") {
                    echo 'setTimeout(() => {
                        alert("Invalid credentials!");
                    }, 100);';
                    unset($_SESSION["errorMessage"]);
                }
            }
            ?>
        });
    </script>
</body>

</html>
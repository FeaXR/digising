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

          $itemid = $_REQUEST['id'];

          $content = file_get_contents("db.txt");
          $arr = explode("\r\n", $content);
          $ip = $arr[0];
          $un = $arr[1];
          $psw = $arr[2];
          $db = $arr[3];
          $shopname = $arr[4];
          $photourl;
          $name;
          $desc;
          $price;

          $link = mysqli_connect($ip, $un, $psw, $db);
          // Check connection
          if ($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
          }

          $sql = 'select * from items where id = ' . $itemid;

          if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result);
              $photourl = $row["photourl"];
              $name = $row["name"];
              $desc = $row["description"];
              $price = $row["price"];
            }
          }
          echo $shopname . " - " . $name;
          ?></title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.min.css" rel="stylesheet">
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

    <main class="mt-5 pt-4">
      <div class="container dark-grey-text mt-5">

        <!--Grid row-->
        <div class="row wow fadeIn">

          <!--Grid column-->
          <div class="col-md-6 mb-4">

            <img src=<?php
                      echo $photourl;
                      ?> class="img-fluid" alt="">
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-md-6 mb-4">

            <!--Content-->
            <div class="p-4">

              <p class="lead">
                <span>$<?php
                        echo $price;
                        ?> </span>
              </p>

              <p class="lead font-weight-bold"><?php echo $name; ?></p>

              <p><?php echo $desc; ?> </p>

              <div>
                <label for="amount"><span id="amount_info" class="error-info"></span></label>
              </div>

              <form action=<?php
                            $str = "\"cart.php?id=" . $row["id"] . "\"";

                            echo $str;

                            ?> method="post" onSubmit="return validate();" class="d-flex justify-content-left">

                <!-- Default input -->
                <input type="number" value="1" id="amount" name="amount" aria-label="Search" class="form-control" style="width: 100px">
                <button class="btn btn-primary btn-md my-0 p" <?php
                                                              if ($displayName == "Login") {
                                                                echo "disabled";
                                                              }
                                                              ?> type="submit">Add to cart
                  <i class="fas fa-shopping-cart ml-1"></i>
                </button>

              </form>

              <script>
                function validate() {
                  document.getElementById("amount_info").innerHTML = "";

                  var amount = document.getElementById("amount").value;
                  if (amount == "") {
                    document.getElementById("amount_info").innerHTML = "Can't be blank!";
                    return false;
                  }
                  if (isNaN(amount)) {
                    document.getElementById("amount_info").innerHTML = "Can be only a number!";
                    return false;

                  } else {
                    if (amount < 0) {
                      document.getElementById("amount_info").innerHTML = "Can't be negative!";
                      return false;
                    }
                  }
                  sendForm();
                  return false;
                }

                function sendForm() {

                  $.ajax({
                    url: <?php
                          $str = "'cart.php?id=" . $row["id"] . "'";

                          echo $str;

                          ?>,
                    type: 'POST',
                    data: {
                      amount: document.getElementById("amount").value
                    }
                  });

                  return;
                }
              </script>

            </div>
            <!--Content-->
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
        <hr>
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
    $(document).ready(function() {
      <?php
      if (isset($_SESSION["errorMessage"])) {
        if ($_SESSION["errorMessage"] == "Invalid Credentials") {
          echo '
          setTimeout(() => {
            alert("Invalid credentials!");
        }, 100);

          ';
          unset($_SESSION["errorMessage"]);
        }
      }
      ?>
    });
  </script>
</body>

</html>
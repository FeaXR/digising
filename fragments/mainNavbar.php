<nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">

    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand waves-effect" href="index.php">
            <strong class="blue-text">My Webshop</strong>
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="index.php">Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="search.php?sql1=Men">Men</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link waves-effect" href="search.php?sql1=Women">Women</a>
                </li>
            </ul>
            <!-- Right -->
            <ul class="navbar-nav nav-flex-icons ">

                <?php
                if ($displayName != "Login") {

                    echo ' <li class="nav-item greeting">
                        <a class="nav-link waves-effect">
                                    <span  class="logout-button">Hello, ' . $displayName . '</span>
                                    </a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link waves-effect" href="checkout.php">
                                        <!-- <i class="fas fa-shopping-cart"></i> -->
                                        Cart
                                      </a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link waves-effect" href="logout.php">
                                   Logout
                                    </a>
                                    </li>
                                    ';
                } else {
                    echo '
                                <li class="nav-item">
                                    <a class="nav-link waves-effect"  href="#myModal" data-toggle="modal">
                                     Login
                                </a>
                    </li>';
                }
                ?>

            </ul>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-dark mdb-color lighten-3 mt-3 mb-5">

    <!-- Navbar brand -->
    <span class="navbar-brand">Categories:</span>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="basicExampleNav">

        <!-- Links -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href=" <?php
                                            echo "search.php?sql1=" . $_REQUEST['sql1'];
                                            ?> ">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php
                                            echo "search.php?sql1=" . $_REQUEST['sql1'] . "&sql2=Shirts";
                                            ?>">Shirts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=" <?php
                                            echo "search.php?sql1=" . $_REQUEST['sql1'] . "&sql2=Trousers";
                                            ?> ">Trousers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=" <?php
                                            echo "search.php?sql1=" . $_REQUEST['sql1'] . "&sql2=Sportswear";
                                            ?> ">Sportswear</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=" <?php
                                            echo "search.php?sql1=" . $_REQUEST['sql1'] . "&sql2=Jeans";
                                            ?> ">Jeans</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=" <?php
                                            echo "search.php?sql1=" . $_REQUEST['sql1'] . "&sql2=Formal";
                                            ?> ">Formal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=" <?php
                                            echo "search.php?sql1=" . $_REQUEST['sql1'] . "&sql2=Underclothes";
                                            ?> ">Underclothes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=" <?php
                                            echo "search.php?sql1=" . $_REQUEST['sql1'] . "&sql2=Accessories";
                                            ?> ">Accessories</a>
            </li>

        </ul>
        <!-- Links -->
    </div>
    <!-- Collapsible content -->
</nav>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Accounting</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="registration.php">Registration</a>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                            <?php

                            if (isset($_SESSION['username'])){

                                echo $_SESSION['username'];

                            }


                            ?>



                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="login.php"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<form action="" method="post">
    <div class="form-group">


        <label for="cat-title">Edit Category</label>
        <?php
        global $connection;


        if(isset($_GET['edit'])){
            $cat_id= $_GET['edit'];

            $query = "SELECT * FROM categories WHERE cat_id= $cat_id ";
            $select_categories_id = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                ?>
                <input type="text" value="<?php if(isset($cat_title)){echo $cat_title; } ?>" class="form-control" name="cat_title">
            <?php } }

        ?>
        <?php
        if (isset($_POST['update_category'])) {
            $the_cat_title = $_POST['cat_title'];
            $query = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$cat_id}";
            $update_query = mysqli_query($connection, $query);
            if (!$update_query){
                die("query failed" . mysqli_error($connection));
            }

        }
        ?>



    </div>
    <div class="form-group">



        <input class="btn btn-primary" type="submit" name="update_category" value="Update">
    </div>
</form>

<?php include "includes/footer.php" ?>
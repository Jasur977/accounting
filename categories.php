<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>
<div id="wrapper">



    <div id="page-wrapper">




        <div class="container-fluid">
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

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small> <?php

                            if (isset($_SESSION['username'])){

                                echo $_SESSION['username'];

                            }


                            ?></small>
                    </h1>
                    <div class="col-xs-6">
                        <?php
                        global $connection;
                        if (isset($_POST['submit'])) {
                            $cat_title = $_POST['cat_title'];
                            if ($cat_title == "" || empty($cat_title)) {
                                echo "This field should not be empty";
                            } else {

                                $query = "INSERT INTO categories(cat_title)";
                                $query .= "VALUE('{$cat_title}')";

                                $create_category_query = mysqli_query($connection, $query);
                                if (!$create_category_query) {
                                    die('Query Failed' . mysqli_error($connection));
                                }
                            }

                        }
                        ?>



                        <form action="" method="post">
                            <div class="form-group">


                                <label for="cat-title">Add Category</label>
                                <input class="form-control" type="text" name="cat_title">
                            </div>
                            <div class="form-group">



                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                        </form>

                        <?php
                        if(isset($_GET['edit'])){
                            $cat_id = $_GET['edit'];
                            include "edit_categories.php";
                        }
                        ?>
                    </div>




                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Title</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <?php //Find All Categories

                                    $query = "SELECT * FROM categories ";
                                    $select_categories = mysqli_query($connection, $query);

                                    while ($row = mysqli_fetch_assoc($select_categories)) {
                                        $cat_id =$row['cat_id'];
                                        $cat_title = $row['cat_title'];
                                        echo "<tr>";
                                        echo "<td>{$cat_id}</td>";
                                        echo "<td>{$cat_title}</td>";
                                        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
                                        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
                                        echo "<tr>";
                                    }

                                ?>


                            </tr>


                            <?php  //DELETE query

                                global $connection;
                                if (isset($_GET['delete'])){
                                    $the_cat_id= $_GET['delete'];
                                    $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
                                    $delete_query= mysqli_query($connection, $query);
                                    header("Location: categories.php");
                                }



                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/footer.php" ?>


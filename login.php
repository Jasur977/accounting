<?php
include "includes/db.php";
include "includes/header.php";

?>



<?php
global $connection;

if (isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    if (!$select_user_query){
        die("query failed" . mysqli_error($connection));
    }

    while ( $row = mysqli_fetch_array($select_user_query)) {
        $db_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];


    }
    $password = crypt($password, $db_user_password);

    if($username !== $db_username && $password !== $db_user_password){
        header ("Location: login.php ");
        echo "Sorry wrong password or username";
    }

    else if ($username == $db_username && $password == $db_user_password){

        $_SESSION['username']= $db_username;
        $_SESSION['user_id']= $db_id;

        header ("Location: index.php");
    }




}


?>
<!-- Login-->
<div class="container">
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
                <a class="navbar-brand" href="#">Accounting</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    <li>

                    </li>

                </ul>
                <ul class="nav navbar-right top-nav">
                    <li>
                        <a href="registration.php">Registration</a>
                    </li>
                </ul>

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="col-xs-6 col-xs-offset-3">
<div class="well">
    <h4>Login</h4>
    <form action="login.php" method="post">
        <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="Enter Username">

        </div>
        <div class="input-group">
            <input name="password" type="password" class="form-control" placeholder="Enter Password">
            <span class="input-group-btn">
                    <button class="btn btn-primary" name="login" type="submit">Submit</button>


                </span>
        </div>
    </form>
    <!-- /.input-group -->

</div>
    </div>

    <?php
    include "includes/footer.php";
    ?>
</div>

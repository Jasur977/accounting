<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>


<?php
global $connection;

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)){


        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        $query = "SELECT randSalt FROM users order by user_id desc limit 1";
        $select_randsalt_query = mysqli_query($connection, $query);
        if (!$select_randsalt_query) {
            die ("Query failed" . mysqli_error($connection));
        }
        $row = mysqli_fetch_array($select_randsalt_query);

        $salt = $row ['randSalt'];



        $password = crypt($password, $salt);

        $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
        $query .= "VALUES ('{$username}', '{$email}', '{$password}', 'subscriber' ) " ;
        $register_user_query = mysqli_query($connection, $query);
        if (!$register_user_query){
            echo die("Query Failed ". mysqli_error($connection) . '' .
                mysqli_errno($connection));
        }


        $message  = "Your Registration has been submitted";
    } else{
        $message = "Fields cannot be empty";
    }





} else{
    $message = "";
}



?>



<!-- Page Content -->
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



                </ul>

                <ul class="nav navbar-right top-nav">
                     <li>
                        <a href="login.php">Login</a>
                </li>
                </ul>

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <h6 class="text-center"><?php  echo $message; ?> </h6>
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">

                        </form>


                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php";?>




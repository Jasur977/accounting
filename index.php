<?php

include "includes/db.php";
include "includes/header.php";

$session = session_id();
$time =time();
$time_out_in_seconds= 60;
$time_out = $time - $time_out_in_seconds;
?>





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

<!-- Page Content -->
<div class="container">

    <div class="row">



        <?php




    global $connection;

      $user_id = $_SESSION ["user_id"];

        $query = "SELECT overall_sum FROM account WHERE user_id = '{$user_id}'  ORDER BY ID DESC LIMIT 1 ";
        $select_account = mysqli_query($connection, $query);
        $singlerow = mysqli_fetch_row($select_account) ;



    if (isset($_POST['submit'])) {
       $select1= $_POST['type'];

        $acc_type = $_POST['type'];
        $acc_category = $_POST['category'];
        $acc_date = date('d-m-y');
        $acc_sum = $_POST['sum'];
        $acc_comment = $_POST['comment'];
        $acc_id = $_POST['type'];

       switch ($select1){
           case '1':
            $overall_sum = $singlerow['0'] + $acc_sum;
            $query = "INSERT INTO account(user_id , type , category , date, sum, overall_sum, comment  ) ";

            $query .=
                "VALUES ('$user_id', '{$acc_type}', '{$acc_category}', now(), '{$acc_sum}', '{$overall_sum}', 
                 '{$acc_comment}' ) ";
            $create_acc_query = mysqli_query($connection, $query);
            if (!$create_acc_query) {
                die("Query Failed gg ." . mysqli_error($connection));
            }
            $the_acc_id = mysqli_insert_id($connection);

            echo "<p class='bg-success'>History Created. </p>";
            break;


           case '0':

               $overall_sum = $singlerow['0']-$acc_sum;
               if ($overall_sum<=0){

                   echo ("no money");
                   header ("Location: index.php");
               }
               $query = "INSERT INTO account(user_id , type , category , date, sum, overall_sum, comment  ) ";

               $query .=
                   "VALUES ('{$user_id}', '{$acc_type}', '{$acc_category}', now(), '{$acc_sum}', '{$overall_sum}', 
                 '{$acc_comment}' ) ";
               $create_acc_query = mysqli_query($connection, $query);
               if (!$create_acc_query) {
                   die("Query Failed gg ." . mysqli_error($connection));
               }


               $the_acc_id = mysqli_insert_id($connection);

               echo "<p class='bg-success'>History Created. </p>";
            break;
        }
    }





?>



        <h1 class="page-header">
            Welcome
            <small> <?php

                if (isset($_SESSION['username'])){

                    echo $_SESSION['username'];

                }


                ?></small>
        </h1>


        <form action="" method="post" enctype ="multipart/form-data">


            <div class="form-group">

                <select name="type" id="type" required>

                    <option value="1" name="income">Доход</option>
                    <option value="0">Расход</option>

                </select>
            </div>

            <div class="form-group">
                <select name="category" id="" required>
                <option value="">КАТЕГОРИЯ</option>
                <option value="Заработная плата">Заработная плата</option>
                <option value="Иные доходы">Иные доходы</option>
                <option value="Мобильная связь">Мобильная связь</option>
                <option value="Интернет">Интернет</option>
                <option value="Продукты питания">Продукты питания</option>
                <option value="Транспорт">Транспорт</option>
                <option value="Развлечения">Развлечения</option>
                <option value="Другое">Другое</option>
                </select>
            </div>





            <div class="form-group">
                <label for="sum">СУММА</label>
                <input type="text" class="form-control" name="sum" required>

            </div>



            <div class="form-group">
                <label for="comment" >КОММЕНТАРИЙ</label>
                <textarea type="text" class="form-control" name="comment" id="summernote" cols="30" rows="10">
        </textarea>
            </div>

            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="submit" value="create">
            </div>



        </form>






        <form action="" method="post">

            <table class="table table-bordered table-hover">


                <thead>
                <tr>
                    <th>ID</th>
                    <th>ТИП</th>
                    <th>КАТЕГОРИЯ</th>
                    <th>ДАТА</th>
                    <th>СУММА</th>
                    <th>ИТОГО</th>
                    <th>КОММЕНТАРИЙ</th>


                </tr>
                </thead>
                <tbody>
                <?php

                $query = "SELECT * FROM account WHERE user_id = '{$user_id}'";
                $select_account = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_account)) {
                    $acc_id = $row['id'];
                    $acc_type = $row['type'];
                    $acc_category = $row['category'];
                    $acc_date = date('d-m-y');
                    $acc_sum = $row['sum'];
                    $acc_overall = $row['overall_sum'];
                    $acc_comment = $row['comment'];


                    echo "<tr>";
                    $nombre_format_francais = number_format($acc_sum, 2, ',', ' ');
                    $nombre_format_francaiss = number_format($acc_overall, 2, ',', ' ');
                    echo "<td> $acc_id </td> ";
                    if($acc_type==1) {
                        echo "<td> Доход </td> ";
                    }else{
                        echo "<td> Расход </td> ";
                    }
                    echo "<td> $acc_category </td> ";
                    echo "<td> $acc_date  </td>";
                    echo "<td>  $nombre_format_francais</td>";
                    echo "<td> $nombre_format_francaiss </td>";
                    echo "<td> $acc_comment </td>";
                    echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to Delete');\" href='index.php?delete={$acc_id}'>Delete</a></td>";

                }





    ?>







                </tbody>
            </table>
        </form>






        <?php
        global $connection;
        if (isset($_GET['delete'])){
            $acc_id= $_GET['delete'];
            $query = "DELETE FROM account WHERE id = {$acc_id}";
            $delete_query = mysqli_query($connection, $query);

        }
        ?>














    </div>
    <!-- /.row -->

    <hr>


<?php
include "includes/footer.php";
?>
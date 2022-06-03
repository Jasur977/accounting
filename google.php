
<?php
include "includes/db.php";
include "includes/header.php";
?>


<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <table class="table table-bordered table-hover">


            <thead>
            <tr>
                <th>ID</th>
                <th>TYPE</th>
                <th>CATEGORY</th>
                <th>DATE</th>
                <th>SUM</th>
                <th>OVERALL</th>
                <th>COMMENT</th>


            </tr>
            </thead>
            <tbody>


            <?php
            global $connection;
            $user_id = $_SESSION ["user_id"];

            $sql= "SELECT * FROM  account join categories on (account.category_id = categories.cat_id) WHERE account.user_id = '{$user_id}' ";

            if(isset($_POST['but_search'])){
                $fromDate = $_POST['fromDate'];
                $endDate = $_POST['endDate'];

                if(!empty($fromDate) && !empty($endDate)){
                    $sql .= " AND date BETWEEN '".$fromDate."' AND '".$endDate."' ";
                }
            }

            $sql .= " ORDER BY date DESC ";

            $result = mysqli_query($connection,$sql);





            if(mysqli_num_rows($result) > 0){
            //            $select_account= "SELECT * FROM account WHERE date BETWEEN STR_TO_DATE('$post_at','%d-%m-%Y') AND STR_TO_DATE('$post_at_to_date','%d-%m-%Y')";
            while ($row = mysqli_fetch_assoc($result)) {
                $acc_id = $row['id'];
                $acc_type = $row['type'];
                $acc_category = $row['cat_title'];
                $acc_date = date('Y-m-d', strtotime($row['date']));
                $acc_sum = $row['sum'];
                $acc_overall = $row['overall_sum'];
                $acc_comment = $row['comment'];


                echo "<tr>";
                $nombre_format_francais = number_format($acc_sum, 2, ',', ' ');
                $nombre_format_francaiss = number_format($acc_overall, 2, ',', ' ');
                echo "<td> $acc_id </td> ";
                if ($acc_type == 1) {
                    echo "<td> Income </td> ";
                } else {
                    echo "<td> Expense </td> ";
                }
                echo "<td> $acc_category</td> ";
                echo "<td> $acc_date  </td>";
                echo "<td>  $nombre_format_francais</td>";
                echo "<td> $nombre_format_francaiss </td>";
                echo "<td> $acc_comment </td>";
                echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to Delete');\" href='index.php?delete={$acc_id}'>Delete</a></td>";
            }
            }
            ?>

            </tbody>
        </table>
        </form>

        <a href="index.php">Go back to homepage</a>



        <?php


        ?>










        <!-- Blog Sidebar Widgets Column -->



    </div>
    <!-- /.row -->

    <hr>


    <?php
    include "includes/footer.php"; ?>

<?php

session_start();

include "config.php";
include "session.php";
// include "addentry.php";


$user_data = check_login($con);
$uid = $user_data['uid'];

$errInfo = "";


$book_id = $_GET['book_id'];
$_SESSION['book_id'] = $book_id;


$query = "SELECT * FROM `books` where `book_id` = $book_id";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$bname = $row['bname'];


$calcuate_array = calculate_total($con, $book_id);
$calCashIn = $calcuate_array[2];
$calCashOut = $calcuate_array[1];
$calTotal = $calcuate_array[0];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <link rel="stylesheet" href="./book.css"> -->
    <link rel="stylesheet" href="./assets/dashboard.css">
    <title>Dashboard</title>
</head>

<body>

    <div>
        <h1><?php echo $bname; ?></h1>
        <button><a href="delbook.php?book_id=<?php echo $book_id; ?>">Delete</a></button>

        <button><a href="dashbook.php">Back</a></button>
        <button><a href="logout.php">Logout</a></button>
    </div>

    <label class="error"><?php echo $errInfo; ?></label>
    <form action="" method="post">

        <div class="button-container">
            <button><a href="addentry.php?cash=in">Cash In</a></button>
            <button><a href="addentry.php?cash=out">Cash Out</a></button>
        </div>
        <div class="balance-info">
            <div name="totalCashIn">Cash In<div><?php echo $calCashIn; ?></div>
            </div>

            <div name="totalCashOut">Cash Out<div><?php echo $calCashOut; ?></div>
            </div>

            <div name="totalBalance">Net Balance<div> <?php echo $calTotal; ?></div>
            </div>
        </div>



        <div class="dash-container">
            <?php
            $query = "SELECT * FROM `transaction` where `book_id` = $book_id";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {

                echo '<div class="thead">
                       
                    <div>Date</div>
                    <div>Details</div>
                    <div>Category</div>
                    <div>Mode</div>
                    <div>Amount</div>
                    <div>Type</div>
                </div> ';
            } else {
                echo '
                <div>
                    Oops, No transaction yet!
                </div>';
            }

            ?>

            <div class="tbody">

                <?php
                $query = "SELECT * FROM `transaction` WHERE `book_id` = $book_id ORDER BY `transaction`.`date` DESC";

                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {
                        $tid = $row['tid'];
                        $date = $row['date'];
                        $remarks = $row['remarks'];
                        $amount = $row['amount'];
                        $category = $row['category'];
                        $mode = $row['mode'];
                        $type = $row['type'];

                        echo ' 
                        <main>
                        <div class="transaction ' . $tid . '">
                            <div class="trans-container">
                                <div class="date">' . $date . '</div>
                                <div class="remarks">' . $remarks . '</div>
                                <div class="category">' . $category . '</div>
                                <div class="mode">' . $mode . '</div>
                                <div class="amount">' . $amount . '</div>
                                <div class="type">' . $type . '</div>
                                <div class="update-delete">
                                    <button><a href="editentry.php?update_id=' . $tid . '">Edit</a></button>
                                    <button><a href="delentry.php?delete_id=' . $tid . '"> Delete </a></button>
                                </div>
                            </div>                     
                        <div>
                        </main>';
                    }
                } else {
                    $errInfo = "Oops, No transaction yet!";
                }
                ?>
            </div>

        </div>

    </form>

</body>

<script></script>


</html>
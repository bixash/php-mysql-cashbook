<?php

session_start();

include "config.php";
include "session.php";


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
    <link rel="stylesheet" href="./book.css">
    <style>
        table {
            border-collapse: collapse;
            border: 2px solid #CCCCCC;
        }

        tr,
        td,
        th {
            border: 1px solid #CCCCCC;
            padding: 0.2em;
        }
    </style>
    <title>Dashboard</title>
</head>

<body>
    
    <div>
        <h1><?php echo $bname; ?></h1><button><a href="delbook.php?book_id=<?php echo $book_id; ?>">Delete</a></button>
        <button><a href="dashbook.php">Back</a></button>
        <button><a href="logout.php">Logout</a></button>
    </div>
    
    <label class="error"><?php echo $errInfo; ?></label>
    <form action="" method="post">
        
        <div>
            <label name="totalCashIn">Cash In: <?php echo $calCashIn; ?></label>
            <br>
            <label name="totalCashOut">Cash Out: <?php echo $calCashOut; ?></label>
            <br>
            <label name="totalBalance">Net Balance: <?php echo $calTotal; ?></label>
        </div>
        <div>
            <button><a href="addentry.php?cash=in">Cash In</a></button>
            <button><a href="addentry.php?cash=out">Cash Out</a></button>
        </div>


        <table>
            <?php
            if (mysqli_num_rows($result) > 0) {

                echo '<thead>
                    <tr>
                        <!-- <th>Id</th> -->
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Remarks</th>
                        <th>Category</th>
                        <th>Mode</th>
                        <th>Type</th>
                    
                    </tr>
                </thead> ';
            } else {
                echo '<div>Oops, No transaction yet!</div>';
            }

            ?>

            <tbody>
            
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

                        echo ' <tr>
                            <td>' . $date . '</td>
                            <td>' . $amount . '</td>
                            <td>' . $remarks . '</td>
                            <td>' . $category . '</td>
                            <td>' . $mode . '</td>
                            <td>' . $type . '</td>
                            <td><button><a href="editentry.php?update_id=' . $tid . '">Edit</a></button></td>
                            <td><button><a href="delentry.php?delete_id=' . $tid . '"> Delete </a></button></td>
                                                                  
                        <tr>';
                    }
                   
                } else {
                    $errInfo = "Oops, No transaction yet!";
                }
                ?>
            </tbody>

        </table>
        
    </form>

</body>

</html>
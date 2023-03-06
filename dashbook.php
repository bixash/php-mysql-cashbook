<?php

session_start();

include "config.php";
include "session.php";

$user_data = check_login($con);

$uid = $user_data['uid'];
$name = $user_data['name'];

$errInfo = "";

$query = "SELECT * FROM `books` where `uid` = $uid";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $calCashOut= $calCashIn =  $calTotal= 0;
    while ($row = mysqli_fetch_assoc($result)) {

        $calAmount = $row['amount'];
        $calType = $row['type'];

        if($calType =="out")
            $calCashOut= $calCashOut + $calAmount;
       
        if($calType =="in")
            $calCashIn= $calCashIn + $calAmount;
    }
    $calTotal = $calCashIn - $calCashOut;
} else {
    $calCashOut= $calCashIn =  $calTotal= 0;
}


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
        <h1><?php echo $name; ?>'s Transaction</h1>
        <button><a href="logout.php">Logout</a></button>
    </div>
    
    <label class="error"><?php echo $errInfo; ?></label>
    <form action="" method="post">

        <button><a href="addbook.php">Add new book</a></button>

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
                $query = "SELECT * FROM `transaction` WHERE `uid` = $uid ORDER BY `transaction`.`date` DESC";
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
                            <td><button><a href="editbook.php?update_id=' . $tid . '">Edit</a></button></td>
                            
                            <td><button><a href="delbook.php?delete_id=' . $tid . '"> Delete </a></button></td>
                                                                  
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
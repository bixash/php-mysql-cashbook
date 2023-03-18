<?php

include "config.php";
session_start();

include "config.php";
include "session.php";

$user_data = check_login($con);
$bid = $_SESSION['book_id'];

$tid = $_GET['delete_id'];

$query = "SELECT * FROM `transaction` where tid = $tid";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$date = $row['date'];
$remarks = $row['remarks'];
$amount = $row['amount'];
$category = $row['category'];
$mode = $row['mode'];
$type = $row['type'];

if (isset($_GET['delete_id'])) {

    if (isset($_POST['yes'])) {

        $query = "delete from transaction where tid ='$tid'";
        $result = mysqli_query($con, $query);

        if ($result) {

            header("Location: dashboard.php");
        } else {
            die("Connection Failed");
        }
    }

    if (isset($_POST['no'])) {

        header("Location: dashboard.php?book_id=$bid");
    }
}

?>

<html data-theme="light">

<head>
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
</head>

<body>
    <form method="post">

        <h3>Once deleted, this transaction cannot be restored.
            <br>Are you sure you want to Delete ?
        </h3>
        <label><b>Review details:</b></label><br>
        <label>Date: <?php echo $date ?> </label> <br>
        <label>Amount: <?php echo $amount ?></label> <br>
        <label>Remarks: <?php echo $remarks ?></label> <br>
        <label>Type: Cash <?php echo $type ?></label> <br>
        <div>
            <button type="submit" name="no">Cancel </button>
            <button type="submit" name="yes">Yes, Delete </button>
        </div>

    </form>
</body>

</html>
<?php

session_start();

include "config.php";
include "session.php";

$user_data = check_login($con);

$uid = $_SESSION['id'];

$bid = $_SESSION['book_id'];

$type = $_GET['cash'];

$errDate = $errMode = $errAmount = $errInfo = "";

$error = 0;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $remarks = $_POST['remarks'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $mode = $_POST['mode'];


    if (empty($date)) {
        $errDate = "required!";
        $error++;
    }


    if (empty($mode)) {
        $errMode = "required!";
        $error++;
    }

    if (empty($amount)) {
        $errAmount = "required!";
        $error++;
    }


    if ($error == 0) {

        $query = "insert into transaction (book_id, remarks, amount, category, date, mode, type) 
        values ('$bid','$remarks','$amount', '$category','$date','$mode','$type')";

        mysqli_query($con, $query);

        header("Location: dashboard.php?book_id=$bid");
        die("Book successfully added!");
    } else
        $errInfo = "Please enter valid info!!";
}

?>
<html lang="en">

<head>
    <link rel="stylesheet" href="book.css">

</head>

<body>

    <h1>Add Cash <?php echo $type ?> Entry</h1>

    <label class="error"><?php echo $errInfo; ?></label>

    <form action="" method="post">

        <label>Date: </label>
        <input type="date" name="date">
        <span class="error">* <?php echo $errDate; ?></span>
        <br><br>

        <label>Amount: </label>
        <input type="number" name="amount">
        <span class="error">* <?php echo $errAmount; ?></span>
        <br><br>

        <label>Remarks: </label>
        <input type="text" name="remarks">
        <br><br>


        <label>Category:</label>
        <select name="category">
            <option value="None" selected hidden>Select any</option> //disabled
            <option value="Personal">Personal</option>
            <option value="Salary">Salary</option>
            <option value="Food">Food</option>
            <option value="Rent">Rent</option>
            <option value="Bonus">Bonus</option>
            <option value="Health">Health</option>
            <option value="Commute">Commute</option>
            
        </select>
        <br><br>

        <label>Mode</label>
        <select name="mode">
            <option value="Cash">Cash </option>
            <option value="Online">Online</option>
        </select>
        <span class="error">* <?php echo $errMode; ?></span>
        <br><br>

        <button type="submit">Save</button>
        <button><a href="dashboard.php?book_id=<?php echo $bid; ?>">Cancel</a></button>
        <br><br>

    </form>

</body>

</html>
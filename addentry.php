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
<html lang="en" data-theme="light">

<head>
    <link rel="stylesheet" href="book.css">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">

</head>

<body>
    <main class="container">
        <h1>Add Cash <?php echo $type ?> Entry</h1>

        <label class="error"><?php echo $errInfo; ?></label>

        <form action="" method="post">

            <label>Date: <span class="error">* <?php echo $errDate; ?></span></label>
            <input type="date" name="date">



            <label>Amount: <span class="error">* <?php echo $errAmount; ?></span></label>
            <input type="number" name="amount">



            <label>Remarks: </label>
            <input type="text" name="remarks">

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


            <label>Mode <span class="error">* <?php echo $errMode; ?></span></label>
            <select name="mode">
                <option value="Cash">Cash </option>
                <option value="Online">Online</option>
            </select>



            <button type="submit">Save</button>
            <button class="contrast"><a href="dashboard.php?book_id=<?php echo $bid; ?>">Cancel</a></button>


        </form>
    </main>
</body>

</html>
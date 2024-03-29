<?php

session_start();

include "config.php";
include "session.php";

$user_data = check_login($con);

$otherMode = $otherType = "";
$errDate = $errAmount = $errMode = $errType = $errCategory = $errInfo = "";

$tid = $_GET['update_id'];
$bid = $_SESSION['book_id'];


$query = "SELECT * FROM `transaction` where tid = $tid";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$tid = $row['tid'];
$date = $row['date'];
$remarks = $row['remarks'];
$amount = $row['amount'];
$category = $row['category'];
$mode = $row['mode'];
$type = $row['type'];

if ($type == "in")
    $otherType = "out";
else
    $otherType = "in";

if ($mode == "Cash") {
    $otherMode = "Online";
} else {
    $otherMode = "Cash";
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $type = $_POST['type'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $remarks = $_POST['remarks'];
    $category = $_POST['category'];
    $mode = $_POST['mode'];


    $query = "UPDATE `transaction` SET amount='$amount', remarks = '$remarks', category= '$category', date='$date', type='$type', mode='$mode' WHERE tid = $tid";

    $result = mysqli_query($con, $query);

    if ($result) {
        header("Location: dashboard.php?book_id=$bid");
    } else
        $errInfo = "Error occurred!!";

    // $errInfo = "Please enter valid info!!";

}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <title>Editbook</title>
</head>

<body>
    <main class="container">
        <h1>Edit Entry</h1>
        <label class="error"><?php echo $errInfo; ?></label>
        <form action="" method="post">
            <div>
                <input type="radio" name="type" value="<?php echo $type ?>" checked><?php echo 'Cash ' . $type ?>
                <input type="radio" name="type" value="<?php echo $otherType ?>"><?php echo 'Cash ' . $otherType ?>
                <span class="error"><?php echo $errType; ?></span>
            </div>

            <label>Date: <span class="error">* <?php echo $errDate; ?></span></label>
            <input type="date" name="date" value="<?php echo $date ?>" required>

            <label>Amount <span class="error">* <?php echo $errAmount; ?></span> </label>
            <input type="number" name="amount" value="<?php echo $amount ?>">

            <label>Remarks</label>
            <input type="text" name="remarks" value="<?php echo $remarks ?>" required>



            <label>Category</label>
            <select name="category">
                <option value="<?php echo $category ?>"><?php echo $category ?></option>
                <?php
                $query = "SELECT DISTINCT category FROM `transaction`";
                $result = mysqli_query($con, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($optionData = mysqli_fetch_assoc($result)) {
                        $option = $optionData['category'];
                        if ($category != $option && $option != "")
                            echo '<option value="' . $option . '"> ' . $option . ' </option>';
                    }
                }
                ?>

            </select>




            <label>Payment Mode <span class="error">* <?php echo $errMode; ?></span></label>
            <select name="mode">
                <option value="<?php echo $mode ?>"><?php echo $mode ?></option>
                <option value="<?php echo $otherMode ?>"><?php echo $otherMode ?></option>

            </select>




            <button type="submit" name="update">Save</button>
            <button class="contrast"><a href="dashboard.php?book_id=<?php echo $bid; ?>">Cancel</a></button>


        </form>
    </main>
</body>

</html>
<?php

session_start();

include "config.php";
include "session.php";

$user_data = check_login($con);

$uid = $user_data['uid'];
$name = $user_data['name'];

$errInfo = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $bname = $_POST['bname'];

    $query = "INSERT into `books`(uid, bname) VALUES ('$uid', '$bname')";

    try {

        mysqli_query($con, $query);
    } catch (Exception) {

        $errInfo == "error occurred, book can't be added";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Addbook</title>
</head>

<body>
    <form method="post">

        <label><?php echo $errInfo; ?></label>

        <label for="">Book Name</label>
        <input type="text" name="bname" required />

        <button type="submit" name="addbook">Save</button>

    </form>

</body>

</html>
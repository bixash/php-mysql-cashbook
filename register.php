<?php

include "config.php";

$errInfo = $errEmail = $errName = $errPassword = "";
$error = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $phone = $_POST['phone'];

    if (empty($name)) {
        $errName = "Name is required!";
        $error++;
    }
    if (empty($email)) {
        $errEmail = "Email is required!";
        $error++;
    }
    // if (empty($phone)) {
    //     $errPhone = "Phone is required!";
    //     // $error++;
    // }
    if (empty($password)) {
        $errPassword = "Password is required!";
        $error++;
    }

    if ($error == 0) {

        $query = "SELECT * FROM `users` WHERE email = '$email'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {

            $errInfo = "Sorry, this email is already in use!";
        } else {
            $query = "insert into users(name, email, password) values ('$name','$email', '$password')";
            $result = mysqli_query($con, $query);

            header("Location: login.php?msg=1");
        }
    } else
        $errInfo = "Please enter valid info!!";
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Register</title>
</head>

<body>

    <h1>Register</h1>


    <label class="error"><?php echo $errInfo; ?></label>
    <form action="" method="post">


        <label>Name: </label>
        <input type="text" name="name">
        <span class="error">* <?php echo $errName; ?></span>
        <br><br>

        <label>Email:</label>
        <input type="email" name="email">
        <span class="error">* <?php echo $errEmail; ?></span>
        <br><br>

        <label>Password:</label>
        <input type="password" name="password">
        <span class="error">* <?php echo $errPassword; ?></span>
        <br><br>

        <button type="submit" name="register">Register</button>
    </form>

</body>

</html>
<?php

include "config.php";

session_start();

// $msg = $_GET['msg'];


$error = 0;
$errInfo = $errEmail = $errPassword = "";

// if($msg == "1"){
//     $errInfo = "The account created successfully!! Please login for further process.";
// }


if (isset($_POST['signup'])) {
    header("Location: register.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $errEmail = "Email required!";
        $error++;
    }

    if (empty($password)) {
        $errPassword = "Password required!";
        $error++;
    }

    if ($error == 0) {

        $query = "SELECT * from users where email = '$email' AND password = '$password'";

        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['password'] === $password) {
                $_SESSION['id'] = $user_data['uid'];
                header("Location: dashbook.php");
                die;
            }
        } else {
            $errInfo = "Invalid email or password!";
        }
    }
}
?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Login</title>

</head>

<body>
    <h1>CashBook<br><br>Track Income & Expenses</h1>

    <p>
        CashBook is a digital record-keeping app using which you can add entries, segregate records and find overall balance instantly.
    </p>

    <ul>
        <li>Real-time Calculations</li>
        <li> Group Cashbooks</li>
        <li> Multiple Books</li>
        <li>PDF and Excel Reports</li>
    </ul>

    <h2>Log In & Register</h2>


    <label class="error"><?php echo $errInfo; ?></label>

    <form action="" method="post">


        <label>Email:</label>
        <input type="email" name="email">
        <span class="error"><?php echo $errEmail; ?></span>
        <br><br>

        <label>Password:</label>
        <input type="password" name="password">
        <span class="error"><?php echo $errPassword; ?></span>
        <br><br>

        <small>By clicking Verify, you are indicating that you accept our Terms of Service and Privacy Policy. <br>An SMS may be sent. Message & data rates may apply.</small>
        
        <div>
            <button type="submit" name="login">Login</button>
            <button type="submit" name="signup">Sign up</button>
        </div>
        <br><br>


    </form>

</body>

</html>
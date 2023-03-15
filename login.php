<?php

include "config.php";

session_start();

// $msg = "";

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



<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/style.css">
    <meta name="description" content="A minimalist layout for Login pages. Built with Pico CSS.">

    <!-- Pico.css -->
    <!-- <link rel="stylesheet" href="css/pico.min.css"> -->
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">

    <!-- Custom styles for this example -->
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="assets/style.css">
    <title>Login</title>

</head>

<body>
    <!-- <hgroup>
            <h1>CashBook</h1>
            <h2>Track Income & Expenses</h2>
          </hgroup>
         -->



    <main class="container">
        <article class="grid">
            <div>
                <hgroup>
                    <h1>Sign in</h1>
                    <h2>A minimalist layout for Login pages</h2>
                </hgroup>
                <form action="" method="post">
                    <label class="error"><?php echo $errInfo; ?></label>
                    <label>Username or email <span class="error"><?php echo $errEmail; ?></span></label>
                    <input type="text" name="email" placeholder="Email" aria-label="Login" autocomplete="nickname" required>
                    <span class="error"><?php echo $errPassword; ?></span>
                    <input type="password" name="password" placeholder="Password" aria-label="Password" autocomplete="current-password" required>
                    <fieldset>
                        <label for="remember">
                            <input type="checkbox" role="switch" id="remember" name="remember">
                            Remember me
                        </label>
                    </fieldset>

                    <button type="submit" name="login" class="contrast">Login</button>

                </form>
                <div class="container">
                    <small>Don't have an account?</small>
                    &nbsp;  &nbsp;
                    <a href="register.php" role="button" class="outline">Create new account</a>
                </div>
            </div>

            <div></div>
        </article>
    </main><!-- ./ Main -->



</body>

<script>
    function gotosignup() {
        location.href = "register.php";
    }
</script>

</html>
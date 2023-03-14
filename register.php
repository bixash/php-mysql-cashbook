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

<!doctype html>
<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/style.css">
    <meta name="description" content="A minimalist layout for Login pages. Built with Pico CSS.">

    <!-- Pico.css -->
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">

    <!-- Custom styles for this example -->
    <link rel="stylesheet" href="custom.css">
</head>

<body>

    <!-- Nav -->

    <!-- ./ Nav -->

    <!-- Main -->
    <main class="container">
        <article class="grid">
            <div>
                <hgroup>
                    <h1>Sign Up</h1>
                    <h2>A minimalist layout for Login pages</h2>
                </hgroup>
                <label class="error"><?php echo $errInfo; ?></label>
                <form action="" method="post">

                    <!-- <input type="text" name="name" placeholder="Name" aria-label="Name" autocomplete="nickname" required> <span class="error">* <?php echo $errName; ?></span>
                    <input type="text" name="email" placeholder="Email" aria-label="Email" autocomplete="nickname" required> <span class="error">* <?php echo $errEmail; ?></span>
                    <input type="password" name="password" placeholder="Password" aria-label="Password" autocomplete="current-password" required> -->
                    <!-- Grid -->


                    <!-- Markup example 1: input is inside label -->
                    <label for="name">
                        Name <span class="error"><?php echo $errName; ?></span>
                        <input type="text" id="name" name="name" placeholder="Full name" required>
                    </label>


                    <!-- Markup example 2: input is after label -->
                    <label for="email">Email <span class="error"><?php echo $errEmail; ?></span></label>
                    <input type="email" id="email" name="email" placeholder="johndoe@example.com" required>

                    <label for="Password">Password <span class="error"><?php echo $errPassword; ?></span></label>
                    <input type="password" name="password" placeholder="Password" required>
                    <fieldset>
                        <label for="terms">
                            <input type="checkbox" id="terms" name="terms" required>
                            I agree to the Terms and Conditions
                        </label>

                    </fieldset>


                    <!-- Button -->

                    <button type="submit" name="register" class="contrast">Sign up</button>


                    <!-- <button type="submit" class="contrast" onclick="event.preventDefault()">Login</button> -->
                </form>

                <!-- Button -->
                <div class="contianer">
                    <small> Have an account?</small>
                    &nbsp; &nbsp;
                    <a href="login.php" role="button" class="outline">Login</a>
                </div>
            </div>
            <div></div>
        </article>
    </main><!-- ./ Main -->

    <!-- Footer -->

    <!-- ./ Footer -->

    <!-- Minimal theme switcher -->

    <script>
        function gotologin() {
            location.href = "login.php";
        }
    </script>

</body>

</html>
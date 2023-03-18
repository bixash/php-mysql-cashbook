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
        header("Location: dashbook.php");
    } catch (Exception) {

        $errInfo == "error occurred, book can't be added";
    }
}


?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <link rel="stylesheet" href="./assets/book.css">
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <title>Dashboard</title>

</head>

<body>
    <main class="container">

        <div class="dash-head">
            <h1><?php echo $name; ?>'s books</h1>
            <button class="logout"><a href="logout.php">Logout</a></button>
        </div>

        <label class="error"><?php echo $errInfo; ?></label>


        <!-- <button id="btnAddbook"><a href="addbook.php">Add new book</a></button> -->
        <div class="addbutton">
            <button class="contrast" id="btnAddBook">Add new book</button>
        </div>

        <div id="overlay">
            <div class="modal">
                <div>
                    <h3>Add New Book</h3>
                    <button class="button" id="closeBtn">&times;</button>
                </div>

                <form method="post">

                    <label><?php echo $errInfo; ?></label>
                    <label for="">Book Name</label>
                    <input type="text" name="bname" required />
                    <button type="submit" name="addbook">Save</button>
                </form>
                <!-- <div id="overlay"></div> -->
            </div>
        </div>


        <div>
            <?php
            $query = "SELECT * FROM `books` where `uid` = $uid";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $book_id = $row['book_id'];
                    $bname = $row['bname'];

                    $calcuate_array = calculate_total($con, $book_id);
                    $calTotal = $calcuate_array[0];



                    echo '
                <div class="btnBooks" onclick="gotodash('  . $book_id . ')">
                   
                    <a href="dashboard.php?book_id='  . $book_id . '">' . $bname . ' </a>
                    <label name="totalBalance">' . $calTotal . '</label>
                    
                </div>
                ';
                }
            } else {
                echo '<div>Oops, No books yet!</div>';
            }
            ?>
        </div>


    </main>
</body>

<script>
    btnAddBook = document.getElementById('btnAddBook');
    overlay = document.getElementById('overlay');
    btnBooks = document.getElementsByClassName('btnBooks');
    closeBtn = document.getElementById('closeBtn');

    function gotodash(book_id) {

        location.href = "dashboard.php?book_id=" + book_id + "";
    }

    btnAddBook.addEventListener('click', function() {
        overlay.classList.add('active');
    });

    closeBtn.addEventListener('click', function() {

        overlay.classList.remove('active');
    });
</script>

</html>
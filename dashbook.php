<?php

session_start();

include "config.php";
include "session.php";

$user_data = check_login($con);

$uid = $user_data['uid'];
$name = $user_data['name'];

$errInfo = "";



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./book.css">
    <title>Dashboard</title>

</head>

<body>

    <div>
        <h1><?php echo $name; ?>'s books</h1>
        <button><a href="logout.php">Logout</a></button>
    </div>

    <label class="error"><?php echo $errInfo; ?></label>
    <form action="" method="post">

        <button><a href="addbook.php">Add new book</a></button>



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
                <div class="btnBooks">
                    <button>
                        <a href="dashboard.php?book_id='  . $book_id . '">' . $bname . ' </a>
                        <label name="totalBalance">' . $calTotal . '</label>
                    </button>
                    
                </div>
                ';
                }
            } else {
                echo '<div>Oops, No books yet!</div>';
            }
            ?>
        </div>

    </form>

</body>

<script>
    btnBooks = document.getElementsByClassName('btnBooks');
</script>

</html>
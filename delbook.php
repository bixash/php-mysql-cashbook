<?php

include "config.php";
session_start();

include "config.php";
include "session.php";

$user_data = check_login($con);


$errInfo="";

$book_id = $_GET['book_id'];
$query = "SELECT * FROM `books` where `book_id` = $book_id";
$result = mysqli_query($con, $query);

$row = mysqli_fetch_assoc($result);
$bname = $row['bname'];


if($_SERVER['REQUEST_METHOD']=="POST") {

    $delbname = $_POST["delbname"];
    // echo $delbname;
    // echo strcmp($delbname, $bname);
    if($delbname === $bname) {

        $query = "DELETE from `books` where book_id = $book_id";
        $result = mysqli_query($con, $query);
    
        header("Location: dashbook.php");
        
    } else {
        $errInfo="Book name doesn't match.";
    }
    
   
}   


?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post">
       
       <div>
           <h3>Are you sure? You will lose all entries of this book permanently.</h3>

            <div>
                <label for="">Please type <b><?php echo $bname;?> </b>to confirm</label>
                <input type="text" name="delbname">
                <span><?php echo $errInfo;?></span>
            </div>
           
            <button><a href="dashboard.php?book_id=<?php echo $book_id; ?>">Cancel</a></button>
           <button type="submit" name="yes">Yes, Delete </button>
       </div>
   </form>
    
</body>
</html>
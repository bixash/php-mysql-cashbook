<?php

function check_login($con) {

if(isset($_SESSION['id'])){
    $uid = $_SESSION['id'];
    $query = "select * from users where uid ='$uid' limit 1";

    $result = mysqli_query($con, $query);
    if($result && mysqli_num_rows($result) > 0){

        $user_data = mysqli_fetch_assoc($result);
        return $user_data;
    }

}

header("Location: login.php");
die;
}



function calculate_total($con, $book_id) {
    $query = "SELECT * FROM `transaction` where `book_id` = $book_id";
    $result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {

    $calCashOut= $calCashIn =  $calTotal= 0;

    while ($row = mysqli_fetch_assoc($result)) {

        $calAmount = $row['amount'];
        $calType = $row['type'];

        if($calType =="out")
        {   
            $calCashOut= $calCashOut + $calAmount;
        }
        
        if($calType =="in")
        {   
            $calCashIn= $calCashIn + $calAmount;
        }
    }
    $calTotal = $calCashIn - $calCashOut;
    
} else {
    $calCashOut= $calCashIn =  $calTotal= 0;
}
return array($calTotal,$calCashOut,$calCashIn);
}

?>
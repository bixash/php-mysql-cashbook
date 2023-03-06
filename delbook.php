<?php

include "config.php";
session_start();

include "config.php";
include "session.php";

$user_data = check_login($con);

if (isset($_GET['delete_id'])) {

    if (isset($_POST['yesDelete'])) {
        $tid = $_GET['delete_id'];

        $query = "delete from transaction where tid ='$tid'";
        $result = mysqli_query($con, $query);

        if ($result) {

            header("Location: dashboard.php");
        } else {
            die("Connection Failed");
        }
    }

    if (isset($_POST['noDelete'])) {

        header("Location: dashboard.php");
    }
}

?>

<html>

<body>
    <form method="post">
       
        <div>
            <h3>Once deleted, this transaction cannot be restored.
                <br>Are you sure you want to Delete ?
            </h3>
            <button type="submit" name="noDelete">Cancel </button>
            <button type="submit" name="yesDelete">Yes, Delete </button>
        </div>
    </form>
</body>

</html>
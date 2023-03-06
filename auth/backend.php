<?php
include "config.php";

$errInfo = $errEmail = $errName = $errGender = $errFaculty = $errPassword = $errPhone = "";
$error = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $faculty = $_POST['faculty'];

    if (empty($name)) {
        $errName = "Name is required!";
        $error++;
    }
    if (empty($email)) {
        $errEmail = "Email is required!";
        $error++;
    }
    if (empty($phone)) {
        $errPhone = "Phone is required!";
        // $error++;
    }
    if (empty($password)) {
        $errPassword = "Password is required!";
        $error++;
    }
    if (empty($faculty)) {
        $errFaculty = "Faculty is required!";
        $error++;
    }
    if ($gender != 'male' && $gender != 'female') {
        $errGender = "Gender is required!";
        $error++;
    }

    if ($error == 0) {

        $query = "insert into registrations(name, email, password,gender,faculty,phone) values ('$name','$email', '$password', '$gender','$faculty','$phone')";
        mysqli_query($con, $query);
        $errInfo = "Succesfully Registered!!";

        // header("Location: login.php");
        die("Succesfully Registered!!");
    } else
        $errInfo = "Please enter valid info!!";
}
?>


//// internet category
<?php
//selected option
if (!empty($category) && $category == $option) {
    // selected option
?>
    <option value="<?php echo $option; ?>" selected><?php echo $option; ?> </option>
<?php
    //continue;
} ?>


<?php
include("database.php");
include("insert-script.php");
?>
<form action="" method="post">
<input type="text" name="fullName" value="">
<select name="courseName">
    <option value="">Select Course</option>
    <?php 
    $query ="SELECT courseName FROM courses";
    $result = $conn->query($query);
    if($result->num_rows> 0){
        while($optionData=$result->fetch_assoc()){
        $option =$optionData['courseName'];
    ?>


    <?php
    //selected option
    if(!empty($courseName) && $courseName== $option){
    // selected option
    ?>


    <option value="<?php echo $option; ?>" selected><?php echo $option; ?> </option>

    
    <?php 
continue;
   }?>


    <option value="<?php echo $option; ?>" ><?php echo $option; ?> </option>
   <?php

    }}
    ?>
</select>
<br>

<input type="submit" name="submit">
</form>
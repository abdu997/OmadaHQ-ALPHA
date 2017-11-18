<?php
include("connect.php");
session_start();
$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"));
if (count($data) > 0) {
    $first_name = mysqli_real_escape_string($connect, $data->first_name);
    $last_name = mysqli_real_escape_string($connect, $data->last_name);
    $email = mysqli_real_escape_string($connect, $data->email);

    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if(preg_match("/^[a-zA-Z ]{2,}$/",$first_name) && preg_match("/^[a-zA-Z ]{2,}$/",$last_name)){
            $query = "UPDATE users SET email = '$email', first_name = '$first_name', last_name = '$last_name' WHERE user_id = '$user_id'";
            if (mysqli_query($connect, $query)) {
                echo 'success';
            } else {
                //This error would occur because email column in MySQL is Unique
                echo 'error';
            }
        } else {
            echo"Names cannot have numbers or symbols";
        }
    } else {
        echo"hell nah";
    }
}
?>

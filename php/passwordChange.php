<?php
include "connect.php";
include "session.php";
$data = json_decode(file_get_contents("php://input"));
$new_pass = mysqli_real_escape_string($connect, $data->new_password);
if(count($data) > 0){
    if(preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/", $new_pass)){
        $passHash = password_hash($data->new_password, PASSWORD_DEFAULT);
        $new_password = mysqli_real_escape_string($connect, $passHash);
        $query = "UPDATE users SET password = '$new_password' WHERE user_id='$user_id'";
        if(mysqli_query($connect, $query)) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "New password must follow pattern";
    }
}

?>

<?php
include "connect.php";
//include "session.php";
$data = json_decode(file_get_contents("php://input"));
$passHash = password_hash($data->password, PASSWORD_DEFAULT);
if(count($data) > 0){
    if(preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/", $passHash)){
        $mypassword = mysqli_real_escape_string($connect, $passHash);
        $sql = "UPDATE users SET password = '$mypassword' WHERE user_id = '$data->user_id'";
        $sql2 = "UPDATE password_reset SET status = 'used' WHERE user_id = '$data->user_id'";
        if(mysqli_query($connect, $sql)){
            echo "success";
            $sql3 = "UPDATE password_reset SET status = 'used' WHERE user_id = '$data->user_id' AND status = 'active'";
            mysqli_query($connect, $sql3);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connect);
        }
    } else {
        echo "password must follow pattern";
    }
}
?>

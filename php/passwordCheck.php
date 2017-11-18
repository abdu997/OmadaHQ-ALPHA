<?php
include "connect.php";
include "session.php";
$data = json_decode(file_get_contents("php://input"));
$old_password = mysqli_real_escape_string($connect, $data->old_password);
if(count($data) > 0){
    $query = "SELECT password FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($connect, $query);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $password = $row['password'];
    $bool = password_verify($old_password, $password);
    if ($bool == true){
        echo "success";
    } else {
        echo "error";
    }
}
?>

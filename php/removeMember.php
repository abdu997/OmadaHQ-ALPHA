<?php
include'connect.php';
$data = json_decode(file_get_contents("php://input"));
session_start();
$team_id = $_SESSION['team_id'];
$admin_status = $_SESSION['admin_status'];
$user_id = $_SESSION['user_id'];
if($admin_status == 'Y'){
    if(count($data)>0){
        if($data -> team_connect_id == null){
            $email = mysqli_real_escape_string($connect, $data->email);
            $sql = "DELETE FROM team_nonuser WHERE email = '$email' AND team_id = '$team_id'";
            if(mysqli_query($connect, $sql)){
                echo"success1";
            } else {
                echo"error1";
            }
        } else {
            $team_connect_id = $data -> team_connect_id;
            $sql2 = "DELETE FROM team_user WHERE team_connect_id= '$team_connect_id'";
            if (mysqli_query($connect, $sql2)){
                echo "success";
            } else {
                echo "error";
            }
        }
    }
} else {
    echo"You are not an admin";
}

?>

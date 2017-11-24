<?php
error_reporting(E_ERROR);
include'connect.php';
$data = json_decode(file_get_contents("php://input"));
session_start();
$user_id = $_SESSION['user_id'];
if(count($data) > 0){
    $team_name = mysqli_real_escape_string($connect, $data->team_name);

    if(strlen($team_name) == 0){
        echo"Team name cannot be empty";
    } else  if(strlen($team_name) > 20){
        echo"Team Name cannot be more than 20 characters";
    } else {
        $sql = "INSERT INTO team(team_name, type, plan) VALUES('$team_name', 'team', 'free')";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($result);
        if(mysqli_query($connect, $sql)){
            $team_id = mysqli_insert_id($connect);
            $sql2 = "INSERT INTO team_user(team_id, user_id, admin) VALUES('$team_id', '$user_id', 'Y')";
            if(mysqli_query($connect, $sql2)){
                echo"Team Created";
                $_SESSION['team_id'] = $team_id;
                $_SESSION['team_type'] = 'team';
                $_SESSION['admin_status'] = 'Y';
                $_SESSION['plan'] = $row['plan'];
            }
        } else {
            echo"SQL error";
        }
    }
}
?>

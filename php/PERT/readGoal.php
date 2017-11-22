<?php 
include "../connect.php";
session_start();
$output = array();
$team_id = $_SESSION['team_id'];
$sql = "SELECT record_id, type, team_id, user_id, name, description, start_message, start_time, end_time FROM pert_table WHERE team_id = '$team_id' AND status = 'valid' AND type = 'goal'";
$result = mysqli_query($connect, $sql);
if(mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_array($result)){
        $user_id = $row["user_id"];
        $sql2 = "SELECT first_name, last_name FROM users WHERE user_id = '$user_id'";
        $result2 = mysqli_query($connect, $sql2);
        $row2 = mysqli_fetch_array($result2);
        $row["user"] = $row2[0].' '.$row2[1]; 
        $output[] = $row;
    }
    echo json_encode($output);
}
?>
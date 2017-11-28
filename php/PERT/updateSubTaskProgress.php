<?php
include "../connect.php";
session_start();
$team_id = $_SESSION["team_id"];
$goal_id = $_SESSION["goal_id"];
$data = json_decode(file_get_contents("php://input"));
$record_id = mysqli_real_escape_string($connect, $data->record_id);
if(count($data) > 0){
    //check if the record is under this goal
    $sql = "SELECT progress FROM pert_table WHERE team_id = '$team_id' AND goal_id = '$goal_id' AND record_id = '$record_id'";
    $result = mysqli_query($connect, $sql);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    $current_progress = $row["progress"];
    if($current_progress == "complete"){
        $progress = "incomplete";
    } else if($current_progress == "incomplete" || $current_progress == ""){
        $progress = "complete";
    }
    if($count = 1){
        $sql2 = "UPDATE pert_table SET progress = '$progress' WHERE record_id = '$record_id'";
        if(mysqli_query($connect, $sql2)){
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "record error";
    }
}
?>
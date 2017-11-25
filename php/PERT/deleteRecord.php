<?php
include "../connect.php";
session_start();
$data = json_decode(file_get_contents("php://input"));
$record_id = mysqli_real_escape_string($connect, $data->record_id);
$type = mysqli_real_escape_string($connect, $data->type);
$team_id = $_SESSION['team_id'];
if(count($data) > 0){
    if($type == "goal"){
        $goal_id = $record_id;
        $sql = "UPDATE pert_table SET status = 'deleted' WHERE record_id = '$goal_id' AND team_id = '$team_id'";
        $sql2 = "UPDATE pert_table SET status = 'deleted' WHERE goal_id = '$goal_id' AND team_id = '$team_id'";
        if(mysqli_query($connect, $sql) && mysqli_query($connect, $sql2)){
            echo "success";
        } else {
            echo "error1";
        }
    } else if($type == "task" || $type == "sub_task"){
        $sql3 = "UPDATE pert_table SET status = 'deleted' WHERE record_id = '$record_id' AND team_id = '$team_id'";
        if(mysqli_query($connect, $sql23)){
            echo "success";
        } else {
            echo "error2";
        }
    }
}
?>
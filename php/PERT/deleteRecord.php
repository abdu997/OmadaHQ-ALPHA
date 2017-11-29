<?php
include "../connect.php";
session_start();
$data = json_decode(file_get_contents("php://input"));
$team_id = $_SESSION['team_id'];
if(count($data) > 0){
    $record_id = mysqli_real_escape_string($connect, $data->record_id);
    $type = mysqli_real_escape_string($connect, $data->type);
    if($type == "goal"){
        $goal_id = $record_id;
        $sql = "UPDATE pert_table SET status = 'deleted' WHERE record_id = '$goal_id' AND team_id = '$team_id' AND type = 'goal'";
        //delete task and sub tasks under the goal
        $sql2 = "UPDATE pert_table SET status = 'deleted' WHERE goal_id = '$goal_id' AND team_id = '$team_id'";
        if(mysqli_query($connect, $sql) && mysqli_query($connect, $sql2)){
            echo "success";
        } else {
            echo "error1";
        }
    } else if($type == "task"){
        $goal_id = $_SESSION['goal_id'];
        $sql3 = "UPDATE pert_table SET status = 'deleted' WHERE goal_id = '$goal_id' AND record_id = '$record_id' AND type = 'task'";
        $sql4 = "UPDATE pert_table SET status = 'deleted' WHERE goal_id = '$goal_id' AND task_id = '$record_id' AND team_id = '$team_id' AND type = 'sub_task'";
        if(mysqli_query($connect, $sql3) && mysqli_query($connect, $sql4)){
            echo "success";
        } else {
            echo "error2";
        }
    } else if($type == "sub_task"){
        $goal_id = $_SESSION['goal_id'];
        $sql5 = "UPDATE pert_table SET status = 'deleted' WHERE goal_id = '$goal_id' AND record_id = '$record_id' AND team_id = '$team_id' AND type = 'sub_task'";
        if(mysqli_query($connect, $sql5)){
            echo "success";
        } else {
            echo "error2";
        }
    }
}
?>
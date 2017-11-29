<?php 
include "../connect.php";
$data = json_decode(file_get_contents("php://input"));
session_start();
$team_id = $_SESSION['team_id'];
$goal_id = $_SESSION['goal_id'];
if(count($data) > 0){
    $task_id = mysqli_real_escape_string($connect, $data->task_id);
    $sql = "SELECT color FROM pert_table WHERE goal_id = '$goal_id' AND team_id = '$team_id' AND record_id = '$task_id'";
    $result = mysqli_query($connect, $sql);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    if($count = 1){
        $_SESSION['color'] = $row['color'];
        $_SESSION['task_id'] = $task_id;
        echo "success";
    } else {
        echo "Task id set session variable failed";
    }
}
?>
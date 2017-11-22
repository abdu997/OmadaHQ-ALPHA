<?php
include '../connect.php';
session_start();
$data = json_decode(file_get_contents("php://input"));
$goal_id = mysqli_real_escape_string($connect, $data->record_id);
$team_id = $_SESSION['team_id'];

if(count($data) > 0){
    $sql = "SELECT * FROM pert_table WHERE team_id = '$team_id' AND record_id = '$goal_id' AND status = 'valid'";
    $result = mysqli_query($connect, $sql);
    $count = mysqli_num_rows($result);
    if($count = 1){
        $_SESSION['goal_id'] = $goal_id;
        echo "success";
    } else {
        echo "more than one goal record returned";
    }
}
?>

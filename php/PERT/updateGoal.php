<?php
include '../connect.php';
session_start();
error_reporting(0);
$team_id = $_SESSION['team_id'];
$data = json_decode(file_get_contents("php://input"));
$status = "valid";
$record_id = mysqli_real_escape_string($connect, $data->record_id);

$name = mysqli_real_escape_string($connect, $data->goal_name);
if(strlen($name) > 0 && strlen($name) < 20){
    $description = mysqli_real_escape_string($connect, $data->goal_description);
    $start_message = mysqli_real_escape_string($connect, $data->start_message);
    $end_time = mysqli_real_escape_string($connect, $data->end_time);
    $start_time = mysqli_real_escape_string($connect, $data->start_time);
} else {
    die("Goal name must be between 0 and 20 Characters");
}
if (count($data) > 0){
    $sql = "UPDATE pert_table SET name = '$name', description = '$description', start_message = '$start_message', start_time = '$start_time', end_time = '$end_time' WHERE record_id = '$record_id' AND team_id = '$team_id' AND type = 'goal'"; 
    if(mysqli_query($connect, $sql)){
        echo "success";
    } else { 
        echo "error";
    }
}
?>
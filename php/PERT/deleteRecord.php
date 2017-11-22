<?php
include "../connect.php";
session_start();
$data = json_decode(file_get_contents("php://input"));
$record_id = mysqli_real_escape_string($connect, $data->record_id);
$team_id = $_SESSION['team_id'];
if(count($data) > 0){
    $sql = "UPDATE pert_table SET status = 'deleted' WHERE record_id = '$record_id' AND team_id = '$team_id'";
    if(mysqli_query($connect, $sql)){
        echo "success";
    }
}
?>
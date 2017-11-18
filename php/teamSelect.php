<?php 
include'connect.php';
session_start();
$data = json_decode(file_get_contents('php://input'));

if(count($data) > 0){
    $_SESSION['team_id'] = $data->team_id;
    $_SESSION['admin_status'] = $data->admin_status;
    $_SESSION['team_type'] = $data->team_type;
    $_SESSION['team_name'] = $data->team_name;
    $_SESSION['plan'] = $data->plan;  
}
?>
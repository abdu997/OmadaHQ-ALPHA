<?php
include'connect.php';
session_start();
$user_id = $_SESSION['user_id'];
$team_id = $_SESSION['team_id'];
$admin_status = $_SESSION['admin_status'];
$team_type = $_SESSION['team_type'];

if($team_type == 'personal'){
    echo"Cannot delete personal dashboards";
} else if($admin_status == 'Y'){
    $sql = "DELETE FROM team_user WHERE team_id = '$team_id'";
    mysqli_query($connect, $sql);
    $sql2 = "DELETE FROM team_boards WHERE team_id = '$team_id'";
    mysqli_query($connect, $sql2);
    $sql3 = "DELETE FROM team_nonuser WHERE team_id = '$team_id'";
    mysqli_query($connect, $sql3);
    $sql4 = "DELETE FROM team_goal WHERE team_id = '$team_id'"; 
    mysqli_query($connect, $sql4);
    $sql5 = "DELETE FROM progress_record WHERE team_id = '$team_id'"; 
    mysqli_query($connect, $sql5);
    $sql6 = "DELETE FROM team WHERE team_id = '$team_id'";
    mysqli_query($connect, $sql6);
    echo"success";
    
    
    //After we delete the team, the angular will refresh the page, so we must replace all the session variables with the member's personal dashboard
    $sql7 = "SELECT team_id, team_name, type, plan FROM team WHERE type = 'personal' AND team_id IN (SELECT team_id FROM team_user WHERE user_id = '$user_id')";
    $result7 = mysqli_query($connect, $sql7);
    $row7 = mysqli_fetch_array($result7);
    
    $_SESSION['team_id'] = $row7[0];
    $_SESSION['team_name'] = $row7[1];
    $_SESSION['type'] = $row7[2];
    $_SESSION['plan'] = $row7[3];
    $_SESSION['admin_status'] = 'Y';
    
} else if($admin_status == 'N'){
    echo"You must be an admin to delete a team";
}
?>
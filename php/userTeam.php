<?php
include("connect.php");
session_start();
$output = array();
$user_id = $_SESSION['user_id'];
$query  = "SELECT * FROM team_user WHERE user_id='$user_id'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $team_id =  $row[1];
        $sql = "SELECT * FROM team WHERE team_id='$team_id'";
        $res = mysqli_query($connect, $sql);
        $team = mysqli_fetch_array($res);
        $row["team_name"] = $team[1];
        $row["type"] = $team[2];
        $row["plan"] = $team[3];
        $output[] = $row;
    }
    echo json_encode($output);
}
?>
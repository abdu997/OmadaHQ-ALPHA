<?php
include'connect.php';
session_start();
$team_id = $_SESSION['team_id'];
$sql = "SELECT * FROM team_user WHERE team_id = '$team_id'";
$result = mysqli_query($connect, $sql);
$sql2 = "SELECT email, admin FROM team_nonuser WHERE team_id = '$team_id' AND status = 'pending'";
$result2 = mysqli_query($connect, $sql2);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $users_id =  $row[2];
        $sql3 = "SELECT email, first_name, last_name FROM users WHERE user_id='$users_id'";
        $result3 = mysqli_query($connect, $sql3);
        $member = mysqli_fetch_array($result3);
        $row["member_email"] = $member[0];
        $row["member_name"] = $member[1].' '.$member[2];
        $row["member"] = 'Y';
        $output[] = $row;
    }
}
if(mysqli_num_rows($result2) > 0) {
    while ($row2 = mysqli_fetch_array($result2)) {
        $row2["member_email"] = $row2[0];
        $row2["admin"] = $row2[1];
        $row2["member"] = 'N';
        $output[] = $row2;
    }
}
echo json_encode($output);
?>

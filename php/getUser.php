<?php
include("connect.php");
session_start();
$user_id = $_SESSION['user_id'];
$output = array();
$query  = "SELECT * FROM users WHERE user_id='$user_id' ";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $output[] = $row;
    }
    echo json_encode($output);
}
?>

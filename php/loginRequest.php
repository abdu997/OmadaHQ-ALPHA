<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "connect.php";
$data = json_decode(file_get_contents("php://input"));
session_start();
if (count($data) > 0) {
    $myemail = mysqli_real_escape_string($connect, $data->email);
    $mypassword = mysqli_real_escape_string($connect, $data->password);
	$sql = "SELECT user_id, password, first_name FROM users WHERE email = '$myemail'";
	$result = mysqli_query($connect, $sql);
	$count = mysqli_num_rows($result);
	$row = $result -> fetch_row();
	if($count == 1){
		$bool = password_verify($mypassword, $row[1]);
		if($bool == true){
			$_SESSION['user'] = $myemail;
            $_SESSION['user_id'] = $row[0];
            $_SESSION['name'] = $row[2];
            $user_id = $_SESSION['user_id'];

            $sql2 = "SELECT team_id, team_name, type, plan FROM team WHERE type = 'personal' AND team_id IN (SELECT team_id FROM team_user WHERE user_id = '$user_id')";
            $result2 = mysqli_query($connect, $sql2);
            $row2 = $result2 -> fetch_row();
            $_SESSION['team_id'] = $row2[0];
            $_SESSION['team_name'] = $row2[1];
            $_SESSION['team_type'] = $row2[2];
            $_SESSION['plan'] = $row2[3];

            $team_id = $_SESSION['team_id'];

            $sql3 = "SELECT admin FROM team_user WHERE team_id = '$team_id'";
            $result3 = mysqli_query($connect, $sql3);
            $row3 = $result3 -> fetch_row();
            $_SESSION['admin_status'] = $row3[0];
            
            echo"success";
		} else {
            echo "error";
		}
	}
	else{
		echo "error";
	}
}
?>

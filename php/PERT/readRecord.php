<?php
include "../connect.php";
session_start();
$output = array();
$team_id = $_SESSION['team_id'];
$goal_id = $_SESSION['goal_id'];
//query for sub_tasks and tasks
$sql = "SELECT record_id, type, user_id, name, start_message, start_time, end_time, expected_time, optimistic_time, realistic_time, pessimistic_time, task_id, goal_id, color, progress, timestamp FROM pert_table WHERE goal_id = '$goal_id' AND team_id = '$team_id' AND (type = 'task' OR type = 'sub_task') AND status = 'valid'";
$result = mysqli_query($connect, $sql);
$count = mysqli_num_rows($result);
//query for goals
$sql2 = "SELECT record_id, type, user_id, name, description,  start_message, start_time, end_time, progress, timestamp FROM pert_table WHERE record_id = '$goal_id' AND team_id = '$team_id' AND type = 'goal' AND status = 'valid'";
$result2 = mysqli_query($connect, $sql2);
$row2 = mysqli_fetch_array($result2);
$date = date("Y-m-d");
$start_time = $row2["start_time"];
if($start_time > $date){
    $start_time4 = $row2["start_time"];
} else if($start_time < $date){
    $start_time4 = date("Y-m-d");
} else {
    echo "oh no";
}

//Getting the sum of expected times from all subtasks and tasks of a goal
$sql3 = "SELECT SUM(expected_time) expected_sum FROM pert_table WHERE goal_id = '$goal_id' AND progress = 'incomplete' AND status = 'valid'";
$result3 = mysqli_query($connect, $sql3);
$row3 = mysqli_fetch_array($result3);
$expected_sum = $row3["expected_sum"];
if ($expected_sum == null){
    $expected_sum2 = "0";
} else {
    $expected_sum2 = $expected_sum;
}
$start_time3 = new DateTime($start_time4);
$start_time3->add(new DateInterval('P'.$expected_sum2.'D'));
$estimate = $start_time3->format('Y-m-d');
if($estimate == $date){
    $estimate = "completed";
} 
$row2["estimate_end"] = $estimate;

if ($count > 0){
    while ($row = mysqli_fetch_array($result)){ 
        $type = $row["type"];
        if($type == "sub_task") {
            
        } else if($type == "task"){
            $task_id = $row["record_id"]; 
            $expected_time = $row["expected_time"];
            $sql4 = "SELECT SUM(expected_time) days FROM pert_table WHERE task_id = '$task_id' AND type = 'sub_task' AND progress = 'incomplete'";
            $result4 = mysqli_query($connect, $sql4);
            $row4 = mysqli_fetch_array($result4);
            $days = $row4["days"];
            $task_estimate = $days + $expected_time;
            $row["cumulative_time"] = $task_estimate;
        }
        $output[] = $row;
    }
}
$output[] = $row2;
echo json_encode($output);

?>
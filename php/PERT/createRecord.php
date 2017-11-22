<?php
include '../connect.php';
session_start();
error_reporting(0);
$user_id = $_SESSION['user_id'];
$team_id = $_SESSION['team_id'];
$data = json_decode(file_get_contents("php://input"));
$type = mysqli_real_escape_string($connect, $data->type);
$status = "valid";
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}
function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}
if ($type == "goal"){
    $name = mysqli_real_escape_string($connect, $data->goal_name);
    if(strlen($name) > 0 && strlen($name) < 20){
        $description = mysqli_real_escape_string($connect, $data->goal_description);
        $start_message = mysqli_real_escape_string($connect, $data->start_message);
        $end_time = mysqli_real_escape_string($connect, $data->end_time);
        $start_time = mysqli_real_escape_string($connect, $data->start_time);
        $expected_time = "null";
        $optimistic_time = "null";
        $realistic_time = "null";
        $pessimistic_time = "null";
        $goal_id = "null";
        $task_id = "null";
        $color = "null";
        $progress = "null";
    } else {
        die("Goal name must be between 0 and 20 Characters");
    }
} else if($type == "task"){
    $name = mysqli_real_escape_string($connect, $data->task_name);
    if(strlen($name) > 0 && strlen($name) < 20){
        $description = "null";
        $start_message = "null";
        $start_time = "null";
        $end_time = "null";
        $optimistic_time = mysqli_real_escape_string($connect, $data->optimistic_time);
        $realistic_time = mysqli_real_escape_string($connect, $data->realistic_time);
        $pessimistic_time = mysqli_real_escape_string($connect, $data->pessimistic_time);
        if($optimistic_time > 0 && $realistic_time > 0 && $pessimistic_time > 0){
            $numerator = $optimistic_time + 4 * $realistic_time + $pessimistic_time;
            $expected_time = $numerator / 6;
            $color = random_color();
            $progress = "null";
            $goal_id = $_SESSION['goal_id'];
            $task_id = "null";
        } else {
            die("Days must be more than zero");
        }
    } else {
        die("Task name must be between 0 and 20 Characters");
    }
} else if($type == "sub_task"){
    $name = mysqli_real_escape_string($connect, $data->sub_task_name);
    if(strlen($name) > 0 && strlen($name) < 20){
        $description = "null";
        $start_message = "null";
        $start_time = "null";
        $end_time = "null";
        $optimistic_time = mysqli_real_escape_string($connect, $data->sub_optimistic_time);
        $realistic_time = mysqli_real_escape_string($connect, $data->sub_realistic_time);
        $pessimistic_time = mysqli_real_escape_string($connect, $data->sub_pessimistic_time);
        if($optimistic_time > 0 && $realistic_time > 0 && $pessimistic_time > 0){
            $numerator = $optimistic_time + 4 * $realistic_time + $pessimistic_time;
            $expected_time = $numerator / 6;
            $progress = "null";
            $goal_id = $_SESSION['goal_id'];
            $task_id = $_SESSION['task_id'];
            $color = $_SESSION['color'];
        } else {
            die("Days must be more than zero");
        }
    } else {
        die("Sub Task name must be between 0 and 20 Characters");
    }
} else {
    die("Record Type Error");
}
if (count($data) > 0){
    $sql = "INSERT INTO pert_table (type, team_id, user_id, name, description, start_message, start_time, end_time, expected_time, optimistic_time, realistic_time, pessimistic_time, goal_id, task_id, color, progress, timestamp, status) VALUES ('$type', '$team_id', '$user_id', '$name', '$description', '$start_message', '$start_time', '$end_time', '$expected_time', '$optimistic_time', '$realistic_time', '$pessimistic_time', '$goal_id', '$task_id', '$color', '$progress', '$timestamp', '$status')"; 
    if(mysqli_query($connect, $sql)){
        echo "success";
        if($type == "goal"){
            $goal_id = mysqli_insert_id($connect);
            $_SESSION['goal_id'] = $goal_id;
        }
        if($type == "task"){
            $task_id = mysqli_insert_id($connect);
            $_SESSION['task_id'] = $task_id;
            $_SESSION['color'] = $color;
        }
    } else { 
        echo "error";
    }
}
?>
<?php
include'connect.php';
error_reporting(E_ERROR);
session_start();
$data = json_decode(file_get_contents("php://input"));
$team_id = $_SESSION['team_id'];
$team_type = $_SESSION['team_type'];
$plan = $_SESSION['plan'];
$admin_status = $_SESSION['admin_status'];
$new_admin_status = mysqli_real_escape_string($connect, $data->admin);
if($admin_status == 'Y'){
    $email = mysqli_real_escape_string($connect, $data->email);
    if($data->admin == 'N' || $data->admin == 'Y'){
        $admin = mysqli_real_escape_string($connect, $data->admin);
    }
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        if(count($data)>0){
            if($team_type == 'personal'){
                echo "Adding members to personal dashboard's is not permissible";
            } else if($plan == 'free'){
                $sql6 = "SELECT * FROM team_user WHERE team_id = '$team_id'";
                $result6 = mysqli_query($connect, $sql6);
                $count6 = mysqli_num_rows($result6);
                $sql7 = "SELECT * FROM team_nonuser WHERE team_id = '$team_id'";
                $result7 = mysqli_query($connect, $sql7);
                $count7 = mysqli_num_rows($result7);
                $member_count = $count6+$count7;
                if($member_count < 16){
                    //check if email is in use in users table
                    $sql = "SELECT user_id FROM users WHERE email = '$email'";
                    $result = mysqli_query($connect, $sql);
                    $count = mysqli_num_rows($result);
                    if($count == 1){
                        //query the user's user_id from 'users'
                        $row = mysqli_fetch_assoc($result);
                        $user_id = $row['user_id'];
                        //check if user_id and team_id are in a record at 'team_user'
                        $sql2 = "SELECT user_id, user_id FROM team_user WHERE user_id = '$user_id' AND team_id = '$team_id'";
                        $result2 = mysqli_query($connect, $sql2);
                        $count2 = mysqli_num_rows($result2);
                        if($count2 == 1){
                            //user is already in this team
                            echo "This user is already in this team";
                        } else if($count2 == 0) {
                            //user is not in team, create connection
                            if ($new_admin_status == 'Y'){
                                //Check admin counts
                                $sql7 = "SELECT user_id FROM team_user WHERE team_id = '$team_id' AND admin = 'Y'";
                                $result7 = mysqli_query($connect, $sql7);
                                $admin_count = mysqli_num_rows($result7);
                                if($admin_count > 3){
                                    echo"You cannot have more than 3 admins on the free plan";
                                } else {
                                    $sql8 = "INSERT INTO team_user(team_id, user_id, admin) VALUE('$team_id', '$user_id', '$new_admin_status')";
                                    if(mysqli_query($connect, $sql8)){
                                        echo"success"; 
                                    }
                                }
                            } else if ($new_admin_status == 'N'){
                                $sql3 = "INSERT INTO team_user(team_id, user_id, admin) VALUE('$team_id', '$user_id', '$new_admin_status')";
                                if(mysqli_query($connect, $sql3)){
                                    echo "success";
                                } else {
                                    echo "serious error3";
                                }
                            } else {
                                echo"serious error 6";
                            }
                        } else {
                            echo "serious error2";
                        }
                    } else if($count == 0) {
                        if($new_admin_status == 'Y'){
                            echo"This email is not an OmadaHQ user, therefore this member cannot be an admin";
                        } else if($new_admin_status == 'N'){
                            //check if email is already in team_nonuser
                            $sql4 = "SELECT email, team_id FROM team_nonuser WHERE email = '$email' AND team_id = '$team_id'";
                            $result4 = mysqli_query($connect, $sql4);
                            $count4 = mysqli_num_rows($result4);
                            if($count4 == 0){
                                $sql5 = "INSERT INTO team_nonuser(email, team_id, admin, status) VALUE('$email', '$team_id', '$new_admin_status', 'pending')";
                                if(mysqli_query($connect, $sql5)){
                                    $team_name = $_SESSION['team_name'];
                                    $subject = "You Have Been Invited to OmadaHQ";
                                    $headers  = "From: OmadaHQ < no-reply@omadahq.com >\n";
                                    $headers .= "X-Sender: OmadaHQ < no-reply@omadahq.com >\n";
                                    $headers .= 'X-Mailer: PHP/' . phpversion();
                                    $headers .= "MIME-Version: 1.0\r\n";
                                    $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
                                    $link = "https://omadahq.com/dashboard/login.php?email=".$email;
                                    $content = "<p>Hello! <br> You have been added to team ".$team_name." on OmadaHQ. To access the team, please register to OmadaHQ using this email <i>".$email."</i></p><br><br>
                                    <a href='".$link."'><button style='background: #2196F3; padding: 10px 50px 10px 50px; color: white; border:none'>Register</button></a>";
                                    $message = "
                                        <html lang='en' style='font-size: 15px; font-family: Montserrat, sans-serif; line-height: 28px;'>
                                            <center>
                                                <body style='margin:0px; width: 100%'>
                                                    <table style='border-spacing: 0px; min-width: 502px'>
                                                        <thead>
                                                            <td style='background: #2196f3; width: 100%; height: 70px'>
                                                                <span style='margin: 25px 0px 25px 25px; color: #FDFFFC'>OmadaHQ</span><small style='font-size: 10px; color: white;'>BETA</small>
                                                            </td>
                                                        </thead>
                                                        <tbody>
                                                            <td style='background: #f1f1f1!important; width: 100%; min-height: 1000px; padding: 50px'>".$content."</td>
                                                        </tbody>
                                                    </table>
                                                </body>
                                            </center>
                                        </html>";
                                    mail($email, $subject, $message, $headers);
                                    echo"An invitation has been sent to ".$email.", please advise your member to register to OmadaHQ";
                                } else {
                                    echo"serious error3";
                                }
                            } else if($count4 > 0){
                                echo"This email is already a member in this team";
                            }
                        }
                    } else {
                        echo "serious error4";
                    }
                } else {
                    echo"too many members";
                }
            } else {
                echo"serious error 5";
            }
        }
    } else {
        echo "This email is not valid";
    }
} else {
    echo"You are not an admin";
}
?>
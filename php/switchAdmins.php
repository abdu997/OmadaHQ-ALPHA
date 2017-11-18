<?php
include'connect.php';
session_start();
$data = json_decode(file_get_contents("php://input"));
$admin_status = $_SESSION['admin_status']; 
if($admin_status == 'Y'){
    if(count($data)>0){
        $user_id = $_SESSION['user_id'];
        $team_id = $_SESSION['team_id'];
        $old_admin = mysqli_real_escape_string($connect, $data->old_admin_email);
        $new_admin = mysqli_real_escape_string($connect, $data->new_admin_email);
        //check if new or old admin are not null
        if($new_admin = null || $old_admin = null){
            //Check if $old_admin is a user
            $sql = "SELECT user_id FROM users WHERE email = '$old_admin'";
            $result = mysqli_query($connect, $sql);
            $count = mysqli_num_rows($result);

            if($count = 1){
                $row = mysqli_fetch_array($result);
                $user_id1 = $row[0];
                $sql2 = "SELECT team_id FROM team_user WHERE user_id = '$user_id' AND team_id = '$team_id' AND admin = 'Y'";
                $result2 = mysqli_query($connect, $sql2);
                $count2 = mysqli_num_rows($result2);

                if($count2 = 1){
                    //If the argument goes this far, that means $old_admin is infact an admin in this team. Now we check the integrity of $new admin.

                    $sql3 = "SELECT user_id FROM users WHERE email = '$new_admin'";
                    $result3 = mysqli_query($connect, $sql3);
                    $count3 = mysqli_num_rows($result3);

                    if($count = 1){
                        $row3 = mysqli_fetch_row($result3);
                        $user_id2 = $row3[0];
                        $sql4 = "SELECT team_id FROM team_user WHERE user_id = '$user_id1' AND team_id = '$team_id' AND admin = 'N'";
                        $result4 = mysqli_query($connect, $sql4);
                        $count4 = mysqli_num_rows($result4);

                        if($count4 = 1){
                            //By this point, the old email is and admin, and the new email is a user, so we go ahead with changing admin status for both.
                            //Make new email user the admin
                            $sql5 = "UPDATE team_user SET admin = 'Y' WHERE user_id = '$user_id2'";
                            if (mysqli_query($connect, $sql5)){
                                $sql6 = "UPDATE team_user SET admin = 'N' WHERE user_id = '$user_id1'";
                                if(mysqli_query($connect, $sql6)){
                                    if($user_id == $user_id1){
                                        $_SESSION['admin_status'] = 'N';
                                        echo"success1";
                                    } else {
                                        echo"success2";
                                    }
                                } else {
                                    echo "php error1";
                                }
                            } else {
                                echo"php error2";
                            }
                        } else if($count4 = 0) {
                            echo "This email is not in this team";
                        } else {
                            echo "Database error";
                        }
                    } else {
                        echo "new email is not a user";
                    }

                } else if($count = 0) {
                    echo "This email is not an admin";
                } else {
                    echo"Database error, there are more than one connection record";
                }
            } else {
                echo "old admin email is not a user";
            } 
        } else {
            echo"There arent any members to switch with, trying adding new members";
        }
    }   
} else {
    echo"you are not an admin";
}
?>
<?php
include "connect.php";
$data = json_decode(file_get_contents("php://input"));
$email = mysqli_real_escape_string($connect, $data->reset_email);
if (count($data) > 0) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $sql = "SELECT user_id, password, first_name FROM users WHERE email = '$email'";
        $result = mysqli_query($connect, $sql);
        $count = mysqli_num_rows($result);
        if($count == 1){
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
            $bytes = openssl_random_pseudo_bytes(20 );
            $token = bin2hex($bytes);
            $date_expiration = date("Y-m-d", strtotime("+30 minutes"));
            $time_expiration = date("H:i:s", strtotime("+30 minutes"));
            $expiration = $date_expiration . 'T' . $time_expiration . '-04:00';
            $sql2 = "INSERT INTO password_reset(user_id, user_email, token, timestamp, expiration, status) VALUE('$user_id', '$email', '$token', '$timestamp', '$expiration', 'active')";
            if(mysqli_query($connect, $sql2)) {
                echo "success";
                $link = 'https://www.omadahq.com/dashboard/password.php?token='.$token;
                $headers  = "From: OmadaHQ < no-reply@omadahq.com >\n";
                $headers .= "X-Sender: OmadaHQ < no-reply@omadahq.com >\n";
                $headers .= 'X-Mailer: PHP/' . phpversion();
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
                
                $content = "<p>Hello! <br> You have requested a reset to your password, click the button below to reset your password</p><br><br><a href='".$link."' target='_blank'><button style='background: #2196F3; padding: 10px 50px 10px 50px; color: white; border:none'>Reset</button></a><br><br><small>Ignore this message if you did not request a password rest</small>";
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
                mail($email, 'OmadaHQ Password Reset link', $message, $headers);
            } else {
                echo "error2";
            }
        } else {
            echo "error1";
        }
    } else {
       echo"Email must be valid";
    }
}
?>

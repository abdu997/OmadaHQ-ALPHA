<head>
    <title>OmadaHQ</title>
    <link rel="shortcut icon" type="image/x-icon" href="https://omadahq.com/img/icon.png">
    <script src="js/angular.min.js"></script>
    <script src="js/jquery.js"></script>
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--Fonts-->
    <link rel="stylesheet" href="css/raleway.css">
    <style>
        .hidden {
            display: none;
        }
        body {
            background: #f1f1f1!important;
        }
        input {
            width: 200px;
            margin-bottom: -10px;
        }
        button {
            width: 100px;
        }
        .w3-button {
            background: #bdc3c7;
        }
        form {
            max-width: 200px
        }
        .error {
            color: #e74c3c;
        }
    </style>
</head>



<?php
error_reporting(E_ERROR);
include "php/connect.php";
if(isset($_GET['token'])){
    $token = $_GET['token'];
}
$sql = "SELECT user_id FROM users WHERE password = '$token'";
$result = mysqli_query($connect,$sql);
$count = mysqli_num_rows($result);
if($count == 1){
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];
    $form = "
        <form name='passwordForm'>
            <label>Password</label><br>
            <input id='password' ng-model='password' type='password' autocomplete='off' class='w3-input w3-border-0'>
            <small><br>Must contain an uppercase and lowercase letter, number and min. 8 characters</small><br>
            <small class='error' ng-show='patternError'>Password must meet requirements<br></small>
            <label>Repeat Password</label><br>
            <input id='repeatPassword' ng-model='repeatPassword' type='password' autocomplete='off' class='w3-input w3-border-0'><br>
            <small class='error' ng-show='repeatError'>Passwords must match!<br></small>
            <input ng-click='passwordInsert(". $user_id .");' id='passwordInsert' class='w3-button' value='update' type='submit'>
        </form>";
//    print $form;
} else if ($count == 0){
    $sql2 = "SELECT user_email, expiration, status FROM password_reset WHERE token = '$token'";
    $result2 = mysqli_query($connect,$sql2);
    $count2 = mysqli_num_rows($result2);
    if ($count2 == 1){
        $row2 = mysqli_fetch_assoc($result2);
        $status = $row2['status'];
        $user_email = $row2['user_email'];
        $expiration = $row2['expiration'];
        if ($expiration >= $timestamp){
            if($status == "active"){
                $sql3 = "SELECT user_id FROM users WHERE email='$user_email'";
                $result3 = mysqli_query($connect,$sql3);
                $count3 = mysqli_num_rows($result3);
                if($count3 == 1){
                    $row3 = mysqli_fetch_assoc($result3);
                    $user_id1 = $row3['user_id'];
                    $form = "
                        <form name='passwordForm'>
                            <label>Password</label><br>
                            <input id='password' ng-model='password' type='password' autocomplete='off' class='w3-input w3-border-0'>
                            <small><br>Must contain an uppercase and lowercase letter, number and min. 8 characters</small><br>
                            <small class='error' ng-show='patternError'>Password must meet requirements<br></small>
                            <label>Repeat Password</label><br>
                            <input id='repeatPassword' ng-model='repeatPassword' type='password' autocomplete='off' class='w3-input w3-border-0'><br>
                            <small class='error' ng-show='repeatError'>Passwords must match!<br></small>
                            <input ng-click='passwordInsert(". $user_id1 .");' id='passwordInsert' class='w3-button' value='update' type='submit'>
                        </form>";
                }
            } else {
                $error = "Password reset link has been used already, try reseting password again"; 
            }
        } else {
            $sql4 = "UPDATE password_reset SET status = 'expired' WHERE token = '$token'";
            mysqli_query($connect, $sql4);
            $error = "Password reset link has expired, try reseting password again";
        }
    } else {
        $error = "Password reset link is invalid";
    }
}
?>
<html>
    <body ng-app="registerApp" ng-controller="registerController"  class="w3-display-middle">
        <center><h1>OmadaHQ</h1></center>
        <?php echo $error; ?>
        <?php print $form; ?>
    </body>
    <script>
        $("#passwordInsert").click(function(event){
            event.preventDefault();
        });
    </script>
    <script>
        var app = angular.module('registerApp', []);
        app.controller('registerController', function($scope, $http) {
            
            $scope.pwdpattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;
            $scope.passwordInsert = function(user_id) {
                if ($scope.pwdpattern.test($scope.password)) { 
                    if (password.value == repeatPassword.value){
						$http.post("php/update_pass.php", {
                        	'user_id': user_id,
							'password':$scope.password
							
                    }).success(function(data) {
                            if(data == "success"){
                                window.location = 'login.php';
                            } else {
                                alert(data);
                            }
                    });
                        $scope.password = null;
                        $scope.repeatPassword = null;
                    } else {
                        $scope.repeatError = true;
                        $scope.patternError = false;
                        repeatPassword.style.backgroundColor = "#e74c3c";
                        password.style.backgroundColor = "white";
                    }
                } else {
                    $scope.patternError = true;
                    password.style.backgroundColor = "#e74c3c";
                } 
            }
        });
    </script>
</html>

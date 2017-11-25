<?php 
error_reporting(E_ERROR);
include "php/connect.php";
if(isset($_GET['email'])){
    $email = $_GET['email'];
    $hidden = "hidden";
    $display = "display";
} else {
    $display = "hidden";
    $email = "example@domain.com";
}
?>
<html>
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
            .display {
                display: block;
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
            a:hover {
                text-decoration: none;
                cursor: pointer;
            }
        </style>
    </head>
    <body ng-app="loginApp" ng-controller="webEntranceController" class="w3-display-middle">
        <center>
            <h1 style="margin-bottom: 30px">OmadaHQ</h1>
            <div class="<?php echo $hidden;?>">
                <button ng-click="navButton()" id="loginTab" class="w3-button" style="width: 96px">Login</button>
                <button ng-click="navButton()" id="registerTab" class="w3-button" style="width: 96px">Register</button>
            </div>
        </center><br>
        <form id="loginForm" class="<?php echo $hidden;?>">
            <label>Email</label><br>
            <input type="email" ng-model="email" class="w3-input w3-border-0"><br>
            <label>Password</label><br>
            <input type="password" ng-model="password" class="w3-input w3-border-0"><br>
            <a id="resetTab">Forgot password?</a><br><br>
            <small style="color: red;" ng-show="loginError">Email/password do not match our records. Please try again<br><br></small>
            <input type="submit" value="login" class="w3-button" ng-click="login()"><br><br>
            <p>Don't have an account?</p>
            <a id="registerTab2">Register here!</a><br>
        </form>
        <div id="registerForm" class="<?php echo $display;?>" style="width: 200px">
            <form ng-hide="registerForm">
                <label>Email</label><br>
                <input type="email" ng-model="registerEmail" placeholder="<?php echo $email;?>" class="w3-input w3-border-0"><br>
                <small style="color: red;" ng-show="emailInvalid">Valid email is required<br></small>
                <label>First Name</label><br>
                <input type="text" ng-model="firstName" class="w3-input w3-border-0" pattern="[a-zA-Z]+" ng-pattern-restrict><br>
                <small style="color: red;" ng-show="firstEmpty">First name is required<br></small>
                <label>Last Name</label><br>
                <input type="text" ng-model="lastName" class="w3-input w3-border-0" pattern="[a-zA-Z]+" ng-pattern-restrict><br>
                <small style="color: red;" ng-show="lastEmpty">Last name is required<br><br></small>
                <small style="color: red;" ng-show="registerError">Email is already being used, try loging in or reseting your password<br></small>
                <input ng-click="register()" type="submit" class="w3-button" value="register">
            </form>
            <small style="color: green;" ng-show="registerSuccess">Registration successful, check your email for confirmation and password setup link!<br></small>
        </div>
        <div id="passwordReset" class="hidden" style="width: 200px">
            <form ng-hide="passwordResetForm">
                <h4>Password Reset</h4>
                <label>Email Address</label>
                <input ng-model="resetEmail" class="w3-input w3-border-0" type="email">
                <small style="color: red;" ng-show="resetEmailEmpty"><br>Email cannot be empty or invalid</small>
                <small style="color: red;" ng-show="recordError"><br>Sorry, this email is not in our records<br></small>
                <br><br>
                <input ng-click="passwordReset()" class="w3-button" type="submit" value="Reset">
            </form>
            <center>
                <small style="color: green;" ng-show="resetPasswordSuccess"><br>Success! Check your email, the reset link is valid for 30 minutes</small>
            </center>
        </div>
    </body>
    <script>
        $("#registerTab").click(function(e) {
            e.preventDefault();
            $("#passwordReset").addClass("hidden");
            $("#loginForm").addClass("hidden");
            $("#registerForm").removeClass("hidden");
        });
        $("#registerTab2").click(function(e) {
            e.preventDefault();
            $("#passwordReset").addClass("hidden");
            $("#loginForm").addClass("hidden");
            $("#registerForm").removeClass("hidden");
        });
        $("#loginTab").click(function(e) {
            e.preventDefault();
            $("#loginForm").removeClass("hidden");
            $("#registerForm").addClass("hidden");
            $("#passwordReset").addClass("hidden");
        });
        $("#resetTab").click(function(e) {
            e.preventDefault();
            $("#loginForm").addClass("hidden");
            $("#registerForm").addClass("hidden");
            $("#passwordReset").removeClass("hidden");
        });
    </script>
    <script>
        var app = angular.module('loginApp', []);
        app.controller('webEntranceController', function($scope, $http) {
            $scope.login = function() {
                if ($scope.email == null) {
                    alert("Email invalid");
                } else if ($scope.password == ""){
                    alert("Password is needed");
                } else {
                    $http.post(
                        "php/loginRequest.php", {
                            'email': $scope.email,
                            'password': $scope.password
                        }
                    ).success(function(data) {
                        if (data == "error") {
                            $scope.loginError = true;
                        } else if(data == "success") {
                            $scope.email = null;
                            $scope.password = null;
                            window.location.href = "index.php";
                            $scope.loginError = false;
                        } else {
                            alert(data);
                        }
                    });
                }
            }
            
            $scope.emailpattern = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/;
            $scope.register = function() {
                if($scope.emailpattern.test($scope.registerEmail)) {
                    if($scope.firstName == null){
                        $scope.firstEmpty = true;
                        $scope.emailInvalid = false;
                        $scope.lastEmpty = false;
                        $scope.registerError = false;
                        $scope.registerSuccess = false;
                    } else if($scope.lastName == null){
                        alert($scope.firstName);
                        $scope.lastEmpty = true;
                        $scope.firstEmpty = false;
                        $scope.emailInvalid = false;
                        $scope.registerError = false;
                        $scope.registerSuccess = false;
                    } else {
                        $http.post(
                            "php/registerRequest.php", {
                                'email': $scope.registerEmail,
                                'first_name': $scope.firstName,
                                'last_name': $scope.lastName
                            }
                        ).success(function(data) {
                            if(data == "error"){
                                $scope.registerError = true;
                                $scope.lastEmpty = false;
                                $scope.firstEmpty = false;
                                $scope.emailInvalid = false;
                                $scope.registerSuccess = false;
                            } else if(data == "success"){
                                $scope.registerEmail = null;
                                $scope.firstName = null;
                                $scope.lastName = null;
                                $scope.registerSuccess = true;
                                $scope.registerForm = true;
                                $scope.registerError = false;
                                $scope.lastEmpty = false;
                                $scope.emailInvalid = false;
                            } else {
                                alert(data);
                                $scope.registerError = false;
                                $scope.lastEmpty = false;
                                $scope.firstEmpty = false;
                                $scope.emailInvalid = false;
                                $scope.registerSuccess = false;
                            }
                        });
                    }
                } else {
                    $scope.emailInvalid = true;
                }
            }
            
            $scope.navButton = function(){
                $scope.registerSuccess = false;
                $scope.registerForm = false;
                $scope.resetPasswordSuccess = false;
                $scope.passwordResetForm = false;
                $scope.recordError = false;
                $scope.resetEmailEmpty = false;
                $scope.emailInvalid = false;
                $scope.lastEmpty = false;
                $scope.loginError = false;
            }
            
            $scope.passwordReset = function() {
                if($scope.resetEmail == null) {
                    $scope.resetEmailEmpty = true;
                    $scope.resetPasswordSuccess = false;
                } else {
                    $http.post(
                        "php/passwordReset.php", {
                            'reset_email': $scope.resetEmail
                        }
                    ).success(function(data) {
                        if(data == "error2"){
                            alert("something went wrong");
                        } else if(data == "error1"){
                            $scope.recordError = true;
                            $scope.resetPasswordSuccess = false;
                            $scope.resetEmailEmpty = false;
                        } else if(data == "success"){
                            $scope.recordError = false;
                            $scope.resetEmailEmpty = false;
                            $scope.resetPasswordSuccess = true;
                            $scope.passwordResetForm = true;
                        } else {
                            alert(data);
                        }
                    });
                }
            }
        });
    </script>

</html>
<?php
session_start();
$team_name = $_SESSION['team_name'];
include "php/connect.php";
if(!isset($_SESSION['name'])){
header('Location: login.php');
}
?>
<html>
<head>
    <title>OmadaHQ</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://omadahq.com/img/icon.png">
    <!--UI FrameWorks-->
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!--Fonts-->
    <link rel="stylesheet" href="css/raleway.css">

    <!--Icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons-2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
    <!--Custom Stylesheet-->
    <link rel="stylesheet" href="css/style.css">
    
    <!--Angular Scripts-->
    <script src="js/angular.min.js"></script>
    <script src="js/omadaApp.js"></script>
    <script src="https://code.angularjs.org/1.4.8/angular-sanitize.min.js"></script>
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
</head>

<!-- Top container -->
<body onload="myFunction()" class="w3-light-grey" style="margin-top: 43px" ng-app="omadaApp">
    <!-- Sidebar/menu -->
    <? include 'nav-sidebar.php';?>
    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <div class="w3-main" style="margin-left: 200px">
        <div class="w3-container">
        </div>
        <div class="w3-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tile-bg" style="display:none;" id="app" class="animate-bottom">
                        <?php include'projectManager.php';?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!--Javascript-->
    <script for="sidebar">
        var mySidebar = document.getElementById("mySidebar");
        var overlayBg = document.getElementById("myOverlay");
        function w3_open() {
            if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
                overlayBg.style.display = "none";
            } else {
                mySidebar.style.display = 'block';
                overlayBg.style.display = "block";
            }
        }
        function w3_close() {
            mySidebar.style.display = "none";
            overlayBg.style.display = "none";
        }
    </script>
    <script>
        var myVar;

        function myFunction() {
            myVar = setTimeout(showPage, 500);
        }

        function showPage() {
          document.getElementById("app").style.display = "block";
        }
    </script>
</body>

</html> 

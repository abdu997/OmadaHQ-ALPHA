<?php
$team_id = $_SESSION['team_id'];
$admin_status = $_SESSION['admin_status'];
$team_type = $_SESSION['team_type'];
$plan = $_SESSION['plan'];
$user_id = $_SESSION['user_id'];
?>
<style>
    .hidden {
        display: none;
    }
</style>
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4; position: fixed; background: #2196F3!important;">
    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey w3-right" style="color:white" onclick="w3_open();"><i class="fa fa-bars"></i> &nbsp;Menu</button>
    <span class="w3-bar-item" style="color:white">OmadaHQ<small style="font-size: 10px">BETA</small></span>
</div>
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:200px;" id="mySidebar" ng-controller="SessionController" ng-init="userTeams(); userinfo()">
    <br>
    <div class="w3-container w3-row" ng-repeat="x in user">
        <div class="w3-col s4">
            <!--                <img src="{{x.user_image}}" class="w3-circle w3-margin-right" style="width:55px; height: 55px;">-->
        </div>
        <div class="w3-col s8 w3-bar">
            <h4 style="text-transform: capitalize;">Welcome, <strong>{{x.first_name}}</strong></h4>
        </div>
    </div>
    <hr>
    <div class="w3-bar-block">
        <a class="w3-bar-item w3-bar w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>&nbsp; Close Menu</a>
        <div onClick="window.location.reload()" ng-click="teamSelect(x.team_id, x.admin, x.type, x.team_name, x.plan)" ng-repeat="x in teams | filter : {'type':'personal'} " style="text-transform: capitalize; color: white;">
            <a ng-class="{'active': x.team_id == <?php echo $team_id;?>}" class="w3-bar-item w3-bar w3-button w3-padding"><i class="fa fa-user fa-fw"></i>&nbsp; {{x.team_name}}</a>
        </div>
        <a onclick="document.getElementById('edit_user').style.display='block'" class="w3-bar-item w3-bar w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>&nbsp; Edit Account</a>
        <a onclick="document.getElementById('team_create').style.display='block'" class="w3-bar-item w3-bar w3-button w3-padding"><i class="fa fa-plus fa-fw"></i>&nbsp; Create Team</a>
        <a href="php/logout.php" class="w3-bar-item w3-bar w3-button w3-padding logout"><i class="fa fa-sign-out fa-fw"></i>&nbsp; Log Out</a>
        <hr>
        <div onClick="window.location.reload()" ng-click="teamSelect(x.team_id, x.admin, x.type, x.team_name, x.plan)" ng-repeat="x in teams | filter : {'type':'team'}" style="text-transform: capitalize; color: white;">
            <a ng-class="{'active': x.team_id == <?php echo $team_id;?>}" class="w3-bar-item w3-bar w3-button w3-padding"><i class="fa fa-users fa-fw"></i>&nbsp; {{x.team_name}}</a>
        </div>
        <br>
        <br>
    </div>
</nav>
<!--modal-->
<div id="team_create" class="w3-modal" ng-controller="SessionController">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="padding: 25px; background: #f1f1f1!important; width: 40%;">
        <span onclick="document.getElementById('team_create').style.display='none';window.location.reload()" class="w3-button w3-display-topright" style="font-size: 20px">&times;</span>
        <div class="w3-container">
            <h4>Create a Team</h4>
            <form name="createTeamForm">
                <label>Team Name<span class="asterisk">*</span>
                </label>
                <input ng-model="newTeamName" class="w3-input w3-border-0" type="text" required>
                <input ng-click="createTeam()" class="w3-button" type="submit" value="Create Team" style="background: white; margin-top: 10px" ng-disabled="createTeamForm.$invalid">
                <small ng-show="teamCreateSuccess" style="color: green">Team successfully created!<br></small>
                <p><small>NOTE: You will be the Admin for the team. You can set up a team without members, and add members later.</small>
                </p>
            </form>
            <form name="newTeamMemberInsertForm" ng-hide="newTeamMemberInsertForm">
                <label>New Member Email</label>
                <input ng-model="insertMemberInput" class="w3-input w3-border-0" type="email" autocomplete="off" required>
                <input ng-click="insertMember()" class="w3-button" type="submit" ng-disabled="newTeamMemberInsertForm.$invalid" value="Add Member" style="background: white; margin-top: 4px">
            </form>
        </div>
    </div>
</div>
<div id="edit_user" class="w3-modal">
    <div ng-controller="SessionController"  ng-init="userinfo()" class="w3-modal-content w3-animate-top w3-card-4" style="padding: 25px; background: #f1f1f1!important; width: 40%;">
        <span onclick="document.getElementById('edit_user').style.display='none'" class="w3-button w3-display-topright" style="font-size: 20px">&times;</span>
        <div class="w3-container">
            <h4>Edit Personal Profile</h4>
            <form ng-repeat="x in user" autocomplete='off'>
                <label>First Name</label><span class="asterisk">*</span>
                <input value="{{x.first_name}}" id="firstName" class="w3-input w3-border-0" style="text-transform: capitalize" type="text">
                <small ng-show="firstNameError" style="color: red;">First name cannot be empty!<br></small>
                <label>Last Name</label><span class="asterisk">*</span>
                <input style="text-transform: capitalize" value="{{x.last_name}}" id="lastName" class="w3-input w3-border-0" type="text">
                <small ng-show="lastNameError" style="color: red;">Last name cannot be empty!<br></small>
                <label>Email</label><span class="asterisk">*</span>
                <input value="{{x.email}}" id="email" class="w3-input w3-border-0" type="email">
                <small ng-show="emailError" style="color: red;">Email must be valid!<br></small>
                <small ng-show="usedEmailError" style="color: red;">Email is being used by another user<br></small>
                <small ng-show="editProfileSuccess" style="color: Green;">Profile update successful!<br></small>
                <input ng-click="editProfile()" class="w3-button" type="submit" value="Update" style="background: white; margin-top: 10px">
                <br>
                <h4>Password Update</h4>
                <label>Old Password</label><span class="asterisk">*</span>
                <input ng-model="oldPassword" id="oldPassword" class="w3-input w3-border-0" autocomplete="off" type="password">
                <small ng-show="oldPasswordError" style="color: red;">Old password is incorrect!<br></small>
                <label>New Password</label><span class="asterisk">*</span>
                <input ng-model="newPassword" id="newPassword" class="w3-input w3-border-0" autocomplete="off" type="password">
                <small ng-show="newPasswordError" style="color: red;">You need to follow the pattern!<br></small>
                <small>Must contain an uppercase and lowercase letter, number and min. 8 characters</small>
                <br>
                <label>Repeat New Password</label><span class="asterisk">*</span>
                <input ng-model="repeatNewPassword" id="repeatNewPassword" class="w3-input w3-border-0" autocomplete="off" type="password">
                <small ng-show="repeatNewPasswordError" style="color: red;">The passwords dont match!<br></small>
                <input ng-click="editPassword()" class="w3-button" type="submit" value="Update Password" style="background: white; margin-top: 10px">
                <small ng-show="passwordChangeSuccess" style="color: green;">Password Successfully Updated!<br></small>
            </form>
        </div>
    </div>
</div>
<div id="edit_team" class="w3-modal">
    <div ng-controller="SessionController" ng-init="teamName()" class="w3-modal-content w3-animate-top w3-card-4" style="padding: 25px; background: #f1f1f1!important; width: 40%;">
        <span onclick="document.getElementById('edit_team').style.display='none'" class="w3-button w3-display-topright" style="font-size: 20px">&times;</span>
        <div class="w3-container">
            <h2>Edit Team</h2>
            <form name="teamNameChange" ng-repeat="x in teamNames | filter : {'team_id': '<?php echo $team_id; ?>'}">
                <label>Team Name</label>
                <input id="teamName" value="{{x.team_name}}" class="w3-input w3-border-0" autocomplete="off" type="text" required>
                <small ng-show="nullTeamError" style="color: red">New team name cannot be empty<br></small>
                <small ng-show="teamLengthError" style="color: red">Team name cannot be larger than 20 characters<br></small>
                <small ng-show="changeTeamSuccess" style="color: green">Team name successfully changed!<br></small>
                <input ng-disabled="teamNameChange.$invalid" ng-click="changeTeamName(<?php echo $team_id;?>)" class="w3-button" style="background: white; margin-top: 4px" type="submit" value="Change">
            </form>
            <h3>Members</h3>
            <h4>Add Members </h4>
            <form name="insertMemberForm">
                <label>New Member Email</label>
                <input ng-model="insertMemberInput" class="w3-input w3-border-0" type="email" autocomplete="off" required>
                <select id="insertAdminStatus">
                  <option value="N" selected>Member</option>
                  <option value="Y">Admin</option>
                </select>
                <input ng-click="insertMember()" class="w3-button" type="submit" ng-disabled="insertMemberForm.$invalid" value="Add Member" style="background: white; margin-top: 4px">
            </form>
            <h4>Admins <a data-toggle="editTeamTooltip" data-placement="bottom" title="You cannot remove yourself from a team."><i class="fa fa-question-circle fw" style="font-size: 13px;"></i></a></h4>
            <div ng-repeat="x in teamMembers | filter : {'admin': 'Y'}">
                <p>{{x.member_name}} ({{x.member_email}})&nbsp;<i>admin</i>&nbsp;<i ng-hide="x.user_id == '<?php echo $user_id;?>'" ng-click="removeMember(x.team_connect_id, x.email)" style="color:red; cursor: pointer;">remove</i></p>
            </div>
            <h4>Members <a data-toggle="editTeamTooltip" data-placement="bottom" title="If you can only see a members email, that means they havent registered to OmadaHQ yet."><i class="fa fa-question-circle fw" style="font-size: 13px;"></i></a></h4>
            <div ng-repeat="x in teamMembers | filter : {'admin': 'N'}">
                <p>{{x.member_name}} ({{x.member_email}})&nbsp;<i href="" ng-click="removeMember(x.team_connect_id, x.email)" style="color:red; cursor: pointer;">remove</i></p>
            </div>
            <button class="w3-button" ng-click="getTeamEmails()" style="cursor: pointer">Switch members with admins</button>
            <form ng-show="editAdminForm" id="editAdminForm">
                <label>Old Admin</label><br>
                <select id="oldAdmin">
                    <option ng-repeat="x in teamEmails | filter : {'admin':'Y'}" value="{{x.member_email}}">{{x.member_email}}</option>
                </select><br>
                <label>New Admin</label><br>
                <select id="newAdmin">
                    <option ng-repeat="x in teamEmails | filter : {'admin':'N', 'member': 'Y'}" value="{{x.member_email}}">{{x.member_email}}</option>
                </select><br>
                <input ng-click="switchAdmins()" class="w3-button" type="submit" value="Switch Admins" style="background: white; margin-top: 4px">
            </form>
        </div>
        <br>
        <center>
            <button ng-click="deleteTeam()" class="deleteTeam"><i class="fa fa-trash fw"></i>&nbsp;Delete Team</button>
        </center>
        <style>
            .deleteTeam,
            .deleteTeam > fa-trash {
                width: 165px;
                height: 35px;
                background: red;
                color: white;
                border: none;
            }
            .deleteTeam:hover {
                background: white;
                color: red;
            }
        </style>
    </div>
</div>
<div ng-hide="'personal' == '<?php echo $team_type;?>'" style="float: right; margin-right: 15px; margin-top: 10px" ng-controller="SessionController">
    <a href="#" data-toggle="editTeamTooltip" data-placement="bottom" title="Only team admins can edit a team"><i class="fa fa-question-circle fw" style="font-size: 17px"></i></a> &nbsp;
    <button onclick="document.getElementById('edit_team').style.display='block'" ng-disabled="'N' == '<?php echo $admin_status;?>' || 'personal' == '<?php echo $team_type;?>'" style="background: white;" class="w3-button">Edit Team</button>
    <script>
    $(document).ready(function(){
        $('[data-toggle="editTeamTooltip"]').tooltip();   
    });
    </script>
</div>
<div class="team-title">
    <h3 class="team-name"><b><i class="fa fa-dashboard"></i>&nbsp;<?php echo $team_name; ?></b></h3>
</div>
<style>
    .team-title {
        margin-top: 45px;
        margin-left: 220px;
    }
    @media(max-width: 991px) {
        .team-title {
            margin-left: 20px;
        }
    }
</style>
<script for="modal">
var modal = document.getElementById('team_create');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    } 
}
</script>
<script>
    $("#showAdminForm").click(function(e) {
        e.preventDefault();
        $("#editAdminForm").removeClass("hidden");
    });
</script>


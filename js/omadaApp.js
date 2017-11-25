var app = angular.module('omadaApp', ['ngSanitize']);
app.controller('SessionController', function($scope, $http) {
    $scope.userinfo = function() {
        $http.get("php/getUser.php").success(function(data) {
            $scope.user = data;
        });
    }

    $scope.userTeams = function() {
        $http.get("php/userTeam.php").success(function(data) {
            $scope.teams = data;
        });
    }
    setInterval(function() {
        $scope.userTeams();
    }, 2000);

    $scope.createTeam = function() {
        $http.post(
            "php/createTeam.php", {
                'team_name': $scope.newTeamName
            }
        ).success(function(data) {
            if (data == "success") {
                $scope.teamCreateSuccess = true;
                $scope.newTeamMemberInsertForm = true;
            } else {
                alert(data);
                $scope.teamCreateSuccess = false;
                $scope.newTeamMemberInsertForm = false;
            }
        });
    }
    
    $scope.deleteTeam = function() {
        if (confirm("Are you sure you want to delete this team?")){
            $http.get("php/deleteTeam.php").success(function(data){
                alert(data);
                window.location.href='index.php'()
            });
        }
    }

    $scope.teamName = function() {
        $http.get("php/userTeam.php").success(function(data) {
            $scope.teamNames = data;
        });
    }

    $scope.getTeamMembers = function() {
        $http.get("php/getTeamMembers.php").success(function(data) {
            $scope.teamMembers = data;
        });
    }
    setInterval(function() {
        $scope.getTeamMembers();
    }, 2000);

    $scope.getTeamEmails = function() {
        $http.get("php/getTeamMembers.php").success(function(data) {
            $scope.teamEmails = data;
            $scope.editAdminForm = true;
        });
    }
    
    $scope.switchAdmins = function() {
        $http.post(
            "php/switchAdmins.php", {
                'new_admin_email': document.getElementById('newAdmin').value,
                'old_admin_email': document.getElementById('oldAdmin').value
            }
        ).success(function(data) {
            $scope.getTeamEmails();
            if(data == 'success1'){
                location.reload();
            } else if(data == 'success2'){
    
            } else {
                alert(data);
            }
        });
    }

    $scope.insertMember = function() {
        if ($scope.emailpattern.test($scope.insertMemberInput)) {
            $http.post(
                "php/freeAddMember.php", {
                    'email': $scope.insertMemberInput,
                    'admin': document.getElementById('insertAdminStatus').value
                }
            ).success(function(data) {
                alert(data);
                $scope.insertMemberInput = null;
            });
        } else {
            alert("email must be valid");
        }
    }

    $scope.removeMember = function(team_connect_id, email) {
        $scope.team_connect_id = team_connect_id;
        $scope.memberEmail = email;
        $http.post(
            "php/removeMember.php", {
                'team_connect_id': $scope.team_connect_id,
                'email': $scope.memberEmail
            }
        ).success(function(data) {
            $scope.getTeamMembers();
            if(data == "success"){
                $scope.getTeamMembers();
            } else {
                alert(data);
            }
        });
    }

    $scope.teamSelect = function(team_id, admin, type, team_name, plan) {
        $scope.team_id = team_id;
        $scope.admin_status = admin;
        $scope.team_type = type;
        $scope.team_name = team_name;
        $scope.plan = plan;
        $http.post(
            "php/teamSelect.php", {
                'team_id': $scope.team_id,
                'admin_status': $scope.admin_status,
                'team_type': $scope.team_type,
                'team_name': $scope.team_name,
                'plan': $scope.plan
            }
        ).success(function(data) {
            window.location.reload();
            window.location.href = "index.php";
        });
    }

    $scope.emailpattern = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/;
    $scope.editProfile = function() {
        if (document.getElementById('firstName').value == null) {
            $scope.firstNameError = true;
            $scope.lastNameError = false;
        } else if (document.getElementById('lastName').value == "") {
            $scope.lastNameError = true;
            $scope.firstNameError = false;
        } else if ($scope.emailpattern.test(document.getElementById('email').value)) {
            $http.post(
                "php/editProfile.php", {
                    'first_name': document.getElementById('firstName').value,
                    'last_name': document.getElementById('lastName').value,
                    'email': document.getElementById('email').value
                }
            ).success(function(data) {
                if (data == 'error') {
                    $scope.usedEmailError = true;
                    $scope.editProfileSuccess = false;
                    $scope.emailError = false;
                    $scope.lastNameError = false;
                    $scope.firstNameError = false;
                } else if(data == 'success') {
                    $scope.editProfileSuccess = true;
                    $scope.userinfo();
                    $scope.firstNameError = false;
                    $scope.usedEmailError = false;
                    $scope.emailError = false;
                    $scope.lastNameError = false;
                } else {
                    alert(data);
                    $scope.usedEmailError = false;
                    $scope.editProfileSuccess = false;
                    $scope.firstNameError = false;
                    $scope.emailError = false;
                    $scope.lastNameError = false;
                }
            });
        } else {
            $scope.emailError = true;
        }
    }

    $scope.pwdpattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;
    $scope.editPassword = function() {
        $http.post(
            "php/passwordCheck.php", {
                'old_password': document.getElementById('oldPassword').value,
            }
        ).success(function(data) {
            if (data == "success") {
                if ($scope.pwdpattern.test(document.getElementById('newPassword').value)) {
                    if (newPassword.value == repeatNewPassword.value) {
                        $http.post(
                            "php/passwordChange.php", {
                                'new_password': document.getElementById('newPassword').value,
                            }
                        ).success(function(data) {
                            $scope.passwordChangeSuccess = true;
                            $scope.newPasswordError = false;
                            $scope.repeatNewPasswordError = false;
                            $scope.oldPasswordError = false;
                        });
                    } else {
                        $scope.passwordChangeSuccess = false;
                        $scope.newPasswordError = false;
                        $scope.repeatNewPasswordError = true;
                        $scope.oldPasswordError = false;
                    }
                } else {
                    $scope.passwordChangeSuccess = false;
                    $scope.newPasswordError = true;
                    $scope.repeatNewPasswordError = false;
                    $scope.oldPasswordError = false;
                }
            } else {
                $scope.passwordChangeSuccess = false;
                $scope.oldPasswordError = true;
                $scope.newPasswordError = false;
                $scope.repeatNewPasswordError = false;
            }
        });
    }

    $scope.changeTeamName = function(team_id) {
        $scope.team_id = team_id;
        if (document.getElementById('teamName').value == '') {
            $scope.nullTeamError = true;
            $scope.teamLengthError = false;
            $scope.changeTeamSuccess = false;
        } else if (document.getElementById('teamName').value.length > 20) {
            $scope.teamLengthError = true;
            $scope.nullTeamError = false;
            $scope.changeTeamSuccess = false;
        } else {
            $http.post(
                "php/changeTeamName.php", {
                    'team_id': $scope.team_id,
                    'team_name': document.getElementById('teamName').value
                }
            ).success(function(data) {
                if (data == 'success') {
                    $scope.changeTeamSuccess = true;
                    $scope.nullTeamError = false;
                    $scope.teamLengthError = false;
                } else {
                    alert(data);
                }
            });
        }
    }
});
app.controller('PERTController', function($scope, $http) {
    $scope.createGoal = function(){
        $http.post(
            "php/PERT/createRecord.php", {
                'goal_name': $scope.goal_name,
                'goal_description': $scope.goal_description,
                'start_message': $scope.start_message,
                'end_time': $scope.end_time,
                'start_time': $scope.start_time,
                'type': 'goal'
            }
        ).success(function(data) {
            if (data == 'success') {
                $scope.fetchGoals();
                document.getElementById('questionaire').style.display='none';
                document.getElementById('create_task').style.display='block';
                $scope.task_create = false;
                $scope.goal_name = "";
                $scope.goal_description = "";
                $scope.start_message = "";
                $scope.end_time = "";
                $scope.start_time = "";
            } else {
               alert(data);
            }
        });
    }
    
    $scope.fetchGoals = function() {
        $http.get("php/PERT/readGoal.php").success(function(data) {
            $scope.goals = data;
        });
    }
    
    $scope.selectGoal =  function(record_id){
        $scope.record_id = record_id;
        $http.post(
            "php/PERT/selectGoal.php", {
                'record_id': $scope.record_id
            }
        ).success(function(data){
            if(data == "success"){
               window.location.href='tasks.php';
           } else {
               alert(data);
           }
        });
    }
    
    $scope.editGoal = function(record_id, name, description, start_message, start_time, end_time){
     document.getElementById('editQuestionaire').style.display='block';
        $scope.record_id = record_id;
        $scope.edit_goal_name = name;
        $scope.edit_goal_description = description;
        $scope.edit_start_message = start_message;
        $scope.edit_start_time = start_time;
        $scope.edit_end_time = end_time;
    }
    
    $scope.editGoalForm = function(record_id){
        $http.post(
            "php/PERT/updateGoal.php",{
                'goal_name': $scope.edit_goal_name,
                'goal_description': $scope.edit_goal_description,
                'start_message': $scope.edit_start_message,
                'end_time': $scope.edit_end_time,
                'start_time': $scope.edit_start_time,
                'record_id': $scope.record_id,
            }
        ).success(function(data){
            if(data == "success"){
                document.getElementById('editQuestionaire').style.display='none';
                $scope.fetchGoals();
            } else {
                alert(data);
            }
        });
    }
    
    $scope.deleteRecord = function(record_id, type){
        $scope.record_id = record_id;
        $scope.type = type;
        if (confirm("Are you sure you want to delete this? All contents will be deleted.")){
            $http.post(
                "php/PERT/deleteRecord.php", 
                {
                    'record_id': $scope.record_id,
                    'type': $scope.type
                }
            ).success(function(data){
                if (data == "success"){
                    if($scope.type == "goal"){
                        $scope.fetchGoals();
                    }
                } else {
                    alert(data);
                }
            });
        }
    }
    
    $scope.createTask = function(){
        $http.post(
            "php/PERT/createRecord.php", {
                'task_name': $scope.task_name,
                'optimistic_time': $scope.optimistic_time,
                'realistic_time': $scope.realistic_time,
                'pessimistic_time': $scope.pessimistic_time,
                'type': 'task'
            }
        ).success(function(data){
            if(data == "success"){
                $scope.task_create = true;
                $scope.sub_task_create = true;
            } else {
                alert(data);
            }
        });
    }
    
    $scope.createSubTask = function(){
        $http.post(
            "php/PERT/createRecord.php", {
                'sub_task_name': $scope.sub_task_name,
                'sub_optimistic_time': $scope.sub_optimistic_time,
                'sub_realistic_time': $scope.sub_realistic_time,
                'sub_pessimistic_time': $scope.sub_pessimistic_time,
                'type': 'sub_task'
            }
        ).success(function(data){
            if(data == "success"){
                alert("Sub task created!");
                $scope.sub_task_name = "";
                $scope.sub_optimistic_time = "";
                $scope.sub_realistic_time = "";
                $scope.sub_pessimistic_time = "";
            } else {
                alert(data);
            }
        });
    }
    
    $scope.fetchRecord = function(){
        $http.get("php/PERT/readRecord.php").success(function(data){
            $scope.records = data;
        });
    }
    
    $scope.changeSubTaskProgress = function(record_id){
        $scope.record_id = record_id;
        $http.post(
            "php/PERT/updateSubTaskProgress.php", {
                'record_id':  $scope.record_id,
            }
        ).success(function(data){
            if (data == "success"){
                $scope.fetchRecord();
            } else {
                alert(data);
            }
        });
    }
});
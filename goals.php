<style>
    .goal {
        width: 100%;
        box-shadow: 2px 2px 3px rgba(0,0,0,0.5);
        padding: 25px;
        min-height: 200px;
        background: white;
        transition: 1s;
        margin-top: 20px;
    }
    .goal:hover {
        transition: 1s;
        box-shadow: 5px 5px 5px rgba(0,0,0,0.8);
        cursor: pointer;
    }
    .plus {
        font-size: 60px;
        font-weight: 600;
        color: black;
    }
    label {
        text-transform: capitalize;
    }
    .number-input {
        width: 50%;
    }
    .col-xs-4 {
        padding-right: 0px;
        padding-left: 0px;
    }
</style>
<div class="containter" ng-init="fetchGoals()">
    <div class="row">
        <!-- ngRepeat: x in goals -->
        <div class="col-sm-3">
            <div class="goal" onclick="document.getElementById('questionaire').style.display='block'">
                <center>
                    <span class="plus"><i class="glyphicon glyphicon-plus"></i></span><br><br>
                    <span>CREATE A GOAL</span>
                </center>
            </div>
        </div>
    </div>
    <div id="questionaire" class="w3-modal" style="display: block;">
        <div class="w3-modal-content w3-animate-top w3-card-4" style="padding: 25px; background: #f1f1f1!important; width: 40%;">
            <div class="w3-container w3-light-grey"> 
                <span onclick="document.getElementById('questionaire').style.display='none'" class="w3-button w3-display-topright" style="font-size: 20px">×</span>
                <h2>Goal Create</h2>
                <form name="goal_create" class="ng-pristine ng-invalid ng-invalid-required ng-valid-maxlength">
                    <label>Goal Name<span class="asterisk">*</span>
                    </label>
                    <input ng-model="goal_name" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-maxlength" type="text" maxlength="25" required=""> 
                    <label>Description<span class="asterisk">*</span>
                    </label>
                    <input ng-model="goal_description" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required" type="text" required=""> 
                    <label>What Can You Do To Start?<span class="asterisk">*</span>
                    </label>
                    <input ng-model="start_message" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required" type="text" required=""> 
                    <label>Start Date<span class="asterisk">*</span>
                    </label>
                    <input ng-model="start_time" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required" type="date" required="">
                    <label>Deadline<span class="asterisk">*</span>
                    </label>
                    <input ng-model="end_time" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required" type="date" required="">             
                    <input type="submit" ng-disabled="goal_create.$invalid" ng-click="createGoal()" class="w3-button" value="Create" style="background: white; margin-top: 10px; width: 85px" disabled="disabled">
                </form>
            </div>
        </div>
    </div>
    <div id="editQuestionaire" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4" style="padding: 25px; background: #f1f1f1!important; width: 40%;">
            <div class="w3-container w3-light-grey"> 
                <span onclick="document.getElementById('editQuestionaire').style.display='none'" class="w3-button w3-display-topright" style="font-size: 20px">×</span>
                <h2>Goal Create</h2>
                <form name="edit_goal_create" class="ng-pristine ng-invalid ng-invalid-required ng-valid-maxlength">
                    <label>Goal Name<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_goal_name" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-maxlength" type="text" maxlength="25" required=""> 
                    <label>Description<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_goal_description" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required" type="text" required=""> 
                    <label>What Can You Do To Start?<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_start_message" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required" type="text" required=""> 
                    <label>Start Date<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_start_time" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required" type="date" required="">
                    <label>Deadline<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_end_time" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required" type="date" required="">             
                    <input type="submit" ng-disabled="edit_goal_create.$invalid" ng-click="editGoalForm()" class="w3-button" value="Edit" style="background: white; margin-top: 10px; width: 85px" disabled="disabled">
                </form>
            </div>
        </div>
    </div>
    <div id="create_task" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4" style="padding: 25px; background: #f1f1f1!important; width: 40%;">
            <div class="w3-container w3-light-grey"> 
                <span onclick="document.getElementById('create_task').style.display='none'" class="w3-button w3-display-topright" style="font-size: 20px">×</span>
                <h2>Task Create</h2>
                <form name="task_create" ng-hide="task_create" class="ng-pristine ng-invalid ng-invalid-required ng-valid-maxlength ng-valid-min ng-hide">
                    <label>Task #1<span class="asterisk">*</span>
                    </label>
                    <input ng-model="task_name" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-maxlength" type="text" maxlength="40" required="">
                    <div class="col-xs-4">
                        <label>Optimistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="optimistic_time" min="0" type="number" class="w3-input w3-border-0 number-input ng-pristine ng-untouched ng-valid-min ng-invalid ng-invalid-required" required=""><small>Days</small>
                    </div>
                    <div class="col-xs-4">
                        <label>Realistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="realistic_time" min="0" type="number" class="w3-input w3-border-0 number-input ng-pristine ng-untouched ng-valid-min ng-invalid ng-invalid-required" required=""><small>Days</small>
                    </div>
                    <div class="col-xs-4">
                        <label>Pessimistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="pessimistic_time" min="0" type="number" class="w3-input w3-border-0 number-input ng-pristine ng-untouched ng-valid-min ng-invalid ng-invalid-required" required=""><small>Days</small>
                    </div><br>
                    <input type="submit" ng-disabled="task_create.$invalid" ng-click="createTask()" class="w3-button" value="Create" style="background: white; margin-top: 10px; width: 85px" disabled="disabled">
                </form>
                <form name="sub_task_create" ng-hide="sub_task_create" class="ng-pristine ng-invalid ng-invalid-required ng-valid-maxlength ng-valid-min ng-hide">
                    <label>Sub Tasks for Task#1<span class="asterisk">*</span>
                    </label>
                    <input ng-model="sub_task_name" class="w3-input w3-border-0 ng-pristine ng-untouched ng-invalid ng-invalid-required ng-valid-maxlength" type="text" maxlength="40" required="">         
                    <div class="col-xs-4">
                        <label>Optimistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="sub_optimistic_time" type="number" min="0" class="w3-input w3-border-0 number-input ng-pristine ng-untouched ng-valid-min ng-invalid ng-invalid-required" required=""><small>Days</small>
                    </div>
                    <div class="col-xs-4">
                        <label>Realistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="sub_realistic_time" min="0" type="number" class="w3-input w3-border-0 number-input ng-pristine ng-untouched ng-valid-min ng-invalid ng-invalid-required" required=""><small>Days</small>
                    </div>
                    <div class="col-xs-4">
                        <label>Pessimistic Time<span class="asterisk">*</span>
                        </label>
                        <input min="0" ng-model="sub_pessimistic_time" type="number" class="w3-input w3-border-0 number-input ng-pristine ng-untouched ng-valid-min ng-invalid ng-invalid-required" required=""><small>Days</small>
                    </div><br>                    
                    <input type="submit" ng-disabled="sub_task_create.$invalid" ng-click="createSubTask()" class="w3-button" value="Add" style="background: white; margin-top: 10px; width: 85px" disabled="disabled"><br>
                    <a href="tasks.php"><input type="button" value="Done" style="background: white; margin-top: 10px; width: 85px" class="w3-button"></a>
                </form>
            </div>
        </div>
    </div>
</div>                        
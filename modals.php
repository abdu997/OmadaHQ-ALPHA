    <div id="questionaire" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4" style="padding: 25px; background: #f1f1f1!important; width: 40%;">
            <div class="w3-container w3-light-grey"> 
                <span onclick="document.getElementById('questionaire').style.display='none'" class="w3-button w3-display-topright" style="font-size: 20px">×</span>
                <h2>Goal Create</h2>
                <form name="goal_create">
                    <label>Goal Name<span class="asterisk">*</span>
                    </label>
                    <input ng-model="goal_name" class="w3-input w3-border-0" type="text" maxlength="25" required> 
                    <label>Description<span class="asterisk">*</span>
                    </label>
                    <input ng-model="goal_description" class="w3-input w3-border-0" type="text" required> 
                    <label>What Can You Do To Start?<span class="asterisk">*</span>
                    </label>
                    <input ng-model="start_message" class="w3-input w3-border-0" type="text" required> 
                    <label>Start Date<span class="asterisk">*</span>
                    </label>
                    <input ng-model="start_time" class="w3-input w3-border-0" type="date" required>
                    <label>Deadline<span class="asterisk">*</span>
                    </label>
                    <input ng-model="end_time" class="w3-input w3-border-0" type="date" required>             
                    <input type="submit" ng-disabled="goal_create.$invalid" ng-click="createGoal()" class="w3-button" value="Create" style="background: white; margin-top: 10px; width: 85px">
                </form>
            </div>
        </div>
    </div>
    <div id="editQuestionaire" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4" style="padding: 25px; background: #f1f1f1!important; width: 40%;">
            <div class="w3-container w3-light-grey"> 
                <span onclick="document.getElementById('editQuestionaire').style.display='none'" class="w3-button w3-display-topright" style="font-size: 20px">×</span>
                <h2>Goal Create</h2>
                <form name="edit_goal_create">
                    <label>Goal Name<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_goal_name" class="w3-input w3-border-0" type="text" maxlength="25" required> 
                    <label>Description<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_goal_description" class="w3-input w3-border-0" type="text" required> 
                    <label>What Can You Do To Start?<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_start_message" class="w3-input w3-border-0" type="text" required> 
                    <label>Start Date<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_start_time" class="w3-input w3-border-0" type="date" required>
                    <label>Deadline<span class="asterisk">*</span>
                    </label>
                    <input ng-model="edit_end_time" class="w3-input w3-border-0" type="date" required>             
                    <input type="submit" ng-disabled="edit_goal_create.$invalid" ng-click="editGoalForm()" class="w3-button" value="Edit" style="background: white; margin-top: 10px; width: 85px">
                </form>
            </div>
        </div>
    </div>
    <div id="create_task" class="w3-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4" style="padding: 25px; background: #f1f1f1!important; width: 40%;">
            <div class="w3-container w3-light-grey"> 
                <span onclick="document.getElementById('create_task').style.display='none'" class="w3-button w3-display-topright" style="font-size: 20px">×</span>
                <h2>Task Create</h2>
                <form name="task_create2" ng-hide="task_create">
                    <label>Task<span class="asterisk">*</span>
                    </label>
                    <input ng-model="task_name" class="w3-input w3-border-0" type="text" maxlength="40" required>
                    <div class="col-xs-4">
                        <label>Optimistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="optimistic_time" min="1" type="number" class="w3-input w3-border-0 number-input" required><small>Days</small>
                    </div>
                    <div class="col-xs-4">
                        <label>Realistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="realistic_time" min="1" type="number" class="w3-input w3-border-0 number-input" required><small>Days</small>
                    </div>
                    <div class="col-xs-4">
                        <label>Pessimistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="pessimistic_time" min="1" type="number" class="w3-input w3-border-0 number-input" required><small>Days</small>
                    </div><br>
                    <input type="submit" ng-disabled="task_create2.$invalid" ng-click="createTask()" class="w3-button" value="Create" style="background: white; margin-top: 10px; width: 85px">
                </form>
                <form name="sub_task_create2" ng-show="sub_task_create">
                    <label>Sub Tasks<span class="asterisk">*</span>
                    </label>
                    <input ng-model="sub_task_name" class="w3-input w3-border-0" type="text" maxlength="40" required>         
                    <div class="col-xs-4">
                        <label>Optimistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="sub_optimistic_time" type="number" min="1" class="w3-input w3-border-0 number-input" required><small>Days</small>
                    </div>
                    <div class="col-xs-4">
                        <label>Realistic Time<span class="asterisk">*</span>
                        </label>
                        <input ng-model="sub_realistic_time" min="1" type="number" class="w3-input w3-border-0 number-input" required><small>Days</small>
                    </div>
                    <div class="col-xs-4">
                        <label>Pessimistic Time<span class="asterisk">*</span>
                        </label>
                        <input min="1" ng-model="sub_pessimistic_time" type="number" class="w3-input w3-border-0 number-input" required><small>Days</small>
                    </div><br>                    
                    <input type="submit" ng-disabled="sub_task_create2.$invalid" ng-click="createSubTask()" class="w3-button" value="Add" style="background: white; margin-top: 10px; width: 85px"><br>
                    <a href="tasks.php"><input type="button" value="Done" style="background: white; margin-top: 10px; width: 85px" class="w3-button"></a>
                </form>
            </div>
        </div>
    </div>
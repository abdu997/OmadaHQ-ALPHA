<style>
    .col-xs-4 {
        padding-right: 0px;
        padding-left: 0px;
    }
    .number-input {
        width: 50%;
    }
    .goal {
        background: white;
        box-shadow: 0 4px 10px 0 rgba(0,0,0,0.2), 0 4px 20px 0 rgba(0,0,0,0.19);
        margin-bottom: 15px;
    }
    .tasks {
        padding: 25px;
        padding-bottom: 10px;
    }
    .task {

    }
    .add {
        float: left;
        margin: 10px;
        font-size: 20px; 
        cursor: pointer;
    }
    .pencil, .trash {
        float: bottom;
        margin: 0px 10px 10px 10px;
        font-size: 15px; 
        cursor: pointer;  
    }
    .trash {
        color: red;
    }
    .check {
        color: green;
        opacity: 0.3;
        float: right;
        margin: 10px;
        font-size: 20px; 
        cursor: pointer;
    }
    .check:hover {
        opacity: 0.5;
    }
    .checked {
        opacity: 0.8;
    }
    .checked:hover {
        opacity: 1;
    }
</style>
<?php include "modals.php";?>
<div>
    <div style="margin-bottom: 20px">
        <center>
            <button onclick="window.location.href = 'index.php'" style="background: white;" class="w3-button">Back To Goals</button>
            <button onclick="document.getElementById('create_task').style.display='block'" style="background: white;" class="w3-button">Add Task</button>
        </center>
    </div>
    <div id="column_view" ng-init="fetchRecord()">
        <center>
            <div ng-repeat="x in records | filter: {'type': 'goal'}">
                <h2>{{x.name}}</h2>
                <div ng-click="editGoal(x.record_id, x.name, x.description, x.start_message, x.start_time, x.end_time)" style="cursor: pointer;"><i class="fa fa-pencil-square-o fw"></i></div>
                <h5>{{x.description}}</h5>
            </div>
            <div class="col-sm-3">
                <h2 style="color: transparent">Start</h2>
                <div class="goal w3-light-green" ng-repeat="x in records | filter: {'type': 'goal'}">
                    <div class="tasks">
                        <center  style="color:white">
                            <h3>Start</h3>
                            <p>{{x.start_message}}</p>
                            <p><i>{{x.start_time}}</i></p>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <h2>Sub Tasks</h2>
                <div class="goal sub-task" style="border-left: 8px solid #{{x.color}};" ng-repeat="x in records | filter: {'type': 'sub_task'}:true | orderBy : 'task_id'">
                    <i ng-click="changeSubTaskProgress(x.record_id)" ng-class="{checked: x.progress == 'complete'}" class="fa fa-check fw check"></i>
                    <div class="tasks">
                        <center>
                            <h4>{{x.name}}</h4>
                            <p>Duration:<i>&nbsp;{{x.expected_time}} days</i></p>
                        </center>
                    </div>
                    <i class="fa fa-pencil-square-o pencil fw" ng-click="updateSubTask(x.record_id, x.name, x.optimistic_time, x.realistic_time, x.pessimistic_time)"></i>
                    <i class="fa fa-trash fw trash" ng-click="deleteRecord(x.record_id, x.type)"></i>
                </div>
            </div>
            <div class="col-sm-3">
                <h2>Tasks</h2>
                <div class="goal task" style="border-left: 8px solid #{{x.color}};" ng-repeat="x in records | filter: {'type': 'task'}:true | orderBy : 'record_id'">
                    <a href="#" data-toggle="addSub" data-placement="bottom" title="Create a Sub Task"><i ng-click="selectTask(x.record_id)" class="fa fa-plus fw add"></i></a>
                    <i ng-click="changeSubTaskProgress(x.record_id)" ng-class="{checked: x.progress == 'complete'}" class="fa fa-check fw check"></i>
                    <div class="tasks">
                        <center>
                            <h4>{{x.name}}</h4>
                            <p>Duration:<i>&nbsp;{{x.expected_time}} days</i><br>
                            Cumulative Time:<i>&nbsp;{{x.cumulative_time}} days</i></p>
                         </center>
                    </div>
                    <i class="fa fa-pencil-square-o pencil fw" ng-click="updateTask(x.record_id, x.name, x.optimistic_time, x.realistic_time, x.pessimistic_time)"></i>
                    <i class="fa fa-trash fw trash" ng-click="deleteRecord(x.record_id, x.type)"></i>
                </div>
            </div>
            <div class="col-sm-3">
                <h2 style="color: transparent">End</h2>
                <div class="goal" style="background: #2196F3!important;" ng-repeat="x in records | filter: {'type': 'goal'}">
                    <div class="tasks">
                        <center  style="color:white">
                            <h3>Goal</h3>
                            <p>{{x.name}}</p>
                            <p>Deadline <i>{{x.end_time}}</i></p>
                            <p>Estimate <i>{{x.estimate_end}}</i></p>
                        </center>
                    </div>
                </div>
            </div>
        </center>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('[data-toggle="addSub"]').tooltip();   
    });
</script>
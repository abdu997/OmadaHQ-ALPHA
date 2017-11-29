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
</style>
<div class="containter" ng-init="fetchGoals()">
    <div class="row">
        <div class="col-sm-3" ng-repeat="x in goals">
            <div>
                <div ng-click="editGoal(x.record_id, x.name, x.description, x.start_message, x.start_time, x.end_time)" style="float: left; margin: 10px; cursor: pointer;"><i class="fa fa-pencil-square-o fw"></i></div>
                <div ng-click="deleteRecord(x.record_id, x.type)" style="float: right; color: red; margin: 10px; cursor: pointer;"><i class="fa fa-trash fw"></i></div>
                <center ng-click="selectGoal(x.record_id)" class="goal">
                    <h2 style="margin-bottom: 40px; text-transform: capitalize;">{{x.name}}</h2>
                    <p style="float: left; text-transform: capitalize;">By {{x.user}}</p>
                    <p style="float: right">{{x.end_time}}</p>
                </center>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="goal" onclick="document.getElementById('questionaire').style.display='block'">
                <center>
                    <span class="plus"><i class="glyphicon glyphicon-plus"></i></span><br><br>
                    <span>CREATE A GOAL</span>
                </center>
            </div>
        </div>
    </div>
    <?php include 'modals.php';?>
</div>                        
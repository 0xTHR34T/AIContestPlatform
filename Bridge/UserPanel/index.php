<?php

require("../../Core/bTerminal/main.php");

use Core\bTerminal\Main\Main as main;
use Core\bTerminal\Main\Contest as contest;
//use Core\bTerminal\Supports;

$obj = new main;
$obj2 = new contest;

$valid = $obj -> validate($_COOKIE["AICP_UserName"], $_COOKIE["AICP_PassWord"]);

if(!isset($_COOKIE["AICP_UserName"]) || !$valid) {
  echo "Redirecting...";
  header("Location: ../");
}

?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width , initial-scale=1">
    <link rel = "stylesheet" href = "../bootstrap-3.3.5/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "css/main.css">
    <script src = "js/jquery-1.11.3.min.js"></script>
    <script src = "js/jquery.color-2.1.2.min.js"></script>
    <script src = "../bootstrap-3.3.5/js/bootstrap.min.js"></script>
    <script src = "js/angular.min.js"></script>
    <script src = "js/jMain.js"></script>
    <script src = "js/alt.js"></script>
    <script src = "js/userconn.js"></script>
    <title><?php echo $_COOKIE["AICP_UserName"]. " > " ."AICP Panel" ?></title>
</head>

<body ng-app = "rootApp">
    <div id = "header" class = "container-fluid">
        <p>AICP Panel</p>
    </div>

    <div class = "usrtb">
        <a data-toggle = "tooltip" data-placement = "right" title = "Upload your agents!">
        <div name = "upload" class = "sub-usrtb">
            <p><span class = "glyphicon glyphicon-cloud-upload"></span><br>Upload</p>
        </div>
        </a>

        <a data-toggle = "tooltip" data-placement = "right" title = "Join a contest!">
        <div name = "contest" class = "sub-usrtb">
            <p><span class = "glyphicon glyphicon-flag"></span><br>Contests</p>
        </div>
        </a>

        <a data-toggle = "tooltip" data-placement = "right" title = "Observe your agents!">
        <div name = "monitor" class = "sub-usrtb">
            <p><span class = "glyphicon glyphicon-eye-open"></span><br>Monitor</p>
        </div>
        </a>

        <a data-toggle = "tooltip" data-placement = "right" title = "See ranking!">
        <div name = "ranking" class = "sub-usrtb">
            <p><span class = "glyphicon glyphicon-list"></span><br>Ranks</p>
        </div>
        </a>
    </div>

    <div class = "usrtb2">
        <div class = "sub-usrtb2">
            <p><span class = "glyphicon glyphicon-user"></span><br>Profile</p>
        </div>

        <div class = "sub-usrtb2">
            <p><span class = "glyphicon glyphicon-wrench"></span><br>Settings</p>
        </div>

        <div class = "sub-usrtb2">
            <p><span class = "glyphicon glyphicon-globe"></span><br>Teams</p>
        </div>

      <a href = "../logout.php">
        <div class = "sub-usrtb2">
            <p><span class = "glyphicon glyphicon-log-out"></span><br>Logout</p>
        </div>
      </a>
    </div>

    <div class = "container">
        <div class = "agent-upload">
          <div class = "panel panel-default">
            <div class = "panel-heading">
              <p>
                <span class = "glyphicon glyphicon-cloud-upload"></span>&nbsp;&nbsp;Upload
              </p>
            </div>
            <div class = "panel-body">
              <div id = "uploadAlert" class = "">
                <span class = ""></span>&nbsp;
                <strong></strong>
              </div>
              <p>
                <span class = "glyphicon glyphicon-chevron-right"></span>&nbsp;
                Just upload your source code, then it will be queued for a run!
              </p>
              <div class = "sub-agent-upload">
                <input id = "uploadBar" placeholder = "Choose a file" disabled = "disabled">
                <div class = "btn btn-default btn-md">
                  <p>Browse</p>
                  <input id = "uploadBtn" type = "file" name = "file" onchange = "changeContent('uploadBar', this.value),checkExtension('uploadBtn')">
                </div>
                <p id = "lang-indicator">
                  Language:&nbsp;<span id = "sub-lang-indicator"></span>
                </p>
              </div>
            </div>
            <div class = "panel-footer">
              <div id = "uploadGoBtn" class = "btn btn-success btn-lg btn-block" onclick = "uploadProcess()"><span class = "glyphicon glyphicon-send"></span>&nbsp;&nbsp;GO!</div>
            </div>
          </div>
        </div>
        <div class = "agent-contest" ng-app = "contest-app" ng-controller = "contest-ctrl">
          <!-- Begining of the MODEL -->
          <div id = "joinModal" class = "modal fade" role = "dialog">
            <div class = "modal-dialog">
              <div class = "modal-content">
                <div class = "modal-header">
                  <button class = "close" data-dismiss = "modal">&times;</button>
                  <h4 class = "modal-title"><span class = "glyphicon glyphicon-leaf"></span>&nbsp;Select one of your agents:</h4>
                </div>

                <div class = "modal-body">
                  <ul class = "nav nav-pills nav-stacked">
                    <?php
                      echo $obj2 -> fetchAgents();
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- End of the MODEL -->

          <div class = "panel panel-default">
            <div class = "panel-heading">
              <p>
                <span class = "glyphicon glyphicon-flag"></span>&nbsp;&nbsp;Contests
              </p>
            </div>
            <div class = "panel-body">
              <p>
                <span class = "glyphicon glyphicon-chevron-right"></span>&nbsp;
                Create a contest or join one of them!
              </p>
              <div class = "contest-create">
                <div class = "dropdown">
                  <button id = "contestCreateButton" class = "btn btn-default dropdown-toggle" data-toggle ="dropdown">
                    2
                    <span class = "caret"></span>
                  </button>
                  <ul class = "dropdown-menu">
                    <li class = "dropdown-header">Number of players</li>
                    <li><a>2</a></li>
                    <li><a>3</a></li>
                    <li><a>4</a></li>
                    <li><a>5</a></li>
                    <li><a>6</a></li>
                  </ul>
                </div>
                <button id = "contestCreateBtn" class = "btn btn-primary btn-md" name = "2" onclick = "contestProcessInit(this, 'create')" data-toggle = 'modal' data-target = '#joinModal'>Create</button>
              </div>
              <div class = "contest-join">
                <table id = "table-contest" class = "table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width = "10%">Capacity</th>
                      <th width = "50%">Players</th>
                      <th width = "30%">Status</th>
                      <th width = "10%">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class = "agent-monitor" ng-app = "monitor-app" ng-controller = "monitor-ctrl">
          <div class = "panel panel-default">
            <div class = "panel-heading">
              <p>
                <span class = "glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;Monitor
              </p>
            </div>
            <div class = "panel-body">
              <p>
                <span class = "glyphicon glyphicon-chevron-right"></span>&nbsp;
                Evaluate your agents; Edit or delete them!
              </p><br>
              <div>
                <table id = "table-monitor" class = "table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width = "10%">Id</th>
                      <th width = "25%">Agents</th>
                      <th width = "45%">Score</th>
                      <th width = "25%">Action</th>
                      <th width = "20%">Initial test</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class = "agent-ranking" ng-app = "ranking-app" ng-controller = "ranking-ctrl">
          <div class = "panel panel-default">
            <div class = "panel-heading">
              <p>
                <span class = "glyphicon glyphicon-list"></span>&nbsp;&nbsp;Ranking
              </p>
            </div>
            <div class = "panel-body">
              <p>
                <span class = "glyphicon glyphicon-chevron-right"></span>&nbsp;
                Ranking:
              </p><br>
              <div>
                <table id = "table-ranking" class = "table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width = "10%">Rank</th>
                      <th width = "45%">Name</th>
                      <th width = "25%">Team</th>
                      <th width = "20%">Score</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
</body>
</html>

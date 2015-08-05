<?php

require("../../Core/terminal.php");
if(!isset($_COOKIE["UserName"]) || !validate($_COOKIE["UserName"], $_COOKIE["PassWord"])) {
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
    <script src = "../bootstrap-3.3.5/js/bootstrap.min.js"></script>
    <script src = "js/jMain.js"></script>
    <script src = "js/alt.js"></script>
    <script src = "js/jquery.color-2.1.2.min.js"></script>
    <script src = "js/angular.min.js"></script>
    <title><?php echo $_COOKIE["UserName"]. ">" ."AICP Panel" ?></title>
</head>

<body>
    <div id = "header" class = "container-fluid">
        <p>AICP Panel</p>
    </div>

    <div class = "usrtb">
        <a data-toggle = "tooltip" data-placement = "right" title = "Upload your agents!">
        <div class = "sub-usrtb">
            <p><span class = "glyphicon glyphicon-cloud-upload"></span><br>Upload</p>
        </div>
        </a>

        <a data-toggle = "tooltip" data-placement = "right" title = "Join a contest!">
        <div class = "sub-usrtb">
            <p><span class = "glyphicon glyphicon-flag"></span><br>Contests</p>
        </div>
        </a>

        <a data-toggle = "tooltip" data-placement = "right" title = "Observe your gamelogs!">
        <div class = "sub-usrtb">
            <p><span class = "glyphicon glyphicon-eye-open"></span><br>Monitor</p>
        </div>
        </a>

        <a data-toggle = "tooltip" data-placement = "right" title = "See ranking!">
        <div class = "sub-usrtb">
            <p><span class = "glyphicon glyphicon-list"></span><br>Ranks</p>
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
              <p>
                <span class = "glyphicon glyphicon-chevron-right"></span>&nbsp;
                Just upload your source code, then it will be queued for a run!
              </p>
              <div class = "sub-agent-upload">
                <input id = "uploadBar" placeholder = "Choose a file" disabled = "disabled">
                <div class = "btn btn-default btn-md">
                  <p>Browse</p>
                  <input id = "uploadBtn" type = "file" onchange = "changeContent('uploadBar', this.value),checkExtension('uploadBtn')">
                </div>
                <p id = "lang-indicator">
                  Language:&nbsp;<span id = "sub-lang-indicator"></span>
                </p>
              </div>
            </div>
            <div class = "panel-footer">
              <div class = "btn btn-success btn-lg btn-block">GO!</div>
            </div>
          </div>
        </div>
        <div class = "agent-contest">
          <div class = "panel panel-default">
            <div class = "panel-heading">
              <p>
                <span class = "glyphicon glyphicon-flag"></span>&nbsp;&nbsp;Contest
              </p>
            </div>
            <div class = "panel-body">
              <p>
                <span class = "glyphicon glyphicon-chevron-right"></span>&nbsp;
                Sample
              </p>
            </div>
          </div>
        </div>
        <div class = "agent-monitor">
          <div class = "panel panel-default">
            <div class = "panel-heading">
              <p>
                <span class = "glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;Monitor
              </p>
            </div>
            <div class = "panel-body">
              <p>
                <span class = "glyphicon glyphicon-chevron-right"></span>&nbsp;
                Sample
              </p>
            </div>
          </div>
        </div>
        <div class = "agent-ranking">
          <div class = "panel panel-default">
            <div class = "panel-heading">
              <p>
                <span class = "glyphicon glyphicon-list"></span>&nbsp;&nbsp;Ranking
              </p>
            </div>
            <div class = "panel-body">
              <p>
                <span class = "glyphicon glyphicon-chevron-right"></span>&nbsp;
                Sample
              </p>
            </div>
          </div>
        </div>
    </div>
</body>
</html>

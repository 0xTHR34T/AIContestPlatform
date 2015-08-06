<?php

/*require("includes/config.php");
if (!defined('DB_NAME')) {
    header("Location: install.php");
} elseif (isset($_COOKIE["UserName"])) {
  header("Location: UserPanel/");
}*/
include("../Core/bTerminal/main.php");
use Core\bTerminal\Main\Main as main;
$c = new main;
$c -> validate('a\^"', '1234');
?>
<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width , initial-scale=1">
    <link rel = "stylesheet" href = "bootstrap-3.3.5/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "css/index.css">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src = "bootstrap-3.3.5/js/bootstrap.min.js"></script>
    <script src = "js/index.js"></script>
    <script src = "js/angular.min.js"></script>

    </script>
    <title>.::&nbsp;Bridge&nbsp;::.</title>
</head>

<body>
    <div id = "header" class = "container-fluid">
        <p>AICP Bridge Gateway</p>
    </div>

    <div class = "container">
        <div class = "wrapper">
            <div id = "w-header">
                <h3 id = "w-header-login">
                    <span class = "glyphicon glyphicon-lock"></span>&nbsp;Login
                </h3>
                <h3 id = "w-header-reg">
                    <span class = "glyphicon glyphicon-pencil"></span>&nbsp;Register
                </h3>
                <h3 id = "w-header-fp">
                    <span class = "glyphicon glyphicon-refresh"></span>&nbsp;Password Recovery
                </h3>
            </div>

            <div id = "w-body">
                <form id = "login-form" ng-app="app-gateway" ng-controller="ctrl-gateway">
                    <div class = "form-group">
                        <label><span class = "glyphicon glyphicon-user"></span>&nbsp;Username</label>
                        <input name = "userName" class = "form-control" type = "text">
                    </div>

                    <div class = "form-group">
                        <label><span class = "glyphicon glyphicon-eye-open"></span>&nbsp;Password</label>
                        <input name = "Password" class = "form-control" type = "password">
                    </div>

                    <div class="checkbox">
                        <label><input name = "checkBox" type="checkbox" value="" checked>Remember me</label>
                    </div>

                    <button class = "btn btn-success btn-lg btn-block"><span class = "glyphicon glyphicon-ok"></span></button>
                </form>

                <form id = "reg-form">
                    <div class = "form-group">
                        <label><span class = "glyphicon glyphicon-user"></span>&nbsp;Username</label>
                        <input class = "form-control" type = "text">
                    </div>

                    <div class = "form-group">
                        <label><span class = "glyphicon glyphicon-envelope"></span>&nbsp;Email</label>
                        <input class = "form-control" type = "text">
                    </div>

                    <div class = "form-group">
                        <label><span class = "glyphicon glyphicon-eye-open"></span>&nbsp;Password</label>
                        <input class = "form-control" type = "password">
                    </div>

                    <div class = "form-group">
                        <label>Re-enter password</label>
                        <input class = "form-control" type = "text">
                    </div>

                    <button class = "btn btn-success btn-lg btn-block"><span class = "glyphicon glyphicon-ok"></span></button>
                    <img id = "backIcon" class = "pull-left" src = "images/arrow left.png" data-toggle="tooltip" data-placement="top" title="Back">
                </form>

                <form id = "fp-form">
                    <div class = "form-group">
                        <label><span class = "glyphicon glyphicon-envelope"></span>&nbsp;Enter the email that you've registered with</label>
                        <input class = "form-control" type = "text">
                    </div>

                    <button class = "btn btn-success btn-lg btn-block"><span class = "glyphicon glyphicon-ok"></span></button>
                    <img id = "backIcon2" class = "pull-left" src = "images/arrow left.png" data-toggle="tooltip" data-placement="top" title="Back">
                </form>
            </div>

            <div id = "w-footer">
                <button id = "reg" class = "btn btn-info pull-left"><span class = "glyphicon glyphicon-pencil"></span>&nbsp;Register</button>
                <!--<p class = "pull-right">Forget <a href = "#">Password</a>?</p>-->
                <button id = "fp" class = "btn btn-danger pull-right"><span class = "glyphicon glyphicon-refresh"></span>&nbsp;Forgot Password?</button>
            </div>
        </div>
    </div>
</body>

</html>

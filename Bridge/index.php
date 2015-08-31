<?php

require("includes/config.php");
if (!defined('DB_NAME')) {
    header("Location: install.php");
} elseif (isset($_COOKIE["AICP_UserName"])) {
  header("Location: UserPanel/");
}

?>
<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width , initial-scale=1">
    <link rel = "stylesheet" href = "bootstrap-3.3.5/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "css/index.css">
    <script src = "//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src = "bootstrap-3.3.5/js/bootstrap.min.js"></script>
    <script src = "js/angular.min.js"></script>
    <script src = "js/index.js"></script>
    <script src = "js/connection.js"></script>
    <script src = "js/sha1.js"></script>
    <script src = "UserPanel/js/alt.js"></script>

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

            <div id = "w-body" ng-app = "app-gateway">
              <div id = "status" class = "alert alert-danger"></div>
                <form id = "login-form" ng-controller = "gateway-login">
                    <div class = "form-group">
                        <label><span class = "glyphicon glyphicon-user"></span>&nbsp;Username</label>
                        <input ng-model = "userName" class = "form-control" type = "text">
                    </div>

                    <div class = "form-group">
                        <label><span class = "glyphicon glyphicon-eye-open"></span>&nbsp;Password</label>
                        <input ng-model = "Pass" class = "form-control" type = "password">
                    </div>

                    <div class="checkbox">
                        <label><input ng-model = "checkBox" type="checkbox" value="remember" checked>Remember me</label>
                    </div>

                    <button ng-click = "Login()" class = "btn btn-success btn-lg btn-block"><span class = "glyphicon glyphicon-ok"></span></button>
                </form>

                <form id = "reg-form" ng-controller = "gateway-register">
                    <div class = "form-group" id = "username-fg">
                        <label><span class = "glyphicon glyphicon-user"></span>&nbsp;Username</label>
                        <input ng-model = "userName" ng-change = "userCheck()" class = "form-control" type = "text">
                        <span class = ""></span>
                    </div>

                    <div class = "form-group" id = "email-fg">
                        <label><span class = "glyphicon glyphicon-envelope"></span>&nbsp;Email</label>
                        <input ng-model = "Email" ng-change = "emailCheck()" class = "form-control">
                        <span class = ""></span>
                    </div>

                    <div class = "form-group" id = "password-fg">
                        <label><span class = "glyphicon glyphicon-eye-open"></span>&nbsp;Password</label>
                        <input ng-model = "Pass" ng-change = "passCheck()" class = "form-control" type = "password">
                        <span class = ""></span>
                    </div>

                    <div class = "form-group" id = "re-password-fg">
                        <label>Re-enter password</label>
                        <input ng-model = "Pass2" ng-change = "passCheck()" class = "form-control" type = "password">
                        <span class = ""></span>
                    </div>

                    <button ng-click = "Register()" class = "btn btn-success btn-lg btn-block"><span class = "glyphicon glyphicon-ok"></span></button>
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

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "utf-8">
    <meta name = "viewport" content = "width=device-width , initial-scale=1">
    <link rel = "stylesheet" href = "../bootstrap-3.3.5/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "css/main.css">
    <script src = "js/jquery-1.11.3.min.js"></script>
    <script src = "../bootstrap-3.3.5/js/bootstrap.min.js"></script>
    <script src = "js/main.js"></script>
    <script src = "js/jquery.color-2.1.2.min.js"></script>
    <title><?php echo "Usr - " . "AICP Panel" ?></title>
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

        </div>
    </div>
</body>
</html>

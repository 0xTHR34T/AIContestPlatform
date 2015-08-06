<?php
/*
 * NOTICE: Input filtering is NOT applied!
*/

if(isset($_GET["HOST"]) && isset($_GET["NAME"]) && isset($_GET["USERNAME"]) && isset($_GET["PASSWORD"])) {
    $f = fopen("includes/config.php" , "w");
    $HOST = $_GET["HOST"];
    $NAME = $_GET["NAME"];
    $USERNAME = $_GET["USERNAME"];
    $PASSWORD = $_GET["PASSWORD"];
    $buffer = "
    <?php
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        define(DB_HOST , '". $HOST ."');
        define(DB_NAME , '". $NAME ."');
        define(DB_USERNAME , '". $USERNAME ."');
        define(DB_PASSWORD , '". $PASSWORD ."');
    ?>
    ";
    $table_users = "CREATE TABLE Users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50),
    score INT(6)
    )";
    $table_games = "CREATE TABLE Games (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    file_name varchar(255),
    result varchar(255)
    )";
    $table_queue = "CREATE TABLE Queue (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    players varchar(255),
    status varchar(50)
    )";

    fwrite($f , $buffer) or die("Couldn't write the content: config.php");
    echo "Config.php setup successfully!<br>";
    fclose($f);

    $conn = mysqli_connect($HOST , $USERNAME , $PASSWORD) or die("Couldn't connect to the server.Closing..");
    echo "Connected to the server.<br>";
    mysqli_query($conn , "CREATE DATABASE ". $NAME);
    echo "DB Created!<br>";
    mysqli_query($conn , "ALTER DATABASE ". $NAME ." CHARACTER SET utf8 COLLATE utf8_general_ci;");
    echo "CHARSET: utf-8 <br>";
    mysqli_query($conn , "USE ".$NAME);
    mysqli_query($conn , $table_users) or die(mysqli_error($conn));
    echo "Users table created.<br>";
    mysqli_query($conn , $table_games);
    echo "Games table created.<br>";
    mysqli_query($conn , $table_queue);
    echo "Queue table created.<br>";

    mysqli_close($conn);
    die("Done!<br><h2 style = 'color:red'>Now, Delete install.php IMMEDIATELY!!</h2>");
}

echo "
<html>
<head>
    <title>::&nbsp;AICP initializing page&nbsp;::</title>
</head>
<body>
    <form action = 'install.php' method = 'GET'><table>
        <thead><h3>Config.php setup form</h3></thead>
        <tr><td>DB Host:</td><td><input name = 'HOST'></td></tr>
        <tr><td>DB Name:</td><td><input name = 'NAME'></td></tr>
        <tr><td>DB Username:</td><td><input name = 'USERNAME'></td></tr>
        <tr><td>DB Password:</td><td><input name = 'PASSWORD' type = 'password'></td></tr>
        <tr><td><input type = 'submit' value = 'Submit'></td></tr>
    </table></form>
</body>
</html>
";
?>

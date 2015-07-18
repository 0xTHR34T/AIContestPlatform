<?php

require_once("config.php");

if (empty(DB_NAME) || empty(DB_USER)) {
    die("Please check config.php");
}
else {
    echo "Redirect...";
    header("Location: Bridge");
}

 ?>

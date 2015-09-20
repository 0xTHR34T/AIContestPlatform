<?php

require("../../Core/bTerminal/main.php");

use Core\bTerminal\Main\Main as main;
use Core\bTerminal\Main\Monitor as monitor;

$main = new main;
$monitor = new monitor;

if (!isset($_COOKIE["AICP_UserName"]) || !isset($_COOKIE["AICP_PassWord"]) || !isset($_GET["query"])) {
  die("FORBIDDEN");
}

if (!$main -> validate($_COOKIE["AICP_UserName"], $_COOKIE["AICP_PassWord"])) {
  die("Invalid username or password");
}

if ($_GET["query"] == "show") {
  die($monitor -> monitorAgents($_COOKIE["AICP_UserName"]));
}
?>

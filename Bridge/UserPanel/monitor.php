<?php

require("../../Core/bTerminal/main.php");

use Core\bTerminal\Main\Main as main;
use Core\bTerminal\Main\Monitor as monitor;
use Core\bTerminal\Main\Contest as contest;

$main = new main;
$monitor = new monitor;
$contest = new contest;

if (!isset($_COOKIE["AICP_UserName"]) || !isset($_COOKIE["AICP_PassWord"]) || !isset($_GET["query"])) {
  die("FORBIDDEN");
}

if (!$main -> validate($_COOKIE["AICP_UserName"], $_COOKIE["AICP_PassWord"])) {
  die("Invalid username or password");
}

if ($_GET["query"] == "show") {
  die($monitor -> monitorAgents($_COOKIE["AICP_UserName"]));
}

if ($_GET["query"] == "test" && isset($_GET["agent"])) {
  if ($monitor -> initialTest($_COOKIE["AICP_UserName"], $_GET["agent"])) {
    die("Initial test: DONE");
  } else {
    die("Initial test: FAILURE");
    }
}

?>

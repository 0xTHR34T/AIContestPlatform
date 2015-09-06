<?php

require("../../Core/bTerminal/main.php");

use Core\bTerminal\Main\Main as main;
use Core\bTerminal\Main\Contest as contest;

$main = new main;
$contest = new contest;

if (!isset($_COOKIE["AICP_UserName"]) || !isset($_COOKIE["AICP_PassWord"]) || !isset($_GET["query"])) {
  die("FORBIDDEN");
}

if (!$main -> validate($_COOKIE["AICP_UserName"], $_COOKIE["AICP_PassWord"])) {
  die("Invalid username or password");
}

if ($_GET["query"] == "show") {
  die($contest -> fetchContests());
} else if ($_GET["query"] == "create") {
  if (!isset($_GET["number"])) {
    die("Invalid command");
  }

  if ($contest -> createContest($_COOKIE["AICP_UserName"], $_GET["number"])) {
    die("Created!");
  }

  die("Failed!");

} else if ($_GET["query"] == "join") {
  if (!isset($_GET["agent"])) {
    die("No agent specified");
  } else if (!isset($_GET["contest"])){
    die("No contest specified");
  }

  $output = $contest -> joinContest($_COOKIE["AICP_UserName"], $_GET["agent"], $_GET["contest"]);
  if ($output === true) {
    die("You've Joined!");
  } else if ($output == "No Room to join!") {
    die($output);
  } else {
    die("An error occurred!");
  }
}

?>

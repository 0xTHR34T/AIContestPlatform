<?php
require('../../Core/bTerminal/main.php');

use Core\bTerminal\Main\Main as main;
use Core\bTerminal\Main\Ranking as ranking;

$main = new main;
$ranking = new ranking;

if (!isset($_COOKIE["AICP_UserName"]) || !isset($_COOKIE["AICP_PassWord"]) || !isset($_GET["query"])) {
  die("FORBIDDEN");
}

if (!$main -> validate($_COOKIE["AICP_UserName"], $_COOKIE["AICP_PassWord"])) {
  die("Invalid username or password");
}

if ($_GET["query"] == "show") {
  die($ranking -> showRanking());
}
?>

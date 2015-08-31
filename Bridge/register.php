<?php
require_once("../Core/bTerminal/main.php");

use Core\bTerminal\Main\Registration as reg;

$reg = new reg;

if (isset($_GET["Username"]) && !isset($_GET["Email"])) {
  //print_r($reg -> existance($_GET["Username"], "USER"));
  if ($reg -> existance($_GET["Username"], "USER")) {
    die("Username is invalid or already taken");
  } else {
    die("CORRECT");
  }

} else if (isset($_GET["Email"]) && !isset($_GET["Username"])) {
  if ($reg -> existance($_GET["Email"], "EMAIL")) {
    die("Email is invalid or already taken");
  } else {
    die("CORRECT");
  }

} else if (isset($_GET["Username"]) && isset($_GET["Password"]) && isset($_GET["Email"])) {
  if ($reg -> existance($_GET["Username"], "USER") || $reg -> existance($_GET["Email"], "EMAIL")) {
    die("Username or Email is already taken!");
  } else {
    if($reg -> addNewUser($_GET["Username"], $_GET["Password"], $_GET["Email"])) {
      die("Your account registered!");
    }
  }

} else {
  die("An error occurred.");
}

?>

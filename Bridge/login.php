<?php

require_once("../Core/bTerminal/main.php");

use Core\bTerminal\Main\Main as main;

$obj = new main;
$usr = $_GET["userName"];
$pss = $_GET["Password"];
$chb = $_GET["rem"];
$valid = $obj -> validate($usr, $pss);

if ($chb) {                                       // it doesn't work!
  $expire = time() + 86400;
} else {
  $expire = 0;
}

if (!$valid) {
  die("Incorrect username or password");
} else {
  setcookie("AICP_UserName", $usr, $expire);
  setcookie("AICP_PassWord", $pss, $expire);
  echo "Redirecting to your panel...";
  header("Location: UserPanel/");
}

?>

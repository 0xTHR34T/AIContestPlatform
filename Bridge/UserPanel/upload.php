<?php
require("../../Core/bTerminal/main.php");

use Core\bTerminal\Main\Upload as upload;

$obj = new upload;

if (!isset($_FILES["file"])) {
  die("No file specified");
} else if (!$obj -> fileValidation($_FILES["file"])) {
  die("The file is invalid or already uploaded");
}

$obj -> fileUpload($_FILES["file"]);
die("Uploaded successfully!");


?>

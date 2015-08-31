<?php
namespace Core\bTerminal\Main
{
  require(dirname(__FILE__)."/../../Bridge/includes/config.php");
  require(dirname(__FILE__)."/../security.php");

  use Core\Security\Security as Sec;

  global $conn, $sec;

  class Main
  {
    function __construct()
    {
      $GLOBALS["conn"] = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
      $GLOBALS["sec"] = new Sec;
    }

    public function validate($usr, $pss)
    {
      $bool = $GLOBALS["sec"] -> filterUsername($usr);
      if(!$bool) {
        return false;
      }
      $conn = $GLOBALS["conn"];
      $res = mysqli_query($conn, "SELECT password FROM Users WHERE username='". $usr ."'");
      $num = mysqli_fetch_row($res);
      if ($num[0] == $pss) {
        return true;
      } else {
        return false;
      }
    }

    function __destruct()
    {
      mysqli_close($GLOBALS["conn"]);
    }
  }

  class Registration
  {
    public function __construct()
    {
      $GLOBALS["conn"] = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
      $GLOBALS["sec"] = new Sec;
    }

    function existance($input, $type) {
      $f1 = $GLOBALS["sec"] -> filterUsername($input);
      $f2 = $GLOBALS["sec"] -> filterEmail($input);

      if ($type == "USER") {
        if (!$f1) {
          return true;
        }
        $column = "username";
      } else {
        if(!$f2) {
          return true;
        }
        $column = "email";
      }

      $res = mysqli_query($GLOBALS["conn"], "SELECT * FROM Users WHERE $column='$input'");
      if (mysqli_fetch_row($res) == null) {
        return false;
      }
      return true;
    }

    function addNewUser($usr, $pss, $email) {
      if (strlen($usr) < 6 || strlen($pss) < 6) {
        return false;
      }
      mysqli_query($GLOBALS["conn"], "INSERT INTO Users VALUES (NULL, '$usr', '$pss', '$email', 0)");
      mysqli_query($GLOBALS["conn"], "INSERT INTO Games VALUES (NULL, '', '')");
      mkdir(dirname(__FILE__). "/../UsersData/" .$usr, 0733);
      return true;
    }

    function __destruct()
    {
      mysqli_close($GLOBALS["conn"]);
    }
  }

  class Upload
  {
    function __construct()
    {
      $GLOBALS["conn"] = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
      $GLOBALS["sec"] = new Sec;
    }

    function fileValidation($file)
    {
      if(!isset($_COOKIE["AICP_UserName"])) {
        return false;
      } else if (!$GLOBALS["sec"] -> filterFile($file)) {
        return false;
      }
      $usr = $_COOKIE["AICP_UserName"];
      $res = mysqli_query($GLOBALS["conn"], "SELECT id FROM Users WHERE username='$usr'");
      $row = mysqli_fetch_row($res);
      $id = $row[0];
      $res = mysqli_query($GLOBALS["conn"], "SELECT file_name FROM Games WHERE id='$id'");
      $row = mysqli_fetch_row($res);
      $agents = explode("***", $row[0]);

      for ($i = 0; $i < count($agents); $i++) {
        if ($agents[$i] == $file["name"]) {
          return false;
        }
      }

      return true;
    }

    function fileUpload($file)
    {
      $usr = $_COOKIE['AICP_UserName'];
      $target = dirname(__FILE__). "/../UsersData/".$usr."/" .basename($file["name"]);
      move_uploaded_file($file["tmp_name"], $target);
      $res = mysqli_query($GLOBALS["conn"], "SELECT id FROM Users WHERE username='$usr'");
      $row = mysqli_fetch_row($res);
      $id = $row[0];
      $res = mysqli_query($GLOBALS["conn"], "SELECT file_name FROM Games WHERE id='$id'");
      $row = mysqli_fetch_row($res);
      $value = $row[0] . $file["name"] . "***";
      mysqli_query($GLOBALS["conn"], "UPDATE Games SET file_name='$value'");
      return 0;
    }

    function __destruct()
    {
      mysqli_close($GLOBALS["conn"]);
    }
  }
}

?>

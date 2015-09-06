<?php
namespace Core\bTerminal\Main
{
  require(dirname(__FILE__)."/../../Bridge/includes/config.php");
  require(dirname(__FILE__)."/../security.php");

  use Core\Security\Security as Sec;

  global $conn, $sec;

  class Tools
  {
    function findIdByUsername($conn, $usr)
    {
      $res = mysqli_query($conn, "SELECT id FROM Users WHERE username='$usr'");
      $row = mysqli_fetch_row($res);
      return $row[0];
    }

    function selectRowById($conn, $id, $table)
    {
      $res = mysqli_query($conn, "SELECT * FROM $table WHERE id=$id");
      $row = mysqli_fetch_row($res);
      return $row;
    }
  }

  class Main
  {
    function __construct()
    {
      $GLOBALS["conn"] = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
      $GLOBALS["sec"] = new Sec;
      $GLOBALS["tools"] = new Tools;
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
      $GLOBALS["tools"] = new Tools;
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
      $GLOBALS["tools"] = new Tools;
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

  class Contest
  {
    function __construct()
    {
      $GLOBALS["conn"] = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
      $GLOBALS["sec"] = new Sec;
      $GLOBALS["tools"] = new Tools;
    }

    function fetchContests()
    {
      $buffer = "";
      $tbl = mysqli_query($GLOBALS["conn"], "SELECT * FROM Queue");
      $tbl = mysqli_fetch_all($tbl);

      for ($i = 0; $i < count($tbl); $i++) {
        if (($tbl[$i][0] == $tbl[$i][1]) || (strpos($tbl[$i][2], $_COOKIE["AICP_UserName"]) !== false)) {
          $offset = "-";
        } else {
          $offset = "<button name = '". $tbl[$i][2] ."' onclick = 'joinProcessInit(this)' class = 'btn btn-success' data-toggle = 'modal' data-target = '#joinModal'>join</button>";
        }
        $buffer .= "<tr>
                      <td>". $tbl[$i][0] ."</td>
                      <td>". $tbl[$i][2] ."</td>
                      <td>". $tbl[$i][4] ."</td>
                      <td>$offset</td>
                    </tr>
                    ";
      }

      return $buffer;
    }

    function createContest($usr, $num)
    {
      if (($num < 2) || ($num > 6)){
        return false;
      }

      $res = mysqli_query($GLOBALS["conn"], "SELECT * FROM Queue");
      $array = mysqli_fetch_all($res);

      for ($i = 0; $i < count($array); $i++) {
        if (strpos($array[$i][2], $usr) !== false) {
          return false;
        }
      }

      mysqli_query($GLOBALS["conn"], "INSERT INTO Queue VALUES ($num, $num-1, '$usr', 'Wating for players')");
      return true;
    }

    function fetchAgents()
    {
      $buffer = "";
      $id = $GLOBALS["tools"] -> findIdByUsername($GLOBALS["conn"], $_COOKIE["AICP_UserName"]);
      $res = mysqli_query($GLOBALS["conn"], "SELECT file_name FROM Games WHERE id=$id");
      $res = mysqli_fetch_row($res);
      $agents = explode("***", $res[0]);

      for ($i = 0; $i < count($agents)-1; $i++) {
        $buffer .= "<li ng-click = 'joinProcess()'><a>$agents[$i]</a></li>";
      }
      return $buffer . "\n";
    }

    function isRoomToJoin($contest)
    {
      $res = mysqli_query($GLOBALS["conn"], "SELECT * FROM Queue WHERE players='$contest'");
      $res = mysqli_fetch_row($res);
      if ($res[0] == $res[1]) {
        return false;
      }
      return true;
    }

    function validateAgent($usr, $agentName)
    {
      $id = $GLOBALS["tools"] -> findIdByUsername($GLOBALS["conn"], $usr);
      $row = $GLOBALS["tools"] -> selectRowById($GLOBALS["conn"], $id, "Games");
      $agents = explode("***", $row[1]);
      for ($i = 0; $i < count($agents)-1; $i++) {
        if ($agentName == $agents[$i]) {
          return true;
        }
      }
      return false;
    }

    function validateContest($contestName)
    {
      $res = mysqli_query($GLOBALS["conn"], "SELECT * FROM Queue");
      $res = mysqli_fetch_all($res);

      for ($i = 0; $i < count($res); $i++) {
        if (strpos($res[$i][2], $contestName) !== false) {
          return true;
        }
      }
      return false;
    }

    function joinContest($usr, $agent, $contestName)
    {
      if (!$this -> validateContest($contestName) || !$this -> validateAgent($usr, $agent)) {
        return false;
      } else if (!$this -> isRoomToJoin($contestName)) {
        return "No Room to join!";
      }

      $res = mysqli_query($GLOBALS["conn"], "SELECT * FROM Queue WHERE players='$contestName'");
      $res = mysqli_fetch_row($res);
      $newRemaining = $res[1]+1;
      $newPlayers = $res[2] . ",$usr";
      $newAgents = $res[3] . ",$agent";

      if ($res[0] == $newRemaining) {
        $newStatus = "Ready to start the game";
      } else {
        $newStatus = "Waiting for players";
      }

      $query = "UPDATE Queue SET remaining=$newRemaining, players='$newPlayers', status='$newStatus', agents='$newAgents' WHERE players='$contestName'";
      mysqli_query($GLOBALS["conn"], $query) or die("Updating error");
      return true;
    }

  }
}

?>

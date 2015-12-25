<?php

namespace Core\eTerminal\Main
{
  /*
   * Note: .
   *
  */
  require_once(dirname(__FILE__)."/../../Bridge/includes/config.php");
  require_once(dirname(__FILE__)."/../security.php");

  use Core\Security\Security as Sec;

  global $conn, $tools;

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

  class Build
  {
    public $currentDir;

    function __construct()
    {
      $this -> currentDir = dirname(__FILE__);
      $GLOBALS["conn"] = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
      $GLOBALS["tools"] = new Tools;
    }

    function buildProcess($player, $agent_name)
    {
      // Note: Validate the agent.

      $lang = $this -> languageCheck($player, $agent_name);
      if($lang === false)
      {
        return "Cannot find the agent.";
      }

      $log = $this -> shellExecution($player, $agent_name, $lang);
      if($log === false)
      {
        return "Cannot execute the command.";
      }

      /*$state = $this -> logHandler($log);
      switch ($state) {
        case '':
          # code...
          break;

        default:
          # code...
          break;
      }*/

      if(!$this -> stateUpdater($player, $agent_name, "1"))
      {
        return "Cannot update state.";
      }

      $this -> buildCleanup($player,$agent_name);

      return true;

    }

    function languageCheck($player, $agent_file)
    {
      $id = $GLOBALS["tools"] -> findIdByUsername($GLOBALS["conn"], $player);
      $row = $GLOBALS["tools"] -> selectRowById($GLOBALS["conn"], $id, "Games");
      $agents = explode("***", $row[1]);
      $types = explode("***", $row[4]);
      for($i = 0; $i < count($agents)-1; $i++)
      {
        if($agents[$i] == $agent_file)
        {
          return $types[$i];
        }
      }
      return false;
    }

    function shellExecution($player, $agent, $lang)
    {
      $engineDir = ($this -> currentDir) . "/../AICPE/Client";
      $cDir = $this -> currentDir;
      switch ($lang) {
        case 'text/x-c++src':
          exec("cp $cDir/../UsersData/$player/$agent $engineDir");
          exec("g++ -std=c++11 $engineDir/Debug.h $engineDir/Debug.cpp $engineDir/Network.h $engineDir/Network.cpp $engineDir/$agent -D _DEBUG -o $engineDir/$agent.o", $result);
          return $result;
          break;

        default:
          return false;
          break;
      }
    }

    /*function logHandler()
    {

    }*/

    function stateUpdater($player, $agent, $state)
    {

      $id = $GLOBALS["tools"] -> findIdByUsername($GLOBALS["conn"], $player);
      $row = $GLOBALS["tools"] -> selectRowById($GLOBALS["conn"], $id, "Games");
      $agents = explode("***", $row[1]);
      $states = explode("***", $row[3]);

      for($i = 0; $i < count($agents)-1; $i++)
      {
        if($agents[$i] == $agent)
        {
          $states[$i] = $state;
          $agents[$i] = $agent.".o";          // Useless in some langs
          $newState = implode("***", $states);
          $newAgents = implode("***", $agents);
          break;
        }
      }

      //Note: Handle invalid agent.

      mysqli_query($GLOBALS["conn"], "UPDATE Games SET file_name='$newAgents', initial_test='$newState' WHERE id='$id'");
      return true;
    }

    function buildCleanup($player, $agent)
    {
      $engineDir = ($this -> currentDir) . "/../AICPE/Client";
      exec("rm $engineDir/$agent");
      exec("mv -f $engineDir/$agent.o ". $this -> currentDir ."/../UsersData/$player/") ;
    }
  }

  class Playground
  {
    public $pgDir;

    function __construct()
    {
      $this -> pgDir = dirname(__FILE__) . "/../AICPE";
      $GLOBALS["conn"] = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
      $GLOBALS["tools"] = new Tools;
    }

    function contestProcess($competitors)
    {
      $arg = $this -> initialize($competitors);
      $ex = $this -> runContest($competitors, $arg);
      if ($ex === false)
      {
        die("Cannot run the contest");
      }

      $res = $this -> resultHandler();
      $this -> allocScores($competitors, $res);
      $this -> finalize($competitors);

    }

    function initialize($rivals)
    {
      $output = "";
      $udDir = dirname(__FILE__). "/../UsersData";

      for ($i = 0; $i < count($rivals); $i++) {
        exec("cp $udDir/". $rivals[$i][0] ."/". $rivals[$i][1] ." ". $this -> pgDir);
        $output .= " ". $rivals[$i][0];
      }
      return $output;
    }

    function runContest($rivals, $names)
    {
      $agents = "";
      // Setting the library path:
      $libPath = "LD_LIBRARY_PATH=/usr/local/lib && export LD_LIBRARY_PATH && ";
      //

      for ($i = 0; $i < count($rivals); $i++)
      {
        $agents .= " ".$rivals[$i][1];
      }

      //exec($libPath. "cd " . $this -> pgDir ." && ./engine.o ". strval(count($rivals)) .$names);
      exec($libPath. "cd ". $this -> pgDir ." && python run.py ". strval(count($rivals)) . $names . $agents);
      /*for ($i = 0; $i < count($rivals); $i++)
      {
        exec($libPath. "cd ". $this -> pgDir ." && ./". $rivals[$i][1]);
      }*/
      if (!file_exists(($this -> pgDir). "/Engine Log.txt"))
      {
        return false;
      }
      return true;
    }

    function allocScores($rivals, $scoresArray)
    {
      foreach($rivals as $key => $playerArray)
      {
        $id = $GLOBALS["tools"] -> findIdByUsername($GLOBALS["conn"], $playerArray[0]);
        $row = $GLOBALS["tools"] -> selectRowById($GLOBALS["conn"], $id, "Games");
        $agentsArray = explode("***", $row[1]);
        $oldResults = explode("***", $row[2]);

        for($i = 0; $i < count($agentsArray)-1; $i++)
        {
          if($agentsArray[$i] == $playerArray[1])
          {
            if(($scoresArray[$key]/100 < 1) and ($scoresArray[$key]/100 >= 0))
            {
              $newScore = intval($oldResults[$i]) + $scoresArray[$key];
              $oldResults[$i] = strval($newScore);
              $newResults = implode("***", $oldResults);
              $newUserScore = 0;

              for($i = 0; $i < count($oldResults)-1; $i++)
              {
                $newUserScore += intval($oldResults[$i]);
              }
              mysqli_query($GLOBALS["conn"], "UPDATE Games SET result='$newResults' WHERE id=$id");
              mysqli_query($GLOBALS["conn"], "UPDATE Users SET score=$newUserScore WHERE id=$id");
            }

            break;
          }
        }
      }

      return true;
    }

    function resultHandler()
    {
      $resDir = ($this -> pgDir). "/results.bin";
      $fl = fopen($resDir, "r");
      $number = unpack("I", fgets($fl, 5));
      $scores = array();

      for ($i = 1; $i <= $number[1]; $i++)
      {
	       $temp = unpack("f", fgets($fl, 5));
         array_push($scores, intval($temp[1]*100));
      }

      return $scores;
    }

    function finalize($rivals)
    {
      $pl = array();

      foreach ($rivals as $players) {
        exec("rm ". ($this -> pgDir) ."/". $players[1]);
        array_push($pl, $players[0]);
      }
      //exec("rm ". ($this -> pgDir) ."/Engine Log.txt"); >>> Can't rm the log file
      exec("rm ". ($this -> pgDir) ."/results.bin");

      $pl = implode(", ", $pl);
      mysqli_query($GLOBALS["conn"], "DELETE FROM Queue WHERE players='$pl'");
      return true;
    }

  }
}

?>

<?php

namespace Core\Security
{
  class Security
  {
    public function filterUsername($input)
    {
      $flt = "'~`!@#$%^&*()+={}\|/?,".'"';
      for ($i = 0; $i < strlen($input); $i++) {
        for ($i2 = 0; $i2 < strlen($flt); $i2++) {
          if ($input[$i] == $flt[$i2]) {
            return false;
          }
        }
      }
      return true;
    }

    public function filterEmail($email)
    {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return true;
      }
      return false;
    }

    public function filterFile($file)
    {
      $type = $file["type"];
      if ($type == "text/x-python" || $type == "application/x-ruby" || $type == "text/x-csrc" || $type == "text/x-c++src" || $type == "text/x-java" || $type == "application/x-perl") {
        if (!strpos($file["name"], ".php")) {
          return true;
        }
      }
      // {TODO: filter the name("')}
      // {TODO: filter the size}
      return false;
    }


  }
}
?>

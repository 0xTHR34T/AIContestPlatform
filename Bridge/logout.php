<?php

setcookie("AICP_UserName", "", time() - 3600);
setcookie("AICP_PassWord", "", time() - 3600);
echo "Logged out. <br>Redirecting...";
header("Location: index.php");

?>

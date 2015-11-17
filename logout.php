<?php
$query = "UPDATE users SET session = '"."nosession"."' WHERE username = '".$_COOKIE['hackme']."'";
mysql_query($query)or die(mysql_error());
setcookie (hackme, "", time() - 3600);
setcookie(hackmesess, "", time() - 3600);
header("Location: index.php");
?>

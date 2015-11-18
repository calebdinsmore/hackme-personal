<?php
include('connect.php');
connect();
$path = 'phpseclib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
include_once('Crypt/RSA.php');

function publicKeyToHex($privatekey) {

  $rsa = new Crypt_RSA();

  $rsa->loadKey($privatekey);
  $raw = $rsa->getPublicKey(CRYPT_RSA_PUBLIC_FORMAT_RAW);
  return $raw['n']->toHex();
}

if(isset($_GET['user'])) {
  $check = mysql_query("SELECT * FROM users WHERE username = '".mysql_real_escape_string($_GET['user'])."'")or die(mysql_error());
  $info = mysql_fetch_array($check)or die(mysql_error());
  $privatekey = $info['pkey_for_next_login'];
  echo publicKeyToHex($privatekey);
}
?>

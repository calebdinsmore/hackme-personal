<?php
	function connect()
	{
		// Connects to the Database
		mysql_connect("localhost", "security-project", "69BgYftvzpEH", false, 65536) or die(mysql_error());
		mysql_select_db("hackme") or die(mysql_error());
	}

	function valid_session()
	{
    $check = mysql_query("SELECT * FROM users WHERE username = '".$_COOKIE['hackme']."'")or die(mysql_error());
    $info = mysql_fetch_array($check);
    if (password_verify($info['session'], $_COOKIE['hackmesess']) && !hash_equals($info['session'], "nosession")) //hash_equals is timing safe
    {
      return 1;
    } else {
      return 0;
    }
	}
	
		function publicKeyToHex($privatekey) {

			$rsa = new Crypt_RSA();

			$rsa->loadKey($privatekey);
			$raw = $rsa->getPublicKey(CRYPT_RSA_PUBLIC_FORMAT_RAW);
			return $raw['n']->toHex();
		}

	function decrypt($privatekey, $encrypted) {
		$rsa = new Crypt_RSA();

		$encrypted=pack('H*', $encrypted);

		$rsa->loadKey($privatekey);
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
		return $rsa->decrypt($encrypted);
	}
?>

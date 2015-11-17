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
	//I am well aware that putting this function in this file is utter nonsense. But it's late, and I don't care. :P
	function decrypt($to_decrypt)
	{
		$priv_key = openssl_pkey_get_private("rsa_1024_priv.pem");
		// Create the keypair
		$res=openssl_pkey_new();

		// Get private key
		openssl_pkey_export($res, $privkey);

		// Get public key
		$pubkey=openssl_pkey_get_details($res);
		$pubkey=$pubkey["key"];
		openssl_pkey_export_to_file($privkey, "privkey.pem");
		openssl_pkey_export_to_file($pubkey, "privkey.pem");
		if (openssl_private_decrypt(base64_decode($to_decrypt), $decrypted, $priv_key)){
			echo 'true';
		} else {
			echo openssl_error_string();
		}
	}
?>

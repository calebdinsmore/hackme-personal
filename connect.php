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
		$priv_key = '-----BEGIN PRIVATE KEY-----
		MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDw2KMPhNMZLeZO
		PCBbIeEihQx3bXA4auzqItUrRFcfxOGhHrJp671rGinw9acIRV33LFaqUzgETtFd
		BeJnyCr/dg4jt8lzleRxy6/8/wawmE5rBUGF6CfHQhe+rPG17GUKjibA64XdF0t9
		5TwuXd+gicZDkDH6lovq6IZwXccza5hA59RrwsoiXV/6Xp/uX3XSM0qUnYXlB1nL
		GxKonJOeOCJZjzMiBbndanEgknyBo99MpQg/BlV/9/qxehxFv5ffJZDkrmxOsAyB
		qy2oCCKCFHSMxUR37lGyzKGnTLM3SOGlcoiUwpy1D1WniygrTGiFbJPhvJZZF1nM
		gRNy0giHAgMBAAECggEAOhFxVxeGMgbwBSLYBkDn4APGGrFHIkMddeIKFVF31BAK
		+mbFS2ZsF/uJ6y+/Iu5elm6ZQp2n3toF/nChwrXvMAKNrCzupDCakJk0iEIQodlG
		5uSwhJGRragQw4c9C8jAH8hgLZlbgA/SwrrXRLKbbUBqjfWhJzLO70c6yrLBiXLK
		1iu1jkXWS68cxO4lC11yNbArvwT5BjZ4M8u5mCnqxSlXoW8K6ruqzWqfjkgqmeXT
		I08cGEJJBouwGM8YsVyIjetHcS9RkZLFHKTAgghIDJzeU9aobywAsKDVg5FkDfN0
		flBQJ6RrZJL+NDC4yrBNkYhXQQG+QTrFdIq+1epuSQKBgQD74T89ganRl7WJcTPp
		0k9zvWs/MlyCypKl0YciFnHZQCsteNgqy9HwJMwyE/5piBKV8nISubeyuasjoCp2
		FojYc0zHdgokuIW+yDlLWLs4wjUJDCiWAFCLpbHzqA95xAWIcctd69VFpV6bE4tW
		jiZEYYbe/5zU+q8cQV2U6XVkiwKBgQD0yS+yw98v5MtP3kIwEPkGa8cAIwpMhotY
		k/Jv0cQHGLCtF7ElTwP8H2jpT/LjIXsrwAFcFiR5k7D4oQw5/+K2Pm/LlFi0H0oQ
		TDuS+XfgztghVi43GOlS0NvIet/YVTecga69yVZG09XygLRaPAkev27nhgjkClp1
		QWLaLYLfdQKBgDE7o+rXz2PCbZ+B2w3XJ+SNn8rogyCli+iRfgJxtKssWcQ3nLkw
		wcZYyvj244GpMUjR7O4wEvICTKtYATS3zuPQFa/fKLhowOu7o0dQ/rdnbopoL/6x
		7Qx+xLvFm9DHOfWjmIaxNCy62DUjqtauTliLX5tzByqyHUw+kpYq0+FlAoGAFB38
		p4pla0A4XUX81opujNKKtj4q+IMOLKdsAziQDa0/x9nsmw5VW4ERVCtX4Ma9oqjS
		88h2Eu/KWYSSxql67lNPSMHWUGdJ5PD+7GNIMNeO955nieuoMUAs79r5ToQiX+Bg
		hgRn7MY4DQf6yneooDhHWwuu617WdFB9WUToPokCgYEAzrJAooyD0+E9X/TlVe/n
		u/K2TFMzhEJiRYsRY8DoEwOFFzBtkPdz4Ci3tDOSd3wxpO1ciz6LF0u/HjMVRrnG
		M0dbg+AVE1wYpRNb+DacV7UK3ko3enJZgBDmhdF2e1Hh2aUGznzfHpM87WRrbg1+
		8CA2z/GB5qGumZZcpxVTGWg=
		-----END PRIVATE KEY-----
';
		$rsa = new Crypt_RSA();
		$rsa->loadKey($priv_key); // private key

		echo $rsa->decrypt(base64_decode($to_decrypt));
		/* Create the private and public key */
		if (openssl_private_decrypt(base64_decode($to_decrypt), $decrypted, $privkeyfile)){
			echo 'true';
		} else {
			echo openssl_error_string();
		}
	}
?>

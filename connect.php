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
		$private_key = "-----BEGIN RSA PRIVATE KEY-----
		MIICXAIBAAKBgQDD3aqfqP0Wj0MK/SOq5HFZn8jOooczlRSz9qAFZOKOuUVPzd7o
		GH1iuWJwts+i3m5TL5J3RzcDxM6rioSVF//TB383cDtKvaTgpW+ulRTvIXUbNDa6
		a5s7TPZvrdR1C8eRHW76UDxhE/K9/K+iW69U6mCJYG5gElQTvRTq3i7RLQIDAQAB
		AoGAOVGmfCDtJ+v298FK7dj6nvrWvjnsDRlkvKHBBLMYZiIr+YXK5Os9zmVoPIoT
		S5uCd8+lMkjh/bVbsfHQiP1D/Q8BlVRYh8ZjbxkrvUui/m4elMQl/AJYAeBqtRRI
		scKl7xqIWqiYj4ZOr1NEJQkWPs8pZO1yDjNuEXqeN9VK82ECQQD6kRyWfO3oHhXV
		AIL2w4IuoSHJrfcBoT929+dR4WBeXofAGSCFdRWhET8vDcpki102sXk4FBxat/a5
		go14X/GFAkEAyBzpXueKFayFNcK1eIogb8qNWtqOr2zyUCxnIuPge348hV9/rk3v
		B4iySXD8dJ7j3IaathgybNguJL7SHlidiQJAa4HNiUgK75fQ+DYi+uuBtK4QCC9r
		FrjvuQS+rGQN7A+VITfmuzw0TopO2MqK9z7QfMIC56vBSq853fiE6IwJ3QJBAKMc
		hdB4tGIkRFRkyBxfoj7dAEk8+q7dA8n713ll+zVN2TDxfZZrKdmfP4uDUBQS6zJ2
		eSbSJE/6Ceqjq4tWudkCQHvpFazbFWLsDkDVKhldtZZH1GgVhcx1Zmn45rZ2MLJg
		AVGI2wDFytoPvO1RLIHllSbSTFrXZZkrOGdVMxfiHjM=
		-----END RSA PRIVATE KEY-----";
		$decrypted = "";
		$priv_key = openssl_pkey_get_private("rsa_1024_priv.pem");
		if (openssl_private_decrypt(base64_decode($to_decrypt), $decrypted, $priv_key)){
			echo 'true';
		} else {
			echo 'false';
		}
	}
?>

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
		$pubkey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCjFLYEjRkUPeCFbTqQZaCeq5GU
xieUakf4MAkfBqWo9yZjAM0biaBdDmifDkCnKtJLBkmUnKFpSAQRxGY71+1Ln+Vi
GrGzSRpItMxEnpdPdP9Hn0UfgeZ451AOFnhvC8n/xJvYfSpZhqD7eRMFE9F750xT
N89VsJLYT9jGxoUThwIDAQAB
-----END PUBLIC KEY-----
';
		$priv_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCjFLYEjRkUPeCFbTqQZaCeq5GUxieUakf4MAkfBqWo9yZjAM0b
iaBdDmifDkCnKtJLBkmUnKFpSAQRxGY71+1Ln+ViGrGzSRpItMxEnpdPdP9Hn0Uf
geZ451AOFnhvC8n/xJvYfSpZhqD7eRMFE9F750xTN89VsJLYT9jGxoUThwIDAQAB
AoGAEJHzKKU5jh/3ZzdBAxkAZ/7gzPARZ3ghFeuzkY54WKG8KcUUEh86xxnGsZqe
IR4tvefGpC4CDJN/rlp5VM1M0//AzIDldbKZBWDxtsdugRt7LANA/j32Ebv4Fwqe
hDGHz1U1nScQMU74JOs2JZYfTcm0l6D6KYmOqaBNvt1I3QkCQQDTHdbhiozOz2BR
5jweFNdUc9HMfXuEV8UznZ14OaV8qF9KMD2woOnB+t1c8L3be13fK3VYDaZO3NE/
515gn5cDAkEAxcB/qcu+3kv8L7nLaJYhyDBxndeJlL8dbAs1CnG7rc9I3PRzwIds
VyRzGKvgt6r3llGjuXlj41ZVOHzC+K/YLQJAIK1dtUtcwCYZIpQgegd/zPKgZqaF
l9Z+D5814IYLt1/YYANXiR9fD0dlPB2HRZGy1fhEEX0LYOmM+fc2BH6vQQJAEEah
u0XrtbwnS35NQZRpv2JNV6JvznBUaZoaiXuG6O1Qn+72v/flcN6tInCzFCrcKeEa
Sp+1Gvb2GKocGf/PGQJBALF7IJrSbRNCh9oo+2I1/U0kBWLjOYKvgUniWzpbRzRh
lL8zIAVUjxf3rtzX5wrA0qIvkYEl+ZoBba76boZhTk0=
-----END RSA PRIVATE KEY-----
';
$rsa = new Crypt_RSA();
$rsa->loadKey($pubkey); // public key

$plaintext = 'hello';

$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
$ciphertext = $rsa->encrypt($plaintext);

$rsa->loadKey($priv_key); // private key
echo $rsa->decrypt(base64_decode($to_decrypt));
	}
?>

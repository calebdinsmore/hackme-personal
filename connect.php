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
	function my_decrypt($to_decrypt)
	{
		$pubkey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCjFLYEjRkUPeCFbTqQZaCeq5GU
xieUakf4MAkfBqWo9yZjAM0biaBdDmifDkCnKtJLBkmUnKFpSAQRxGY71+1Ln+Vi
GrGzSRpItMxEnpdPdP9Hn0UfgeZ451AOFnhvC8n/xJvYfSpZhqD7eRMFE9F750xT
N89VsJLYT9jGxoUThwIDAQAB
-----END PUBLIC KEY-----
';
		$priv_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQD0W8Wj5YToT4RjAaX+EX+k8Sc7oCSYJVRrZmiubDCUTQm93kCjvEPEBbPojutU
GMvbshJqTKKeY7F1YYLfrMVbxcCLr1XN1OD9+jKUeE5ym9cIBoJ82fN5CI/ZQ3+ssGmawRFQ89Z5
fyGB+LWJga9t4z7xlTYjlBhcyNEsHJ8tyQIDAQABAoGBAKP+PzsKm1MJorCLd6p2dfLtgUYL6ONP
EkPt+80rgMLWnPYXBcydWeFhbmdiG19aMN5luOQsQGsKPxum8J1KpzvrT9hiFugMja1z1alqxpKa
yG7bFvOfWdcwHIewUmaOAxz2mKe/QJ+pOCE9SgvQvznTMVCAdzB9ObIuM0q/zVi9AkEA/ftr98l4
FmGuZNqExfAqy+8JXrt7AL6opob6f0axBtNLPI8fw8jLWXNIcrCi/BBFoEFwyvvtpJqTgCgdyNeW
AwJBAPZMxtDsb21Qxshmb7JGdI09Id2udtHkpWS+J4vIBtRXE92fH53KKG9zLfksuSck7MZB8oLE
FFlmGb7+KCJu+UMCQQCYwLZW+Rz4mRdCIQrp4WBb9xAzoZ6A/CqCvXu7QNEHwdzmN05rekCTM/rG
v+XGpCK8F5+29X4gGbfMxFPlj4PxAkACcGYzoXPFCFy/lUwb3ti+oVFZiaXBlFsS8VMg7j0rEyWu
Nyov/NWDrQdShV/cBGCX4gVNyDVPYVR18LxjAuhTAkEAmVvPDN41feEeBoppCa63+JPMFt14DSG1
NCg84L21MnwI7fTowVRUjcmf4UT2yC22X3oZTJ9QVqNw/dMFSReeYA==
-----END RSA PRIVATE KEY-----';

$rsa = new Crypt_RSA();
$rsa->loadKey($priv_key); // private key
echo $rsa->decrypt(base64_decode($to_decrypt));
	}

	function publicKeyToHex($privatekey) {

			$rsa = new Crypt_RSA();
			echo "here";
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

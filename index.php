<?php
	include('connect.php');
	connect();
	if(valid_session())
	{
		header("Location: members.php");
	}

	$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');

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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>hackme</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
<script src="javascript/jsbn.js"></script>
<script src="javascript/jsbn2.js"></script>
<script src="javascript/prng4.js"></script>
<script src="javascript/rng.js"></script>
<script src="javascript/rsa.js"></script>
<script src="javascript/rsa2.js"></script>
<?php
	include('header.php');
?>
<script>
function submitform()
{
  var username = document.getElementById("UN-login");
  var password = document.getElementById("PW-login");
	var publickey = "";
	jQuery.ajax({
        url: 'getpubkeyforuser.php?user='+username.value,
        success: function (result) {
            if (result.isOk == false) alert(result.message);
        },
        async: false
    });;
	var rsakey = new RSAKey();
  rsakey.setPublic(publickey, "10001");
  username.value = rsakey.encrypt($('#UN-login').val());
  password.value = rsakey.encrypt($('#PW-login').val());

	return;
}
</script>
<div class="post">
	<div class="post-bgtop">
		<div class="post-bgbtm">
			<h2 class="title"><a href="#">Welcome to hackme </a></h2>
				<div class="entry">
		<?php
			$check = mysql_query("SELECT * FROM users WHERE username = '".$_COOKIE['hackme']."'")or die(mysql_error());
			$info = mysql_fetch_array($check);
			if(!password_verify($info['session'], $_COOKIE['hackmesess']) || hash_equals($info['session'], "nosession")){
				?>
	           	<form method="post" action="members.php">
				<h2> LOGIN </h2>
				<table>
					<tr> <td> Username </td> <td> <input id="UN-login" type="text" name="username" /> </td> </tr>
					<tr> <td> Password </td> <td> <input id="PW-login" type="password" name="password" /> </td>
                    <td> <input type="submit" name = "submit" value="Login" onclick="javascript: submitform()"/> </td></tr>
				</table>
				</form>

				<hr style=\"color:#000033\" />

			<p></p><p>If you are not a member yet, please click <a href="register.php">here</a> to register.</p>
           <?php
				}
		?>
	</div>
	</div>
	</div>
</div>
<!-- end #sidebar -->
	<?php
		include('footer.php');
	?>

</body>
</html>

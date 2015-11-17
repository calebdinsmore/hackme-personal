<?php
	include('connect.php');
	connect();
	$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');
	if(valid_session())
	{
		header("Location: members.php");
	}
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>hackme</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<?php
	include('header.php');
?>
<script>
function submitform(key)
{
  var username = document.getElementById("UN-login");
  var password = document.getElementById("PW-login");
  var publickey = "<?=publicKeyToHex($priv_key)?>";
  var rsakey = new RSAKey();
  rsakey.setPublic(publickey, "10001");
  username.value = btoa(rsakey.encrypt($('#UN-login').val()));
  password.value = btoa(rsakey.encrypt($('#PW-login').val()));
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

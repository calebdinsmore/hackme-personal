<?php
	// Connects to the Database
	include('connect.php');
	connect();

	//if the login form is submitted
	if (isset($_POST['submit'])) {

		$_POST['username'] = trim($_POST['username']);
		if(!$_POST['username'] | !$_POST['password']) {
			die('<p>You did not fill in a required field.
			Please go back and try again!</p>');
		}

		$check = mysql_query("SELECT * FROM users WHERE username = '".$_POST['username']."'")or die(mysql_error());

 		//Gives error if user already exist
 		$check2 = mysql_num_rows($check);
		if ($check2 == 0) {
			die("<p>Sorry, user name does not exist.</p>");
		}
		else
		{
			while($info = mysql_fetch_array( $check )) 	{
				if($info['log_attempts'] == 3) {
					die("<p>Reached max number of login attempts. Call 1(800)LOL-OLOL to request a reset.</p>");
				}
			 	//gives error if the password is wrong
				if (password_verify($_POST['password'], $info['pass'])) {
					$query = sprintf("UPDATE users SET log_attempts = %d WHERE username = '".$_POST['username']."'", 0);
					mysql_query($query)or die(mysql_error());
				} else {
					$query = sprintf("UPDATE users SET log_attempts = %d WHERE username = '".$_POST['username']."'", $info['log_attempts'] + 1);
					mysql_query($query)or die(mysql_error());
					die(sprintf('<p>Incorrect password, please try again. Number of login attempts: %d</p>', $info['log_attempts'] + 1));
				}
			}
			$hour = time() + 3600;
			$session_id = rand();
			$query = sprintf("UPDATE users SET session = '".$session_id."' WHERE username = '".$_POST['username']."'");
			mysql_query($query)or die(mysql_error());
			setcookie(hackme, $_POST['username']);
			setcookie(hackmesess, password_hash($session_id, PASSWORD_BCRYPT), $hour);
			header("Location: members.php");
		}
	}
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>hackme</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<?php
	include('header.php');
?>
<div class="post">
	<div class="post-bgtop">
		<div class="post-bgbtm">
        <h2 class = "title">hackme bulletin board</h2>
        	<?php
            if(!valid_session()){
				 			die('Why are you not logged in?!');
						}else
						{
							print("<p>Logged in as <a>$_COOKIE[hackme]</a></p>");
						}
						?>
        </div>
    </div>
</div>
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script src="bin/jsencrypt.js"></script>
	<script type="text/javascript">

		// Call this code when the page is done loading.
		$(function() {

			// Run a quick encryption/decryption when they click.
			$('#testme').click(function() {

				// Encrypt with the public key...
				var encrypt = new JSEncrypt();
				encrypt.setPublicKey($('#pubkey').val());
				var encrypted = encrypt.encrypt($('#input').val());

				// Decrypt with the private key...
				var decrypt = new JSEncrypt();
				decrypt.setPrivateKey($('#privkey').val());
				var uncrypted = decrypt.decrypt(encrypted);

				// Now a simple check to see if the round-trip worked.
				if (uncrypted == $('#input').val()) {
					console.log('It works!!!');
				}
				else {
					alert('Something went wrong....');
				}
			});
		});
	</script>
<body>
	<label for="privkey">Private Key</label><br/>
	<textarea id="privkey" rows="15" cols="65">-----BEGIN RSA PRIVATE KEY-----
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
	-----END RSA PRIVATE KEY-----
</textarea><br/>
	<label for="pubkey">Public Key</label><br/>
	<textarea id="pubkey" rows="15" cols="65">-----BEGIN PUBLIC KEY-----
	MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDD3aqfqP0Wj0MK/SOq5HFZn8jO
	ooczlRSz9qAFZOKOuUVPzd7oGH1iuWJwts+i3m5TL5J3RzcDxM6rioSVF//TB383
	cDtKvaTgpW+ulRTvIXUbNDa6a5s7TPZvrdR1C8eRHW76UDxhE/K9/K+iW69U6mCJ
	YG5gElQTvRTq3i7RLQIDAQAB
	-----END PUBLIC KEY-----</textarea><br/>
	<label for="input">Text to encrypt:</label><br/>
	<textarea id="input" name="input" type="text" rows=4 cols=70>This is a test!</textarea><br/>
	<input id="testme" type="button" value="Test Me!!!" /><br/>

<?php
	$threads = mysql_query("SELECT * FROM threads ORDER BY date DESC")or die(mysql_error());
	while($thisthread = mysql_fetch_array( $threads )){
?>
	<div class="post">
	<div class="post-bgtop">
	<div class="post-bgbtm">
		<h2 class="title"><a href="show.php?pid=<? echo $thisthread[id] ?>"><? echo $thisthread[title]?></a></h2>
							<p class="meta"><span class="date"> <? echo date('l, d F, Y',$thisthread[date]) ?> - Posted by <a href="#"><? echo $thisthread[username] ?> </a></p>

	</div>
	</div>
	</div>
<?php
}
	include('footer.php');
?>
</body>
</html>

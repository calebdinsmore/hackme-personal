<?php
	// Connects to the Database
	include('connect.php');
	connect();
	$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');

	function decrypt($privatekey, $encrypted) {
		$rsa = new Crypt_RSA();

		$encrypted=pack('H*', $encrypted);

		$rsa->loadKey($privatekey);
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
		return $rsa->decrypt($encrypted);
	}

	//if the login form is submitted
	if (isset($_POST['submit'])) {

		$check = mysql_query("SELECT * FROM users WHERE username = '".mysqli_escape_string($_POST['username'])."'")or die(mysql_error());
		$info = mysql_fetch_array($check);
		$privatekey = $info['pkey_for_next_login'];

		$_POST['username'] = decrypt($privatekey, $_POST['username']);
		$_POST['password'] = decrypt($privatekey, $_POST['password']);

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
					echo $_POST['password']."<br/>";
					$query = sprintf("UPDATE users SET log_attempts = %d WHERE username = '".$_POST['username']."'", $info['log_attempts'] + 1);
					mysql_query($query)or die(mysql_error());
					die(sprintf('<p>Incorrect password, please try again. Number of login attempts: %d</p>', $info['log_attempts'] + 1));
				}
			}
			$hour = time() + 3600;
			$session_id = rand();
			$query = sprintf("UPDATE users SET session = '".$session_id."' WHERE username = '".$_POST['username']."'");
			mysql_query($query)or die(mysql_error());
			//setcookie(    $name, $value, $expire, $path, $domain, $secure, $httponly )
			setcookie(hackme, $_POST['username'], $hour, null, null, null, 1);
			setcookie(hackmesess, password_hash($session_id, PASSWORD_BCRYPT), $hour, null, null, null, 1);
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

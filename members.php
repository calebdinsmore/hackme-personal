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

		$passwordHash = sha1($_POST['password']);

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
				if ($passwordHash != $info['pass']) {
					$query = sprintf("UPDATE users SET log_attempts = %d WHERE username = '".$_POST['username']."'", $info['log_attempts'] + 1);
					mysql_query($query)or die(mysql_error());
					die(sprintf('<p>Incorrect password, please try again. Number of login attempts: %d</p>', $info['log_attempts'] + 1));
				} else if($info['log_attempts'] > 0) {
					$query = sprintf("UPDATE users SET log_attempts = %d WHERE username = '".$_POST['username']."'", 0);
					mysql_query($query)or die(mysql_error());
				}
			}
			$hour = time() + 3600;
			setcookie(hackme, $_POST['username'], $hour);
			setcookie(hackme_pass, $passwordHash, $hour);
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
            if(!isset($_COOKIE['hackme'])){
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

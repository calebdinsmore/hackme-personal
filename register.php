<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>hackme</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<?php
	include('connect.php');
	connect();
	include_once '/csrf-magic/csrf-magic.php';
	include('header.php');
	$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');

	$privatekey="-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQCwka4OKx4AAOCQlBo2/f7m1vXJ2UzRo4RlyBd2piZ5agiTtOtSEOI3/d3eGBqM
IbOQ/osqvTFQnVV1fHSNXqmyVnAnDbm4EsVmCoVm9NMcUlmjQjgJHIBqUNW0MqWQSSoyfnXFNWiZ
r2bfmiCJliPshiEtqUNrXf+Lfaj/XlAtZwIDAQABAoGAB7gGpOXrpNJk/s0KrFbEOvEww4c1XYDJ
e+2YYP54dhxVjad+FhNY4Fu/xELHflLG19LY4KButHh8UOuE6N03i9qkw+LKpBe0rDmgUuTCD8Ya
6BSwgdUCALqA5Ngz67YKV5eBc0CyI8FW2h4EazBBuZWs6OltgP7pQLYfhRgr/oECQQDn7FoD6kwk
JxY3jSNouek5/huxCWL1Q18fHcPYnLgXDQHFkp6QKgepdVCBjqhyVPAJPRcweXkRyWk2yshcaQ8n
AkEAwuY41tTLEDyQfWigBYjvK8amErGBppVCjHJj4M1AvmU+I5KTMqg8d+fHT74uSBgXnaPKIhP7
u29xlv+GSs7XwQJBAJuYNcvqpKqcjos2ZUsdbxs5H9rmMT3atTZrAbmRavAMCeRDOZ3+lKVbz2cc
DmamFWQdWDFtTYxhU/Uulr1ovoECQQCXbVZGHCj1oYjF109VXZIuGfaYWZAZRKjjBFFzrSWbiH/i
FZUGa84nf07NNz8wRn+6vDJljc8tTyYbIsdNQi5BAkAxkaxetF5CPWvMQi1mF0m9dzLx9/cv/UH1
0eyuAzL9oc6JV4Z5w1vLERgk6OcN/n3HGyqnf2Aet2lel1DSa/Km
-----END RSA PRIVATE KEY-----";

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
<div class="post">
	<div class="post-bgtop">
		<div class="post-bgbtm">
        <h2 class = "title">hackme Registration</h2>
        <?php
		//if the registration form is submitted
		if (isset($_POST['submit'])) {

			$_POST['uname'] = decrypt($privatekey, $_POST['uname']);
			$_POST['password'] = decrypt($privatekey, $_POST['password']);
			$_POST['fname'] = decrypt($privatekey, $_POST['fname']);
			$_POST['lname'] = decrypt($privatekey, $_POST['lname']);
			$_POST['uname'] = trim($_POST['uname']);
			if(!$_POST['uname'] | !$_POST['password'] |
				!$_POST['fname'] | !$_POST['lname']) {
 				die('<p>You did not fill in a required field.
				Please go back and try again!</p>');
 			}

			if(preg_match("/.*[$@$!%*#?&].*/", $_POST['password']) == 0 || strlen($_POST['password']) <= 8) {
				die("<p>Password must contain at least one special character and be at least 8 characters long.</p>");
			}

			$passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT); //password_hash is more secure

			$check = mysql_query("SELECT * FROM users WHERE username = '".$_POST['uname']."'")or die(mysql_error());

 		//Gives error if user already exist
 		$check2 = mysql_num_rows($check);
		if ($check2 != 0) {
			die('<p>Sorry, user name already exisits.</p>');
		}
		else
		{
			$rsa = new Crypt_RSA();
			$rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
			$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);
			extract($rsa->createKey(1024)); /// makes $publickey and $privatekey available
			mysql_query("INSERT INTO users (username, pass, fname, lname, log_attempts, session, pkey_for_next_login) VALUES ('".$_POST['uname']."', '". $passwordHash ."', '". $_POST['fname']."', '". $_POST['lname'] ."', 0, '". "nosession" ."', '". $privatekey ."');")or die(mysql_error());
			echo $privatekey;
			echo "<h3> Registration Successful!</h3> <p>Welcome ". $_POST['fname'] ."! Please log in...</p>";
		}
        ?>
        <?php
		}else{
        ?>
					<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
					<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
					<script src="javascript/jsbn.js"></script>
					<script src="javascript/jsbn2.js"></script>
					<script src="javascript/prng4.js"></script>
					<script src="javascript/rng.js"></script>
					<script src="javascript/rsa.js"></script>
					<script src="javascript/rsa2.js"></script>
					<script>
					function submitform()
					{
					  var username = document.getElementById("uname");
					  var password = document.getElementById("password");
						var fname = document.getElementById("fname");
					  var lname = document.getElementById("lname");
						var publickey = "<?=publicKeyToHex($privatekey)?>";
						var rsakey = new RSAKey();
					  rsakey.setPublic(publickey, "10001");
					  username.value = rsakey.encrypt(username.value);
					  password.value = rsakey.encrypt(password.value);
						fname.value = rsakey.encrypt(fname.value);
					  lname.value = rsakey.encrypt(lname.value);

						return;
					}
					</script>
        	<form  method="post" action="register.php">
            <table>
                <tr>
                    <td> Username </td>
                    <td> <input id="uname" type="text" name="uname" maxlength="20"/> </td>
                    <td> <em>choose a login id</em> </td>
                </tr>
                <tr>
                    <td> Password </td>
                    <td> <input id="password" type="password" name="password" maxlength="40" /> </td>
                </tr>
                <tr>
                    <td> First Name </td>
                    <td> <input id="fname" type="text" name="fname" maxlength="25"/> </td>
                </tr>
                 <tr>
                    <td> Last Name </td>
                    <td> <input id="lname" type="text" name="lname" maxlength="25"/> </td>
                </tr>
                <tr>
                    <td> <input onclick="javascript: submitform()" type="submit" name="submit" value="Register" /> </td>
                </tr>
            </table>
            </form>
        <?php
		}
		?>
        </div>
    </div>
</div>
<?php
	include('footer.php');
?>
</body>
</html>

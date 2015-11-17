
<?php

	$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');

	/// use generate.php to generate a new key and paste it here.
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

	if (isset($_GET['encrypted'])) {
		echo '<div class="alert alert-info span10">';
		echo "<h2>Received encrypted data</h2><p style=\"word-wrap: break-word\">".$_GET['encrypted']."</p>";
		echo "<h2>After decreption:</h2><p>".decrypt($privatekey, $_GET['encrypted'])."</p>";
		echo '</div>';
		return;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.min.css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
	<script src="javascript/jsbn.js"></script>
	<script src="javascript/jsbn2.js"></script>
	<script src="javascript/prng4.js"></script>
	<script src="javascript/rng.js"></script>
	<script src="javascript/rsa.js"></script>
	<script src="javascript/rsa2.js"></script>
	<script>

	function encrypt() {
		var publickey = "<?=publicKeyToHex($privatekey)?>";
     	var rsakey = new RSAKey();
       	rsakey.setPublic(publickey, "10001");
		var enc = rsakey.encrypt($('#plaintext').val());

		$.get('index2.php?encrypted='+enc, function(data) {
			$('#feedback').html(data);
		});

		return;
	}

	</script>
	<title>RSA encryption/decryption demo</title>
</head>
<body>
	<div class="row-fluid">
		<div class="span10 offset1">
			<div class="page-header">
				<h1>RSA encryption/decryption <small>using <a href="http://www-cs-students.stanford.edu/~tjw/jsbn/">jsnb</a> and <a href="http://phpseclib.sourceforge.net">phpseclib</a></small></h1>
				<h2><small>Example by <a href="http://twitter.com/mvhaen">Michael Voorhaen</a></small></h2>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<form class="form-horizontal" method="post">
			  <div class="control-group">
			    <label class="control-label" for="inputEmail">Plaintext</label>
			    <div class="controls">
			      <input type="text" name="plaintext" id="plaintext" placeholder="enter something">
			    </div>
			  </div>
			</form>
		</div>
		<div class="span4">
			<button type="button" class="btn btn-primary" onclick="encrypt()">Encrypt</button>
		</div>
		<br/>
	</div>
	<div class="row-fluid">
		<div id="feedback" class="span11 offset1">

		</div>
	</div>
</body>
</html>

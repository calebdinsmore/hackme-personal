<?php
	function valid_session($cookie)
	{
    $check = mysql_query("SELECT * FROM users WHERE username = '".$cookie['hackme']."'")or die(mysql_error());
    $info = mysql_fetch_array($check);
    return password_verify($info['session'], $cookie['hackmesess']); //|| hash_equals($info['session'], "nosession");
	}
?>

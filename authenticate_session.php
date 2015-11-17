<?php
	function valid_session()
	{
    $check = mysql_query("SELECT * FROM users WHERE username = '".$_COOKIE['hackme']."'")or die(mysql_error());
    $info = mysql_fetch_array($check);
    return password_verify($info['session'], $_COOKIE['hackmesess']) || hash_equals($info['session'], "nosession");
	}
?>

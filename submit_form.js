function submitform(key)
{
  var username = document.getElementById("UN-login");
  var password = document.getElementById("PW-login");
  var publickey = "<?=publicKeyToHex($privatekey)?>";
  var rsakey = new RSAKey();
  rsakey.setPublic(publickey, "10001");
  username.value = btoa(rsakey.encrypt($('#UN-login').val()));
  password.value = btoa(rsakey.encrypt($('#PW-login').val()));
}

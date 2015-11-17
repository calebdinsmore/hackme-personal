function submitform(key)
{
  var username = document.getElementById("UN-login");
  var password = document.getElementById("PW-login");
  var encrypt = new JSEncrypt();
  encrypt.setPublicKey(public_key);
  username.value = btoa(encrypt.encrypt($('#UN-login').val()));
  password.value = btoa(encrypt.encrypt($('#PW-login').val()));
}

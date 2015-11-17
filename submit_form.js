function submitform()
{
  var public_key = "-----BEGIN PUBLIC KEY-----\
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCjFLYEjRkUPeCFbTqQZaCeq5GU\
xieUakf4MAkfBqWo9yZjAM0biaBdDmifDkCnKtJLBkmUnKFpSAQRxGY71+1Ln+Vi\
GrGzSRpItMxEnpdPdP9Hn0UfgeZ451AOFnhvC8n/xJvYfSpZhqD7eRMFE9F750xT\
N89VsJLYT9jGxoUThwIDAQAB\
-----END PUBLIC KEY-----\
";
  var username = document.getElementById("UN-login");
  var password = document.getElementById("PW-login");
  var encrypt = new JSEncrypt();
  encrypt.setPublicKey(public_key);
  username.value = btoa(encrypt.encrypt($('#UN-login').val()));
  password.value = btoa(encrypt.encrypt($('#PW-login').val()));
}

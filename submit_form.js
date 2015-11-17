function submitform()
{
  var public_key = "-----BEGIN PUBLIC KEY-----\nMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCjFLYEjRkUPeCFbTqQZaCeq5GU\nxieUakf4MAkfBqWo9yZjAM0biaBdDmifDkCnKtJLBkmUnKFpSAQRxGY71+1Ln+Vi\nGrGzSRpItMxEnpdPdP9Hn0UfgeZ451AOFnhvC8n/xJvYfSpZhqD7eRMFE9F750xT\nN89VsJLYT9jGxoUThwIDAQAB\n-----END PUBLIC KEY-----\n";
  var username = document.getElementById("UN-login");
  var password = document.getElementById("PW-login");
  var encrypt = new JSEncrypt();
  encrypt.setPublicKey(public_key);
  username.value = btoa(encrypt.encrypt($('#UN-login').val()));
  password.value = btoa(encrypt.encrypt($('#PW-login').val()));
}

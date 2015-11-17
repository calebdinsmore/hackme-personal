function submitform()
{
  var public_key = "-----BEGIN PUBLIC KEY-----\
  MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA8NijD4TTGS3mTjwgWyHh\
  IoUMd21wOGrs6iLVK0RXH8ThoR6yaeu9axop8PWnCEVd9yxWqlM4BE7RXQXiZ8gq\
  /3YOI7fJc5Xkccuv/P8GsJhOawVBhegnx0IXvqzxtexlCo4mwOuF3RdLfeU8Ll3f\
  oInGQ5Ax+paL6uiGcF3HM2uYQOfUa8LKIl1f+l6f7l910jNKlJ2F5QdZyxsSqJyT\
  njgiWY8zIgW53WpxIJJ8gaPfTKUIPwZVf/f6sXocRb+X3yWQ5K5sTrAMgastqAgi\
  ghR0jMVEd+5Rssyhp0yzN0jhpXKIlMKctQ9Vp4soK0xohWyT4byWWRdZzIETctII\
  hwIDAQAB\
  -----END PUBLIC KEY-----\
";
  var username = document.getElementById("UN-login");
  var password = document.getElementById("PW-login");
  var encrypt = new JSEncrypt();
  encrypt.setPublicKey(public_key);
  username.value = btoa(encrypt.encrypt($('#UN-login').val()));
  password.value = btoa(encrypt.encrypt($('#PW-login').val()));
}

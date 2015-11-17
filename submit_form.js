function submitform()
{
  var public_key = "-----BEGIN PUBLIC KEY-----\
	MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDD3aqfqP0Wj0MK/SOq5HFZn8jO\
	ooczlRSz9qAFZOKOuUVPzd7oGH1iuWJwts+i3m5TL5J3RzcDxM6rioSVF//TB383\
	cDtKvaTgpW+ulRTvIXUbNDa6a5s7TPZvrdR1C8eRHW76UDxhE/K9/K+iW69U6mCJ\
	YG5gElQTvRTq3i7RLQIDAQAB\
	-----END PUBLIC KEY-----<"
  var password = document.getElementById("PW-login");
  var encrypt = new JSEncrypt();
  encrypt.setPublicKey(public_key);
  password.value = encrypt.encrypt($('#PW-login').val());
  console.log(encrypted);
}

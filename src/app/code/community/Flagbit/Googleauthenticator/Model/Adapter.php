<?php

include_once("Googleauthenticator/FixedByteNotation.php");
include_once("Googleauthenticator/GoogleAuthenticator.php");

class Flagbit_Googleauthenticator_Model_Adapter {
	
	protected $_authenticator = null;
	
	public function __construct($options = array())
	{
		$this->_authenticator = new GoogleAuthenticator();	
	}
	
	public function checkVerificationCode($code, $secret)
	{
		return $this->_authenticator->checkCode($secret,$code); 
	}
	
	public function generateSecret()
	{
		return $this->_authenticator->generateSecret();
	}
	
}
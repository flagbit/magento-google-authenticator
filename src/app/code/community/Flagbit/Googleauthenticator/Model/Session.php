<?php

class Flagbit_Googleauthenticator_Model_Session extends Mage_Admin_Model_Session
{
    /**
     * Try to login user in admin
     *
     * @param  string $username
     * @param  string $password
     * @param  Mage_Core_Controller_Request_Http $request
     * @return Mage_Admin_Model_User|null
     */
    public function login($username, $password, $request = null)
    {
        if (empty($username) || empty($password)) {
            return;
        }
        if($request instanceof Mage_Core_Controller_Request_Http) {
        	
	        /* @var $user Mage_Admin_Model_User */
	        $user = Mage::getModel('admin/user'); 

	        $user->loadByUsername($username);
	        $logindata = $request->getParam('login');
	        
	        if($user->getGoogleauthenticatorSecret()){
	        	try {
	        		$ga_result = Mage::getModel('flagbit_googleauthenticator/adapter')
            			->checkVerificationCode(
            				isset($logindata['verificationcode']) ? $logindata['verificationcode'] : '',
            				$user->getGoogleauthenticatorSecret()
            			);
            			
            		if(!$ga_result){
						Mage::throwException(Mage::helper('flagbit_googleauthenticator')->__('Invalid Verification Code'));            			
            		}
	        	}
		        catch (Mage_Core_Exception $e) {
		            Mage::dispatchEvent('admin_session_user_login_failed',
		                    array('user_name' => $username, 'exception' => $e));
		            if ($request && !$request->getParam('messageSent')) {
		                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		                $request->setParam('messageSent', true);
		            }
		            return $user;
		        }       	
	        }
        }
        return parent::login($username, $password, $request);
    }
}

<?php

class Flagbit_Googleauthenticator_Model_Observer {
	
	public function addUserAuthTab(Varien_Event_Observer $observer)
	{
        /*@var $block Mage_Adminhtml_Block_Permissions_User_Edit_Tabs */
        $block = $observer->getBlock(); 
        
        if($block instanceof Mage_Adminhtml_Block_Permissions_User_Edit_Tabs){
        	
        	// add JS qrcode Lib
        	$block->getLayout()->getBlock('head')
        					->addJs('googleauthenticator/qrcode.js')
        					->addJs('googleauthenticator/html5-qrcode.js');
        	
        	// add googleauthenticator Tab
	        $block->addTabAfter('auth_section', array(
	            'label'     => Mage::helper('adminhtml')->__('Google Authenticator'),
	            'title'     => Mage::helper('adminhtml')->__('Google Authenticator'),
	            'content'   => $block->getLayout()->createBlock('flagbit_googleauthenticator/adminhtml_permissions_user_edit_tab_auth', 'user.auth.form')->toHtml(),
	        ),
	        'roles_section'); 
        }		
	}
	
	
}
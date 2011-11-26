<?php

include_once("Mage/Adminhtml/controllers/Permissions/UserController.php");

class Flagbit_Googleauthenticator_Adminhtml_Permissions_UserController extends Mage_Adminhtml_Permissions_UserController
{

	public function generatesecretAction()
	{
		$this->getResponse()->setBody(
			Mage::getModel('flagbit_googleauthenticator/adapter')->generateSecret()
		);
	}
}

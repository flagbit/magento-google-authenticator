<?php
include_once("Mage/Adminhtml/controllers/IndexController.php");


class Flagbit_Googleauthenticator_Adminhtml_IndexController extends Mage_Adminhtml_IndexController
{
    public function loginAction()
    {
		parent::loginAction();
		
		// inject google authenticator field
		$block = $this->getLayout()->createBlock('adminhtml/template')->setTemplate("googleauthenticator/login.phtml");
		$orgBody = $this->getResponse()->getBody();
		$this->getResponse()->setBody(str_replace('</body>', $block->toHtml().'</body>', $orgBody));
    }

}

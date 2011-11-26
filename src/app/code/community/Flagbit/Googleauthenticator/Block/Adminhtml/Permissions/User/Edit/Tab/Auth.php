<?php


class Flagbit_Googleauthenticator_Block_Adminhtml_Permissions_User_Edit_Tab_Auth extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $model = Mage::registry('permissions_user');

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('googleauthenticator_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('adminhtml')->__('Google Authenticator')));

        $secretField = $fieldset->addField('secret', 'text', array(
            'name'  => 'googleauthenticator_secret',
            'label' => Mage::helper('adminhtml')->__('Secret Key'),
            'id'    => 'secret',
            'title' => Mage::helper('adminhtml')->__('Secret Key'),
            'note'	=> 'Leave empty to disable Google Authenticator',
            'value' => $model->getGoogleauthenticatorSecret()
        ));

        $generatorField = $fieldset->addField('generator', 'button', array(
            'name'  => 'generator',
            'id'    => 'generator',
        	'value' => Mage::helper('adminhtml')->__('generate Secret Key'),
        ));   

	    $generatorField->setRenderer($this->getLayout()
	        									->createBlock('adminhtml/widget_form_renderer_fieldset_element')
                   								->setTemplate('googleauthenticator/generator.phtml')
                   								->setServerName($this->getRequest()->getServer('HTTP_HOST'))
                   								->setUsername($model->getUsername())
                   						);  
	        

        
        // Setting custom renderer for content field to remove label column
        /*
        $renderer = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset_element')
                    ->setTemplate('cms/page/edit/form/renderer/content.phtml');
        $secretField->setRenderer($renderer);        
        */
               
        $data = $model->getData();

        //$form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }
}

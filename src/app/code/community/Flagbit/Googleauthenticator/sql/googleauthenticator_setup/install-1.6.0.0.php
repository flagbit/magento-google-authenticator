<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer->startSetup();

$installer->getConnection()->addColumn($this->getTable('admin/user'), 'googleauthenticator_secret', 'VARCHAR(32) NULL');

$installer->endSetup();

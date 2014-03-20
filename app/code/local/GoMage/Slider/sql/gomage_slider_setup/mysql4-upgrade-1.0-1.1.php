<?php
 /**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2012 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.1
 */

$installer = $this;

$installer->startSetup();
$installer->getConnection()->addColumn($this->getTable('gomage_slider_items'), 'slider_code',
    "varchar(255) NOT NULL");
$installer->endSetup(); 
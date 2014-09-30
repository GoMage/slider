<?php
 /**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2014 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.1
 */

class GoMage_Slider_Model_Mysql4_Block extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('gomage_slider/block', 'id');
    }
    
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        $storesArray = explode(',', $object->getData('store_ids'));
        $object->setData('store_id_arr', $storesArray);
        return parent::_afterLoad($object);
    }
    
}
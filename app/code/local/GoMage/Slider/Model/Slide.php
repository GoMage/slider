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
class GoMage_Slider_Model_Slide extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('gomage_slider/slide');
    }

    public function isActive()
    {
        $h = Mage::helper('gomage_slider');
        if (!in_array(Mage::app()->getStore()->getWebsiteId(), $h->getAvailavelWebsites())) {
            return false;
        }

        if ($this->getStartDate() && (strtotime($this->getStartDate()) > strtotime(Mage::getModel('core/date')->gmtDate('Y-m-d')))) {
            return false;
        }

        if ($this->getEndDate() && (strtotime($this->getEndDate()) < strtotime(Mage::getModel('core/date')->gmtDate('Y-m-d')))) {
            return false;
        }

        return true;
    }

    public function openSliderLinkInBlank()
    {
        if ($this->getOpenSliderLinkIn() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Slide_Opensliderlinkin::NEW_WINDOW) {
            return 'target="_blank"';
        }
        return '';
    }

}
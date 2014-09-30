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
class GoMage_Slider_Model_Block extends Mage_Core_Model_Abstract
{
    const EFFECT_SIMPLE            = 'SIMPLE';
    const EFFECT_VERTICAL_SPLIT    = 'VERTICAL_SPLIT';
    const EFFECT_HORIZONTAL_SPLIT  = 'HORIZONTAL_SPLIT';
    const EFFECT_WIPE_RIGHT        = 'WIPE_RIGHT';
    const EFFECT_WIPE_LEFT         = 'WIPE_LEFT';
    const EFFECT_WIPE_UP           = 'WIPE_UP';
    const EFFECT_WIPE_DOWN         = 'WIPE_DOWN';
    const EFFECT_PAGE_FLIP         = 'PAGE_FLIP';
    const EFFECT_HORIZONTAL_PANELS = 'HORIZONTAL_PANELS';
    const EFFECT_VERTICAL_PANELS   = 'VERTICAL_PANELS';

    public function _construct()
    {
        parent::_construct();
        $this->_init('gomage_slider/block');
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

        if (!in_array(Mage::app()->getStore()->getId(), explode(',', $this->getStoreIds()))) {
            return false;
        }

        return true;
    }

    public function containerCssStyle()
    {
        $css = '';
        if ($this->getShowNavigationBar() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Show::SIDEBAR) {
            switch ($this->getNavigationBarAlignment()) {
                case GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::RIGHT :
                    $css .= 'margin-right: ' . $this->getSidebarWidth() . 'px;';
                    break;
                case GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::LEFT :
                    $css .= 'margin-left: ' . $this->getSidebarWidth() . 'px;';
                    break;
            }
        }
        return $css;
    }

    public function blockCss()
    {
        return 'max-width: ' . $this->getBlockWidth() . 'px; max-height: ' . $this->getBlockHeight() . 'px;';
    }

    public function sideBarCss()
    {
        if ($this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
            &&
            $this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM
        ) {
            $css = 'width: ' . intval($this->getSidebarWidth()) . 'px;  height: ' . $this->getSidebarHeight() . 'px; ';
        } else {
            $css = '';
        }

        switch ($this->getNavigationBarAlignment()) {
            case GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::RIGHT :
                $css .= 'float: right;';
                break;

            case GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::LEFT :
                $css .= 'float: left;';
                break;

            case GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP :
                $css .= 'clear: both;';
                break;
        }

        return $css;
    }

    public function sideBarBlockCss()
    {
        $height = $this->getData('sidebar_height');
        $width  = $this->getData('sidebar_width');
        $css    = 'height: ' . $height . 'px;';
        $css .= 'width:' . $width . 'px;';

        if ($this->getNavigationBarAlignment() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
            ||
            $this->getNavigationBarAlignment() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM
        ) {
            $css .= 'float: left;';
        }

        return $css;
    }
}



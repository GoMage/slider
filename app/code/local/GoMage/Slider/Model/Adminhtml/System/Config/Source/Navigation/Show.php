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
	
class GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Show{

    
    const NO = 1;
    const SIDEBAR = 2;
    const SQUARE = 4;
    const CIRCLE = 5;
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
        	array('value' => self::NO, 'label'=>$helper->__('No')),
            array('value' => self::SIDEBAR, 'label'=>$helper->__('Sidebar')),
            array('value' => self::SQUARE, 'label'=>$helper->__('Square')),
            array('value' => self::CIRCLE, 'label'=>$helper->__('Circle')),
        );
    }
    
	public static function toOptionHash()
    {    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
        	self::NO => $helper->__('no'),
            self::SIDEBAR => $helper->__('sidebar'),
            self::SQUARE => $helper->__('square'),
            self::CIRCLE => $helper->__('circle'),
        );
    }
}
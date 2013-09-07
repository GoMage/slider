<?php
 /**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2012 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.0
 */
	
class GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Type{

    
    const SQUARE = 2;
    const CIRCLE = 3;
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            array('value' => self::SQUARE, 'label'=>$helper->__('Square')),
            array('value' => self::CIRCLE, 'label'=>$helper->__('Circle')),
        );
    }
    
	public static function toOptionHash()
    {    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            self::SQUARE => $helper->__('Square'),
            self::CIRCLE => $helper->__('Circle')
        );
    }

}
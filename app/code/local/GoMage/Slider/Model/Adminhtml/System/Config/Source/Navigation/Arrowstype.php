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
	
class GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Arrowstype{

    const STYLE1 = 1;
    const STYLE2 = 2;
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            array('value' => self::STYLE1, 'label'=>$helper->__('Style 1')),
            array('value' => self::STYLE2, 'label'=>$helper->__('Style 2')),
        );
    }
    
	public static function toOptionHash()
    {    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            self::STYLE1 => $helper->__('Style 1'),
            self::STYLE2 => $helper->__('Style 2')
        );
    }

}
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
	
class GoMage_Slider_Model_Adminhtml_System_Config_Source_Slide_Windowalignment{

    
    const LEFT = 1;
    const RIGHT = 2;
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            array('value' => self::LEFT, 'label'=>$helper->__('Left')),
            array('value' => self::RIGHT, 'label'=>$helper->__('Right')),
        );
    }
    
	public static function toOptionHash()
    {    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            self::LEFT => $helper->__('Left'),
            self::RIGHT => $helper->__('Right'),
        );
    }

}
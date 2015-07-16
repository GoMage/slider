<?php
 /**
 * GoMage Slide Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2014 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.2
 */
	
class GoMage_Slider_Model_Adminhtml_System_Config_Source_Enableautostart{

    
    const YES = 1;
    const NO = 2;
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            array('value' => self::YES, 'label'=>$helper->__('Yes')),
            array('value' => self::NO, 'label'=>$helper->__('No')),
        );
    }
    
	public static function toOptionHash()
    {    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            self::YES => $helper->__('Yes'),
            self::NO => $helper->__('No')
        );
    }

}
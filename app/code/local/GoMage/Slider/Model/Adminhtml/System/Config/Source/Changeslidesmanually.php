<?php
 /**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2014 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.2
 */
	
class GoMage_Slider_Model_Adminhtml_System_Config_Source_Changeslidesmanually{

    
    const CLICK = 1;
    const OVER = 2;
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            array('value' => self::CLICK, 'label'=>$helper->__('Mouse Click')),
            array('value' => self::OVER, 'label'=>$helper->__('Mouse Over')),
        );
    }
    
	public static function toOptionHash()
    {    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            self::CLICK => $helper->__('Mouse Click'),
            self::OVER => $helper->__('Mouse Over')
        );
    }

}
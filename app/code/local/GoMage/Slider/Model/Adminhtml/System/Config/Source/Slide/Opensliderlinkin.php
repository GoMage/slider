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
	
class GoMage_Slider_Model_Adminhtml_System_Config_Source_Slide_Opensliderlinkin{

    
    const NOTSET = 1;
    const SAME_WINDOW = 2;
    const NEW_WINDOW = 3;
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            array('value' => self::NOTSET, 'label'=>$helper->__('Not Set')),
            array('value' => self::SAME_WINDOW, 'label'=>$helper->__('Same Window')),
            array('value' => self::NEW_WINDOW, 'label'=>$helper->__('New Window')),
        );
    }
    
	public static function toOptionHash()
    {    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
            self::NOTSET => $helper->__('Not Set'),
            self::SAME_WINDOW => $helper->__('Same Window'),
            self::NEW_WINDOW => $helper->__('New Window')
        );
    }

}
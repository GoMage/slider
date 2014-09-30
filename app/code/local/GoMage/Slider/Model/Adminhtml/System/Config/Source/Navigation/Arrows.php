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
	
class GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Arrows{

    const NO = 1;
    const ALWAYS = 2;
    const MOUSE = 3;
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
            array('value' => self::ALWAYS, 'label'=>$helper->__('Yes, always')),
            array('value' => self::MOUSE, 'label'=>$helper->__('Yes, mouse over')),
        );
    }
    
	public static function toOptionHash()
    {    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
        	self::NO => $helper->__('No'),
            self::ALWAYS => $helper->__('Yes, always'),
            self::MOUSE => $helper->__('Yes, mouse over')
        );
    }

}
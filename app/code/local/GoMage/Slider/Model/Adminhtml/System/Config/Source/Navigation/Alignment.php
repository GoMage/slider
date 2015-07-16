<?php
 /**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2015 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.2
 */
	
class GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment{

    
    const LEFT = 1;
    const RIGHT = 2;
    const TOP = 3;
    const BOTTOM = 4;
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
        	array('value' => self::BOTTOM, 'label'=>$helper->__('Bottom')),
        	array('value' => self::RIGHT, 'label'=>$helper->__('Right')),
            array('value' => self::LEFT, 'label'=>$helper->__('Left')),
            array('value' => self::TOP, 'label'=>$helper->__('Top')),
        );
    }
    
	public static function toOptionHash()
    {    	
    	$helper = Mage::helper('gomage_slider');
    	
        return array(
        	self::BOTTOM => $helper->__('bottom'),
        	self::RIGHT => $helper->__('right'),
            self::LEFT => $helper->__('left'),
            self::TOP => $helper->__('top'),
        );
    }
    
	public static function getClassName($id)
    {
    	$array = array(self::BOTTOM => 'bottom',
        			   self::RIGHT => 'right',
            		   self::LEFT => 'left',
            		   self::TOP => 'top');
            		   
		if ( isset( $array[$id] ) )
		{
			return $array[$id];
		}            		  

		return '';
    }

}
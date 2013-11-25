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

class GoMage_Slider_Model_Item extends Mage_Core_Model_Abstract
{	
	const EFFECT_SIMPLE = 1;
    const EFFECT_VERTICAL_SPLIT = 2;
    const EFFECT_HORIZONTAL_SPLIT = 3;
    const EFFECT_WIPE_RIGHT = 4;
    const EFFECT_WIPE_LEFT = 5;
    const EFFECT_WIPE_UP = 6;
    const EFFECT_WIPE_DOWN = 7;
    const EFFECT_PAGE_FLIP = 8;
    const EFFECT_HORIZONTAL_PANELS = 9;
    const EFFECT_VERTICAL_PANELS = 10;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('gomage_slider/item');
    }
    
	public function isActive()
    {   
        $h = Mage::helper('gomage_slider');
		if(!in_array(Mage::app()->getStore()->getWebsiteId(), $h->getAvailavelWebsites())) return false;
				             
        if ($this->getStartDate() && (strtotime($this->getStartDate()) > strtotime(Mage::getModel('core/date')->gmtDate('Y-m-d'))) )
            return false;

        if ($this->getEndDate() && (strtotime($this->getEndDate()) < strtotime(Mage::getModel('core/date')->gmtDate('Y-m-d'))) )
            return false;
            
        if (!in_array(Mage::app()->getStore()->getId(), explode(',', $this->getStoreIds())))
            return false;  
                
        return true;
    }
    
	public function containerCss()
    {
    	if ( $this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
	    			&&
    		 $this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM )
    	{
    		$width = intval($this->getBlockWidth()) - intval($this->getSidebarWidth());
    	}
    	else 
    	{
    		$width = intval($this->getBlockWidth());
    	}
    	
    	$css = 'width: ' . $width . 'px;';
    	
    	return $css;
    }
    
	public function containerCssStyle()
    {

        if ( $this->getShowNavigationBar() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Show::SIDEBAR )
    	{
            $clear = '';
	    	if ( $this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
		    			&&
	    		 $this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM )
	    	{
	    		$width = intval($this->getBlockWidth()) - intval($this->getSidebarWidth());
	    		$height = intval($this->getBlockHeight());
	    	}
	    	else 
	    	{
	    		$width = intval($this->getBlockWidth());
	    		$height = intval($this->getBlockHeight()) - intval($this->getSidebarHeight());
	    		$clear = 'clear:both;';
	    	}
	    	
	    	$css = 'width: ' . $width . 'px; height: ' . $height . 'px;' . $clear;
	    	
	    	switch ($this->getNavigationBarAlignment())
	    	{
	    		case GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::RIGHT :
	    			$css .= 'float: left;';
	    		break;
	    		
	    		case GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::LEFT :
	    			$css .= 'float: right;';
	    		break;
	    	}
    	}
    	else 
    	{
    		$width = intval($this->getBlockWidth());
    		$css = 'width: ' . $width . 'px;';
    	}
    	
    	return $css;
    }
    
	public function imageCss()
    {
    	if ( $this->getShowNavigationBar() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Show::SIDEBAR )
    	{
	    	if ( $this->getNavigationBarAlignment() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
	    			||
	    		 $this->getNavigationBarAlignment() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM )
	    	{
	    		$width = intval($this->getBlockWidth());
	    		
	    		$height = intval($this->getBlockHeight()) - (intval($this->getSidebarHeight()) );
	    	}
	    	else 
	    	{
	    		$width = intval($this->getBlockWidth()) - intval($this->getSidebarWidth());
	    		$height = intval($this->getBlockHeight());
	    	}
    	}
    	else 
    	{
    		$width = intval($this->getBlockWidth());
    		$height = intval($this->getBlockHeight());
    	}
    	
    	return 'width: ' . $width . 'px; height: ' . $height . 'px;';
    }
    
	public function contentCss()
    {
    	if ( $this->getShowNavigationBar() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Show::SIDEBAR )
    	{
	    	if ( $this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
		    			&&
	    		 $this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM )
	    	{
	    		$width = intval($this->getBlockWidth()) - intval($this->getSidebarWidth());
	    	}
	    	else 
	    	{
	    		$width = intval($this->getBlockWidth());
	    	}
    	}
    	else 
    	{
    		$width = intval($this->getBlockWidth());
    	}

    	return 'width: ' . $width . 'px;';
    }
    
	public function blockCss()
    {	
    	return 'width: ' . $this->getBlockWidth() . 'px; height: ' . $this->getBlockHeight() . 'px;';
    }
    
	public function sideBarCss()
    {
    	if ( $this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
    			&&
    		 $this->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM )
        {
    		$css = 'width: ' . intval($this->getSidebarWidth()) . 'px;'; 	 	
    	}
    	else 
    	{
    		$css = '';
    	}
    	
    	switch ($this->getNavigationBarAlignment())
    	{
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
    
	public function sideBarItemCss()
    {
    	$slides = json_decode($this->getSlides(), true);
    	$count = count($slides);
    	$height = $this->getData('sidebar_height');
    	$width = $this->getData('sidebar_width');
    	$css = 'height: ' . $height . 'px;';
    	$css .= 'width:' . $width . 'px;';
    	
    	if ( $this->getNavigationBarAlignment() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
    			||
    		 $this->getNavigationBarAlignment() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM )
        {
    		$css .= 'float: left;'; 	 	
    	}
    	
    	return $css;
    }
}



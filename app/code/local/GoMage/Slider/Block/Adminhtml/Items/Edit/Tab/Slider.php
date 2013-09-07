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

class GoMage_Slider_Block_Adminhtml_Items_Edit_Tab_Slider extends Mage_Adminhtml_Block_Template
{	
	
	protected $_config;
	
	public function __construct()
    {
        parent::__construct();                        
        $this->getConfig()->setParams(array('form_key' => $this->getFormKey()));
    } 
    
    public function getSlides()
    {
    	$collection = Mage::getModel('gomage_slider/slide')->getCollection();
    	
    	$data = array();
    	
    	if ( $collection )
    	{
    		$i = 1;
    		foreach($collection as $item)
    		{
    			$data[$i]['id'] = $item->getId();
    			$data[$i]['name'] = $item->getName();
    			$i++;
    		}
    	}
    	
    	return $data;
    }
    
    public function getBlockSlides()
    {
    	if ( Mage::registry('gomage_slider') )
    	{
	    	$block_id = Mage::registry('gomage_slider')->getId();
	    	
	    	$block = Mage::getModel('gomage_slider/item')->load($block_id);
	    	
	    	return $block->getSlides();
    	}
    	
    	return false;
    }  
    
	public function getConfig()
    {
        if(is_null($this->_config)) {
            $this->_config = new Varien_Object();
        }

        return $this->_config;
    }
}
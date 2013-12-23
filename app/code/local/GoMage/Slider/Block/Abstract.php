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
	
class GoMage_Slider_Block_Abstract extends Mage_Core_Block_Template{

	protected $_config = array(); 
    protected $_items = null;
    protected $_slides = null;
    protected $_slidesjs = null;
    protected $_block_id = null;
    protected $_slides_count = 0;
    
    protected function _setBlockId($block_id)
    {
    	$this->_block_id = $block_id;
    }
    
    public function getBlockId($block_code)
    {
    	return $this->getItems($block_code)->getId();
    }
    
    public function getItems($block_code = null)
    {	
    	
        if (is_null($this->_items)){
        
            $collection = Mage::getResourceModel('gomage_slider/item_collection')
                    		->addFieldToFilter('status', 1);
            
            foreach ($collection as $item){
            	if ( $item->isActive() )
            	{
            		if ( $block_code == $item->getCode() )
            		{
		                $this->_items[$item->getCode()] = $item;  
		                $this->getBlockConfig($item);
		                $this->_setBlockId($item->getId());
            		}
            	}                               
            }                   
        }
        
        if ( $block_code !== null && isset($this->_items[$block_code]) )
        {
        	return $this->_items[$block_code];
        }
        
        return $this->_items;
    }     
    
    public function getSlides($blockItem)
    {
    	$slides = json_decode($blockItem->getSlides(), true);
    	
    	if ( !empty($slides) )
    	{
    		$ids = array();
    		$slide_array = array();
    		foreach( $slides as $slide )
    		{
    			$ids[] = $slide['id'];
    			$slide_array[$slide['id']] = $slide;	
    		}
    		
    		$collection = Mage::getResourceModel('gomage_slider/slide_collection')
		        						->addFieldToFilter('status', 1)
		        						->addFieldToFilter('id', array( 'in' => $ids ));

		        
	        foreach ($collection as $item)
	        {
	        	if ( $item->isActive() )
	        	{
	            	$this->getSlideConfig($item, $slide_array[$item->getId()], $blockItem->getId());
	            	$this->getSlideConfigJs($item, $slide_array[$item->getId()], $blockItem->getId());
	            	$this->_slides_count++;
	        	}                               
	        }
	        
    	}
    }
    
    public function getSlidesCount()
    {
    	return $this->_slides_count;
    }
}
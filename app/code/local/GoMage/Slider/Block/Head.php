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
	
class GoMage_Slider_Block_Head extends Mage_Core_Block_Template{
    
    protected $_items = null;
    
    public function __construct()
    {
        parent::__construct();
        $items = $this->getItems();
        if (count($items)){
        	$this->setTemplate('gomage/slider/head/styles.phtml');
        } 

    }
    
    public function getItems()
    {
    	
        if (is_null($this->_items)){
            $collection = Mage::getResourceModel('gomage_slider/item_collection')
                    		->addFieldToFilter('status', 1);                    		
            
            foreach ($collection as $item){
                $this->_items[] = $item;                                 
            }                   
        }

        return $this->_items;
    }  
}
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
	
class GoMage_Slider_Model_Observer{
	
	static public function checkK($event)
    {			
		$key = Mage::getStoreConfig('gomage_activation/slider/key');			
		Mage::helper('gomage_slider')->a($key);			
	} 
	
}
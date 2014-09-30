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

class GoMage_Slider_Block_Adminhtml_Blocks_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    
    public function __construct(){
    	
        parent::__construct();
        $this->setId('gomage_slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Slider Information'));
        
    }
    
    protected function _prepareLayout(){
         
        $this->addTab('main_section', array(
            'label'     =>  $this->__('Block information'),
            'title'     =>  $this->__('Block information'),
            'content'   =>  $this->getLayout()->createBlock('gomage_slider/adminhtml_blocks_edit_tab_main')->toHtml(),
        ));
        
        $this->addTab('slider_settings', array(
		            'label'     =>  $this->__('Slides'),
		            'title'     =>  $this->__('Slides'),
		            'content'   =>  $this->getLayout()->createBlock('gomage_slider/adminhtml_blocks_edit_tab_slider')->setTemplate('gomage/slider/block/edit/slider-settings.phtml')->toHtml(),
		        ));
        
        $this->addTab('navigation_bar', array(
            'label'     =>  $this->__('Navigation Bar'),
            'title'     =>  $this->__('Navigation Bar'),
            'content'   =>  $this->getLayout()->createBlock('gomage_slider/adminhtml_blocks_edit_tab_navigation')->toHtml(),
        ));
        
        if($tabId = addslashes(htmlspecialchars($this->getRequest()->getParam('tab')))){
        	
        	$this->setActiveTab($tabId);
        }
        
        
        return parent::_beforeToHtml();
        
    }
       
}
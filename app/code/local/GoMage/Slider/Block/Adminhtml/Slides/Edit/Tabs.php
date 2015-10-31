<?php
 /**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2015 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.3
 */

class GoMage_Slider_Block_Adminhtml_Slides_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    
    public function __construct(){
    	
        parent::__construct();
        $this->setId('gomage_slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Slider Slides Information'));
        
    }
    
    protected function _prepareLayout(){
         
        $this->addTab('main_section', array(
            'label'     =>  $this->__('Slide information'),
            'title'     =>  $this->__('Slide information'),
            'content'   =>  $this->getLayout()->createBlock('gomage_slider/adminhtml_slides_edit_tab_main')->toHtml(),
        ));
        
        $this->addTab('slider_settings', array(
            'label'     =>  $this->__('Content Settings'),
            'title'     =>  $this->__('Content Settings'),
            'content'   =>  $this->getLayout()->createBlock('gomage_slider/adminhtml_slides_edit_tab_content')->toHtml(),
        ));
        
        $this->addTab('sidebar_content', array(
            'label'     =>  $this->__('Sidebar Content'),
            'title'     =>  $this->__('Sidebar Content'),
            'content'   =>  $this->getLayout()->createBlock('gomage_slider/adminhtml_slides_edit_tab_sidebarcontent')->toHtml(),
        ));
        
        $this->addTab('description', array(
            'label'     =>  $this->__('Description'),
            'title'     =>  $this->__('Description'),
            'content'   =>  $this->getLayout()->createBlock('gomage_slider/adminhtml_slides_edit_tab_description')->toHtml(),
        ));
        
        if($tabId = addslashes(htmlspecialchars($this->getRequest()->getParam('tab')))){
        	
        	$this->setActiveTab($tabId);
        }
        
        
        return parent::_beforeToHtml();
        
    }
       
}
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

class GoMage_Slider_Block_Adminhtml_Slides_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct(){
    	
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'gomage_slider';
        $this->_controller = 'adminhtml_slides';
        
        $this->_updateButton('save', 'label', $this->__('Save'));
        $this->_updateButton('delete', 'label', $this->__('Delete'));			
		
        $this->_addButton('saveandcontinue', array(
            'label'     => $this->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);         
        
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('window_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'window_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'window_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
            
        "; 
        
        
        
    }
    
    public function getHeaderText(){
    	
        if( Mage::registry('gomage_slider') && Mage::registry('gomage_slider')->getId() ) {
            return $this->__("Edit %s", $this->htmlEscape(Mage::registry('gomage_slider')->getName()));
        } else {
            return $this->__('Add Slide');
        }
        
    }
}
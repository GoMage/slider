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

class GoMage_Slider_Block_Adminhtml_Slides_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{
  
  protected function _prepareForm(){
  	  
		$form = new Varien_Data_Form(array(
	    	'id'        =>  'edit_form',
	    	'action'    =>  $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
	    	'method'    =>  'post',
	    	'enctype'   =>  'multipart/form-data'
		));
        
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
        
    }
    
}
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

class GoMage_Slider_Block_Adminhtml_Slides_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_slider')){
            $slide = Mage::registry('gomage_slider');
        }else{
            $slide = new Varien_Object();
        }
        
        $this->setForm($form);
        $fieldset = $form->addFieldset('main_fieldset', array('legend' => $this->__('Slide information')));

        $this->_setFieldset(array(), $fieldset);
        
        $fieldset->addField('status', 'select',
            array(
                'name'   => 'status',
                'label'  => $this->__('Status'),                
                'values' => Mage::getModel('adminhtml/system_config_source_enabledisable')->toOptionArray(), 
            )
        );

        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => $this->__('Name'),
            'title'     => $this->__('Name'),
            'required'  => true,  
 		    'note'	    => $this->__('Uses only in Admin Panel.'),    	
        ));
        
        $fieldset->addField('start_date', 'date', array(
            'label'     => $this->__('Active From'),
            'name'      => 'start_date', 
            'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),            
        ));
        
        $fieldset->addField('end_date', 'date', array(
            'label'     => $this->__('Active To'),
            'name'      => 'end_date', 
            'format'    => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),            
        ));
        
        $form->setValues($slide->getData());
        
        return parent::_prepareForm();
        
    }
        
}
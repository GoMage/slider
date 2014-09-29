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

class GoMage_Slider_Block_Adminhtml_Blocks_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();

        if(Mage::registry('gomage_slider')){
        	$block = Mage::registry('gomage_slider');
        }else{
            $block = new Varien_Object();
        }
        
        $this->setForm($form);
        $fieldset = $form->addFieldset('main_fieldset', array('legend' => $this->__('Block information')));

        $this->_setFieldset(array(), $fieldset);
        
        $fieldset->addField('status', 'select',
            array(
                'name'   => 'status',
                'label'  => $this->__('Status'),                
                'values' => Mage::getModel('adminhtml/system_config_source_enabledisable')->toOptionArray(), 
            )
        );
     	     	
    	$fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => $this->__('Block Name'),
            'title'     => $this->__('Block Name'),
            'required'  => true,  
 		    'note'	    => $this->__('For internal use.'),    	
        ));

        $fieldset->addField('slider_code', 'hidden', array(
            'name'      => 'slider_code',
        ));

        $fieldset->addField('code', 'text', array(
            'name'      => 'code',
            'label'     => $this->__('Block Code'),
            'title'     => $this->__('Block Code'),
            'required'  => true,  
 		    'note'	    => $this->__('For internal use. Must be unique with no spaces.'),    	
        ));
        
        $fieldset->addField('store_ids', 'multiselect', array(
            'label'     => $this->__('Store View'),
            'required'  => true,
            'name'      => 'store_ids[]',
            'values'    => Mage::getModel('gomage_slider/adminhtml_system_config_source_store')->getStoreValuesForForm(),
        )); 

        $fieldset->addField('block_width', 'text', array(
            'name'      => 'block_width',
            'label'     => $this->__('Block Width, px'),
            'title'     => $this->__('Block Width, px'),
        ));
        
        $fieldset->addField('block_height', 'text', array(
            'name'      => 'block_height',
            'label'     => $this->__('Block Height,px'),
            'title'     => $this->__('Block Height,px'),
        ));
        
        $fieldset->addField('delay_time', 'text', array(
            'name'      => 'delay_time',
            'label'     => $this->__('Delay Time'),
            'title'     => $this->__('Delay Time'),
        ));
        
        $fieldset->addField('transition_time', 'text', array(
            'name'      => 'transition_time',
            'label'     => $this->__('Transition Time'),
            'title'     => $this->__('Transition Time'),
        ));
        
        $fieldset->addField('enable_autostart', 'select',
            array(
                'name'   => 'enable_autostart',
                'label'  => $this->__('Enable Autostart'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
            )
        );
        
        $fieldset->addField('show_pause_button', 'select',
            array(
                'name'   => 'show_pause_button',
                'label'  => $this->__('Show Start/Pause Button'),                
                'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray(),
            )
        );
        
        $fieldset->addField('change_slides_manually', 'select',
            array(
                'name'   => 'change_slides_manually',
                'label'  => $this->__('Change Slides Manually'),                
                'values' => Mage::getModel('gomage_slider/adminhtml_system_config_source_changeslidesmanually')->toOptionArray(), 
            )
        );
        
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

       $data = $block->getData();
       $form->setValues($data);

        return parent::_prepareForm();
        
    }
        
}
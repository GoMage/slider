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

class GoMage_Slider_Block_Adminhtml_Slides_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget_Form
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
        $fieldset = $form->addFieldset('main_fieldset', array('legend' => $this->__('Content Settings')));

        $this->_setFieldset(array(), $fieldset);
        
        $fieldset->addField('image', 'sliderimg',
            array(
                'name'   => 'image',
                'label'  => $this->__('Image'),                                 
            )
        );
        
        $fieldset->addField('open_slider_link_in', 'select',
            array(
                'name'   => 'open_slider_link_in',
                'label'  => $this->__('Open Slider Link in'),                
                'values' => Mage::getModel('gomage_slider/adminhtml_system_config_source_slide_opensliderlinkin')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('alt_text', 'text', array(
            'name'      => 'alt_text',
            'label'     => $this->__('Alternative Text'),
            'title'     => $this->__('Alternative Text'),
        ));
        
        $fieldset->addField('slider_link', 'text', array(
            'name'      => 'slider_link',
            'label'     => $this->__('Slide Link'),
            'title'     => $this->__('Slide Link'),
        ));
       
        $form->setValues($slide->getData());
        
        return parent::_prepareForm();
        
    }
        
	protected function _getAdditionalElementTypes()
    {      
        return array(
            'sliderimg' => Mage::getConfig()->getBlockClassName('gomage_slider/adminhtml_helper_image')
        );
    }
}
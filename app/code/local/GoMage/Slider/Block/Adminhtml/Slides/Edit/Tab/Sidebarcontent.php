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

class GoMage_Slider_Block_Adminhtml_Slides_Edit_Tab_Sidebarcontent extends Mage_Adminhtml_Block_Widget_Form
{
	
	protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
	
    protected function _prepareForm()
    {
        
        $form = new Varien_Data_Form();
        
        if(Mage::registry('gomage_slider')){
            $slide = Mage::registry('gomage_slider');
        }else{
            $slide = new Varien_Object();
        }
        
        $this->setForm($form);
        $fieldset = $form->addFieldset('main_fieldset', array('legend' => $this->__('Sidebar Content')));
        
        $this->_setFieldset(array(), $fieldset);
        
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array('tab_id' => $this->getTabId(),                                    
                  'add_widgets'              => true,                    
                  'add_adspromo_widgets'     => true,
                  'add_variables' 		     => true, 
                  'add_adspromo_variables'   => true,
                  'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
                  'directives_url'           => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'), 
                 )
        );
        
        $contentField = $fieldset->addField('sidebar_content', 'editor', array(
            'name'      => 'sidebar_content',
            'style'     => 'height:20em;',
            'label'     => $this->__('Sidebar Content'),
            'title'     => $this->__('Sidebar Content'),
            'config'    => $wysiwygConfig, 		                                 	
        ));

        $renderer = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset_element')
                    ->setTemplate('gomage/slider/content.phtml');
        $contentField->setRenderer($renderer);
        
        $form->setValues($slide->getData());
        
        return parent::_prepareForm();
        
    }
        
}
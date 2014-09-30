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
class GoMage_Slider_Block_Adminhtml_Slides_Edit_Tab_Description extends Mage_Adminhtml_Block_Widget_Form
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

        if (Mage::registry('gomage_slider')) {
            $slide = Mage::registry('gomage_slider');
        } else {
            $slide = new Varien_Object();
        }

        $this->setForm($form);
        $fieldset = $form->addFieldset('main_fieldset', array('legend' => $this->__('Description')));

        $this->_setFieldset(array(), $fieldset);

        $fieldset->addField('show_slider_text', 'select',
            array(
                'name'   => 'show_slider_text',
                'label'  => $this->__('Show Description Window'),
                'values' => Mage::getModel('adminhtml/system_config_source_enabledisable')->toOptionArray(),
            )
        );

        $fieldset->addField('text_window_alignment', 'select',
            array(
                'name'   => 'text_window_alignment',
                'label'  => $this->__('Text Alignment'),
                'values' => Mage::getModel('gomage_slider/adminhtml_system_config_source_slide_windowalignment')->toOptionArray(),
            )
        );

        $fieldset->addField('text_window_width', 'text', array(
                'name'  => 'text_window_width',
                'label' => $this->__('Window Width'),
                'title' => $this->__('Window Width'),
            )
        );

        $fieldset->addField('text_window_height', 'text', array(
                'name'  => 'text_window_height',
                'label' => $this->__('Window Height'),
                'title' => $this->__('Window Height'),
            )
        );

        $fieldset->addField('text_window_left_indent', 'text', array(
                'name'  => 'text_window_left_indent',
                'label' => $this->__('Window Indent (Left)'),
                'title' => $this->__('Window Indent (Left)'),
            )
        );

        $fieldset->addField('text_window_top_indent', 'text', array(
                'name'  => 'text_window_top_indent',
                'label' => $this->__('Window Indent (Top)'),
                'title' => $this->__('Window Indent (Top)'),
            )
        );

        $fieldset->addField('text_window_background', 'text', array(
                'name'  => 'text_window_background',
                'label' => $this->__('Text Window Background'),
                'title' => $this->__('Text Window Background'),
                'class' => 'color',
            )
        );

        $fieldset->addField('background_opacity', 'text', array(
                'name'  => 'background_opacity',
                'label' => $this->__('Background Opacity'),
                'title' => $this->__('Background Opacity'),
                'note'  => $this->__('Use numbers from 0 to 1. For example 0.5'),
            )
        );

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array('tab_id'                   => $this->getTabId(),
                  'add_widgets'              => true,
                  'add_adspromo_widgets'     => true,
                  'add_variables'            => true,
                  'add_adspromo_variables'   => true,
                  'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
                  'directives_url'           => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'),
            )
        );

        $contentField = $fieldset->addField('slider_text', 'editor', array(
                'name'   => 'slider_text',
                'style'  => 'height:20em;',
                'label'  => $this->__('Description'),
                'title'  => $this->__('Description'),
                'config' => $wysiwygConfig,
            )
        );

        $renderer = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset_element')
            ->setTemplate('gomage/slider/content.phtml');
        $contentField->setRenderer($renderer);

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
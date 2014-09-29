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

class GoMage_Slider_Block_Adminhtml_Blocks_Edit_Tab_Navigation extends Mage_Adminhtml_Block_Widget_Form
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
        $fieldset = $form->addFieldset('main_fieldset', array('legend' => $this->__('Navigation Bar')));
        
        $this->_setFieldset(array(), $fieldset);

        $show_navigation_bar = $fieldset->addField('show_navigation_bar', 'select',
            array(
                'name'   => 'show_navigation_bar',
                'label'  => $this->__('Show Navigation Bar'),                
                'values' => Mage::getModel('gomage_slider/adminhtml_system_config_source_navigation_show')->toOptionArray(), 
            )
        );
        $show_navigation_bar->setOnchange('SliderAdmin.setNavigationBar(this.value)');

        $fieldset->addField('navigation_bar_alignment', 'select',
            array(
                'name'   => 'navigation_bar_alignment',
                'label'  => $this->__('Navigation Bar Alignment'),                
                'values' => Mage::getModel('gomage_slider/adminhtml_system_config_source_navigation_alignment')->toOptionArray(), 
            )
        );
        
        $fieldset->addField('sidebar_width', 'text', array(
            'name'      => 'sidebar_width',
            'label'     => $this->__('Sidebar Width, px'),
            'title'     => $this->__('Sidebar Width, px'), 
        ));
        
        $fieldset->addField('sidebar_height', 'text', array(
            'name'      => 'sidebar_height',
            'label'     => $this->__('Sidebar Height, px'),
            'title'     => $this->__('Sidebar Height, px'), 
        ));
        
        $show_arrows = $fieldset->addField('show_arrows', 'select',
            array(
                'name'   => 'show_arrows',
                'label'  => $this->__('Show Arrows'),                
                'values' => Mage::getModel('gomage_slider/adminhtml_system_config_source_navigation_arrows')->toOptionArray(), 
            )
        );
        
        $arrows_type = $fieldset->addField('arrows_type', 'select',
            array(
                'name'   => 'arrows_type',
                'label'  => $this->__('Arrows Type '),                
                'values' => Mage::getModel('gomage_slider/adminhtml_system_config_source_navigation_arrowstype')->toOptionArray(), 
            )
        );
        
        $arrows_type->setOnchange('SliderAdmin.setArrowsType(this.value)');
        
        $fieldset->addField('arrow_color', 'text', array(
            'name'      => 'arrow_color',
            'label'     => $this->__('Arrows Color'),
            'title'     => $this->__('Arrows Color'),
            'class' => 'color',
        ));
        
        $fieldset->addField('mouse_over_color', 'text', array(
            'name'      => 'mouse_over_color',
            'label'     => $this->__('Mouse Over Arrow Color'),
            'title'     => $this->__('Mouse Over Arrow Color'),
            'class' => 'color',
        ));
        
        $fieldset->addField('mouse_over_background', 'text', array(
            'name'      => 'mouse_over_background',
            'label'     => $this->__('Mouse Over Background Color'),
            'title'     => $this->__('Mouse Over Background Color'),
            'class' => 'color',
        ));
        
        
        $form->setValues($block->getData());
        
        return parent::_prepareForm();
        
    }
        
}
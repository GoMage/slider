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

class GoMage_Slider_Block_Adminhtml_Slides extends Mage_Adminhtml_Block_Widget_Grid_Container
{
      public function __construct()
      { 
        $this->_controller = 'adminhtml_slides';
        $this->_blockGroup = 'gomage_slider';
        $this->_headerText = $this->__('Manage Slides');
        $this->_addButtonLabel = $this->__('Add Item');
        parent::__construct();
      }
}
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
class GoMage_Slider_Block_Head extends Mage_Core_Block_Template
{

    protected $_blocks = null;

    public function __construct()
    {
        parent::__construct();
        $blocks = $this->getBlocks();
        if (count($blocks)) {
            $this->setTemplate('gomage/slider/head/styles.phtml');
        }

    }

    public function getBlocks()
    {
        if (is_null($this->_blocks)) {
            $this->_blocks = Mage::getResourceModel('gomage_slider/block_collection')
                ->addFieldToFilter('status', 1);
        }

        return $this->_blocks;
    }
}
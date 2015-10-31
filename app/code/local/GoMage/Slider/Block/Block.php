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
class GoMage_Slider_Block_Block extends Mage_Core_Block_Template
{
    protected $_block;
    protected $_slides;
    protected $_slider_code;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('gomage/slider/block.phtml');
    }

    public function getBlock()
    {
        if (is_null($this->_block)) {
            $this->_block = Mage::getResourceModel('gomage_slider/block_collection')
                ->addFieldToFilter('status', 1)
                ->addFieldToFilter('code', $this->getBlockCode())
                ->getFirstItem();
        }
        return $this->_block;
    }

    public function getSliderCode()
    {
        if (is_null($this->_slider_code)) {
            $this->_slider_code = Mage::helper('gomage_slider')->generateCode();
        }
        return $this->_slider_code;
    }


    public function getSlides()
    {
        if (is_null($this->_slides)) {

            $this->_slides = array();
            $slides        = json_decode($this->getBlock()->getSlides(), true);

            if (!empty($slides)) {
                $ids           = array();
                $slides_config = array();
                foreach ($slides as $slide) {
                    $ids[]                       = $slide['id'];
                    $slides_config[$slide['id']] = $slide;
                }

                $collection = Mage::getResourceModel('gomage_slider/slide_collection')
                    ->addFieldToFilter('status', 1)
                    ->addFieldToFilter('id', array('in' => $ids));

                foreach ($collection as $slide) {
                    if ($slide->isActive()) {
                        $order  = $slides_config[$slide->getId()]['order'];
                        $effect = $slides_config[$slide->getId()]['effect'];
                        $slide->setData('effect', $effect);
                        $this->_slides[$order] = $slide;
                    }
                }
                ksort($this->_slides);
            }
        }

        return $this->_slides;
    }

    public function getContentHtml()
    {
        return $this->getLayout()->createBlock('core/template')
            ->setData('block', $this->getBlock())
            ->setData('slider_code', $this->getSliderCode())
            ->setData('slides', $this->getSlides())
            ->setTemplate('gomage/slider/block/content.phtml')->toHtml();
    }

    public function getNavigationbarHtml()
    {
        return $this->getLayout()->createBlock('core/template')
            ->setData('block', $this->getBlock())
            ->setData('slider_code', $this->getSliderCode())
            ->setData('slides', $this->getSlides())
            ->setTemplate('gomage/slider/block/navigation-bar.phtml')->toHtml();
    }

    public function getSidebarHtml()
    {
        return $this->getLayout()->createBlock('core/template')
            ->setData('block', $this->getBlock())
            ->setData('slider_code', $this->getSliderCode())
            ->setData('slides', $this->getSlides())
            ->setTemplate('gomage/slider/block/sidebar.phtml')->toHtml();
    }

    public function getConfig()
    {
        $block  = $this->getBlock();
        $config = array();

        $config['change_slides_manually']   = $block->getData('change_slides_manually');
        $config['show_arrows']              = $block->getData('show_arrows');
        $config['delay_time']               = $block->getData('delay_time');
        $config['transition_time']          = $block->getData('transition_time');
        $config['enable_autostart']         = $block->getData('enable_autostart');
        $config['block_width']              = $block->getData('block_width');
        $config['block_height']             = $block->getData('block_height');
        $config['delay_time']               = $block->getData('delay_time');
        $config['show_navigation_bar']      = $block->getData('show_navigation_bar');
        $config['navigation_bar_alignment'] = $block->getData('navigation_bar_alignment');
        $config['sidebar_width']            = $block->getData('sidebar_width');
        $config['sidebar_height']           = $block->getData('sidebar_height');

        $config['play']  = Mage::getBaseUrl('skin') . 'frontend/base/default/images/gomage/slider/play.gif';
        $config['pause'] = Mage::getBaseUrl('skin') . 'frontend/base/default/images/gomage/slider/pause.gif';

        return Mage::helper('core')->jsonEncode($config);
    }

    public function getSlidesJson()
    {
        $slides = $this->getSlides();
        $result = array();
        foreach ($slides as $order => $slide) {
            $result[$order]['image']                   = Mage::getBaseUrl('media') . 'slider/' . $slide->getData('image');
            $result[$order]['alt_text']                = $slide->getData('alt_text');
            $result[$order]['slider_link']             = $slide->getData('slider_link');
            $result[$order]['open_slider_link_in']     = $slide->getData('open_slider_link_in');
            $result[$order]['slider_text']             = $slide->getData('slider_text');
            $result[$order]['text_window_alignment']   = $slide->getData('text_window_alignment');
            $result[$order]['text_window_width']       = $slide->getData('text_window_width');
            $result[$order]['text_window_height']      = $slide->getData('text_window_height');
            $result[$order]['text_window_background']  = Mage::helper('gomage_slider')->formatColor($slide->getData('text_window_background'));
            $result[$order]['text_window_opacity']     = $slide->getData('background_opacity');
            $result[$order]['text_window_left_indent'] = $slide->getData('text_window_left_indent');
            $result[$order]['text_window_top_indent']  = $slide->getData('text_window_top_indent');
            $result[$order]['sidebar_content']         = $slide->getData('sidebar_content');
            $result[$order]['effect']                  = $slide->getData('effect');
        }

        return Mage::helper('core')->jsonEncode($result);
    }
}
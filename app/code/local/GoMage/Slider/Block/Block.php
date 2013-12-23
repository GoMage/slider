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
	
class GoMage_Slider_Block_Block extends GoMage_Slider_Block_Abstract{
	
    public function __construct()
    {
        parent::__construct();
        
        $items = $this->getItems();
        
        if (count($items)){
        	$this->setTemplate('gomage/slider/block.phtml');
        } 
    }
    
    public function getContentHtml($item, $sliderCode)
    {
    	return $this->getLayout()->createBlock('gomage_slider/block')
								 ->setData('block_item', $item)
                                 ->setData('slider_code', $sliderCode)
								 ->setData('start_order_id', $this->getStartOrderId($this->getBlockCode()))
								 ->setData('block_slides', $this->getSlidesArray($this->getBlockCode()))
	            				 ->setTemplate('gomage/slider/block/content.phtml')->toHtml();
    }
    
    public function getSidebarHtml($item, $sliderCode)
    {
    	return $this->getLayout()->createBlock('core/template')
								->setData('item', $item)
                                ->setData('sliderCode', $sliderCode)
								->setData('slides', $this->getSlidesArray($this->getBlockCode()))
	            				->setTemplate('gomage/slider/block/sidebar.phtml')->toHtml();
    }
    
    public function getNavigationbarHtml($item, $slides, $sliderCode)
    {
    	return $this->getLayout()->createBlock('core/template')
								->setData('item', $item)
								->setData('slides', $slides)
                                ->setData('slider_code', $sliderCode)
	            				->setTemplate('gomage/slider/block/navigation-bar.phtml')->toHtml();
    }
    
    public function getConfig()
    {
    	return Mage::helper('core')->jsonEncode($this->_config);
    }
    
	public function getSlideConfig($item, $slide, $block_id)
    { 
    	$this->_slides[$block_id][$slide['order']] = $item;
    }
    
	public function getSlidesArray($block_code)
    {
    	ksort($this->_slides[$this->getBlockId($block_code)]);
    	return $this->_slides;
    }
    
	public function getStartOrderId($block_code)
    {
    	$slides = $this->getSlidesArray($block_code);
    	foreach($slides[$this->getBlockId($block_code)] as $order => $key  )
    	{
    		return $order;
    	}
    }
    
	public function getBlockConfig($item)
    { 
        $helper = Mage::helper('gomage_slider');
		     
        $this->_config[$item->getId()]['change_slides_manually'] = $item->getData('change_slides_manually');
        $this->_config[$item->getId()]['delay_time'] = $item->getData('delay_time');
		$this->_config[$item->getId()]['transition_time'] = $item->getData('transition_time');
		$this->_config[$item->getId()]['enable_autostart'] = $item->getData('enable_autostart');
		$this->_config[$item->getId()]['change_slides_manually'] = $item->getData('change_slides_manually');
		$this->_config[$item->getId()]['block_width'] = $item->getData('block_width');
		$this->_config[$item->getId()]['block_height'] = $item->getData('block_height');
		$this->_config[$item->getId()]['delay_time'] = $item->getData('delay_time');
		$this->_config[$item->getId()]['show_navigation_bar'] = $item->getData('show_navigation_bar');
		$this->_config[$item->getId()]['navigation_bar_alignment'] = $item->getData('navigation_bar_alignment');
		$this->_config[$item->getId()]['sidebar_width'] = $item->getData('sidebar_width');
		$this->_config[$item->getId()]['sidebar_height'] = $item->getData('sidebar_height');
		
		$this->_config[$item->getId()]['play'] = Mage::getBaseUrl('skin') . 'frontend/base/default/images/gomage/slider/play.gif';
		$this->_config[$item->getId()]['pause'] = Mage::getBaseUrl('skin') . 'frontend/base/default/images/gomage/slider/pause.gif';
		
		$this->getSlides($item);
    }
    
	public function getSlideConfigJs($item, $slide, $block_id)
    { 
		$this->_slidesjs[$block_id][$slide['order']]['image'] = Mage::getBaseUrl('media').'slider/' . $item->getData('image');
		$this->_slidesjs[$block_id][$slide['order']]['alt_text'] = $item->getData('alt_text');
		$this->_slidesjs[$block_id][$slide['order']]['slider_link'] = $item->getData('slider_link');
		$this->_slidesjs[$block_id][$slide['order']]['open_slider_link_in'] = $item->getData('open_slider_link_in');
		$this->_slidesjs[$block_id][$slide['order']]['slider_text'] = $item->getData('slider_text');
		$this->_slidesjs[$block_id][$slide['order']]['text_window_alignment'] = $item->getData('text_window_alignment');
		$this->_slidesjs[$block_id][$slide['order']]['text_window_width'] = $item->getData('text_window_width');
		$this->_slidesjs[$block_id][$slide['order']]['text_window_height'] = $item->getData('text_window_height');
		$this->_slidesjs[$block_id][$slide['order']]['text_window_background'] = $item->getData('text_window_background');
		$this->_slidesjs[$block_id][$slide['order']]['text_window_opacity'] = $item->getData('background_opacity');
		$this->_slidesjs[$block_id][$slide['order']]['text_window_left_indent'] = $item->getData('text_window_left_indent');
		$this->_slidesjs[$block_id][$slide['order']]['text_window_top_indent'] = $item->getData('text_window_top_indent');
		$this->_slidesjs[$block_id][$slide['order']]['sidebar_content'] = $item->getData('sidebar_content');
		$this->_slidesjs[$block_id][$slide['order']]['effect'] = $slide['effect'];
    }
    
	public function getSlidesJson($block_id)
    {
    	ksort($this->_slidesjs[$block_id]);
    	
    	return Mage::helper('core')->jsonEncode($this->_slidesjs);
    }
}
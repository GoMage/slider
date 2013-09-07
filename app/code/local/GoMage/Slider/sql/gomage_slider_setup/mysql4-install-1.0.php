<?php
 /**
 * GoMage Slider Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2012 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 1.0
 */

$installer = $this;

$installer->startSetup();

$installer->run("CREATE TABLE IF NOT EXISTS `{$this->getTable('gomage_slider_items')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `store_ids` varchar(255) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '0',
  `block_width` int(11) DEFAULT NULL,
  `block_height` int(11) DEFAULT NULL,
  `sidebar_width` int(11) DEFAULT NULL,
  `sidebar_height` int(11) DEFAULT NULL, 
  `delay_time` int(11) DEFAULT NULL,
  `transition_time` int(11) DEFAULT NULL,
  `enable_autostart` smallint(1) DEFAULT NULL,
  `show_pause_button` smallint(1) DEFAULT NULL,
  `change_slides_manually` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `show_navigation_bar` smallint(1) DEFAULT NULL,
  `show_arrows` smallint(1) DEFAULT NULL,
  `arrows_type` smallint(1) DEFAULT NULL,
  `arrow_color` varchar(255) NOT NULL,
  `mouse_over_color` varchar(255) NOT NULL,
  `mouse_over_background` varchar(255) NOT NULL,
  `navigation_bar_alignment` varchar(255) NOT NULL DEFAULT 'bottom',
  `slides` text NOT NULL,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;");

$installer->run("CREATE TABLE IF NOT EXISTS `{$this->getTable('gomage_slider_slides')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
  `open_slider_link_in` varchar(255) NOT NULL,
  `slider_link` text NOT NULL,
  `show_slider_text` smallint(1) NOT NULL DEFAULT '0',
  `slider_text` text NOT NULL,
  `text_window_alignment` int(11) DEFAULT NULL,
  `text_window_width` int(11) DEFAULT NULL,
  `text_window_height` int(11) DEFAULT NULL,
  `text_window_background` varchar(255) NOT NULL,
  `background_opacity` varchar(255) NOT NULL,
  `text_window_left_indent` int(11) DEFAULT NULL,
  `text_window_top_indent` int(11) DEFAULT NULL,
  `sidebar_content` text NOT NULL,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;");

$installer->endSetup(); 
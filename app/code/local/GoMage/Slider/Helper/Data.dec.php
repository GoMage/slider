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
class GoMage_Slider_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function getConfigData($node)
    {
        return Mage::getStoreConfig('gomage_slider/' . $node);
    }

    public function getAllStoreDomains()
    {
        $domains = array();
        foreach (Mage::app()->getWebsites() as $website) {
            $url = $website->getConfig('web/unsecure/base_url');
            if ($domain = trim(preg_replace('/^.*?\\/\\/(.*)?\\//', '$1', $url))) {
                $domains[] = $domain;
            }
            $url = $website->getConfig('web/secure/base_url');
            if ($domain = trim(preg_replace('/^.*?\\/\\/(.*)?\\//', '$1', $url))) {
                $domains[] = $domain;
            }
        }

        return array_unique($domains);
    }

    public function getAvailabelWebsites()
    {
        return $this->_w();
    }

    public function getAvailavelWebsites()
    {
        return $this->_w();
    }

    protected function _w()
    {
        if (!Mage::getStoreConfig('gomage_activation/slider/installed') ||
            (intval(Mage::getStoreConfig('gomage_activation/slider/count')) > 10)
        ) {
            return array();
        }

        $time_to_update = 60 * 60 * 24 * 15;

        $r = Mage::getStoreConfig('gomage_activation/slider/ar');
        $t = Mage::getStoreConfig('gomage_activation/slider/time');
        $s = Mage::getStoreConfig('gomage_activation/slider/websites');

        $last_check = str_replace($r, '', Mage::helper('core')->decrypt($t));

        $allsites = explode(',', str_replace($r, '', Mage::helper('core')->decrypt($s)));
        $allsites = array_diff($allsites, array(""));

        if (($last_check + $time_to_update) < time()) {
            $this->a(Mage::getStoreConfig('gomage_activation/slider/key'),
                intval(Mage::getStoreConfig('gomage_activation/slider/count')),
                implode(',', $allsites)
            );
        }

        return $allsites;
    }

    public function a($k, $c = 0, $s = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf('https://www.gomage.com/index.php/gomage_downloadable/key/check'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'key=' . urlencode($k) . '&sku=slider_pro&domains=' . urlencode(implode(',', $this->getAllStoreDomains())) . '&ver=' . urlencode('1.1'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $content = curl_exec($ch);

        $r = Zend_Json::decode($content);

        $e = Mage::helper('core');
        if (empty($r)) {

            $value1 = Mage::getStoreConfig('gomage_activation/slider/ar');

            $groups = array(
                'slider' => array(
                    'fields' => array(
                        'ar'       => array(
                            'value' => $value1
                        ),
                        'websites' => array(
                            'value' => (string)Mage::getStoreConfig('gomage_activation/slider/websites')
                        ),
                        'time'     => array(
                            'value' => (string)$e->encrypt($value1 . (time() - (60 * 60 * 24 * 15 - 1800)) . $value1)
                        ),
                        'count'    => array(
                            'value' => $c + 1)
                    )
                )
            );

            Mage::getModel('adminhtml/config_data')
                ->setSection('gomage_activation')
                ->setGroups($groups)
                ->save();

            Mage::getConfig()->reinit();
            Mage::app()->reinitStores();

            return;
        }

        $value1 = '';
        $value2 = '';


        if (isset($r['d']) && isset($r['c'])) {
            $value1 = $e->encrypt(base64_encode(Zend_Json::encode($r)));


            if (!$s) {
                $s = Mage::getStoreConfig('gomage_activation/slider/websites');
            }

            $s = array_slice(explode(',', $s), 0, $r['c']);

            $value2 = $e->encrypt($value1 . implode(',', $s) . $value1);

        }
        $groups = array(
            'slider' => array(
                'fields' => array(
                    'ar'        => array(
                        'value' => $value1
                    ),
                    'websites'  => array(
                        'value' => (string)$value2
                    ),
                    'time'      => array(
                        'value' => (string)$e->encrypt($value1 . time() . $value1)
                    ),
                    'installed' => array(
                        'value' => 1
                    ),
                    'count'     => array(
                        'value' => 0)

                )
            )
        );

        Mage::getModel('adminhtml/config_data')
            ->setSection('gomage_activation')
            ->setGroups($groups)
            ->save();

        Mage::getConfig()->reinit();
        Mage::app()->reinitStores();

    }

    public function ga()
    {
        return Zend_Json::decode(base64_decode(Mage::helper('core')->decrypt(Mage::getStoreConfig('gomage_activation/slider/ar'))));
    }

    public function formatColor($value)
    {
        if ($value = preg_replace('/[^a-zA-Z0-9\s]/', '', $value)) {
            $value = '#' . $value;
        }
        return $value;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public static function effectToOptionHash()
    {
        $helper = Mage::helper('gomage_slider');

        return array(
            GoMage_Slider_Model_Block::EFFECT_SIMPLE            => $helper->__('Simple'),
            GoMage_Slider_Model_Block::EFFECT_VERTICAL_SPLIT    => $helper->__('Vertical split'),
            GoMage_Slider_Model_Block::EFFECT_HORIZONTAL_SPLIT  => $helper->__('Horizontal split'),
            GoMage_Slider_Model_Block::EFFECT_WIPE_RIGHT        => $helper->__('Wipe right'),
            GoMage_Slider_Model_Block::EFFECT_WIPE_LEFT         => $helper->__('Wipe left'),
            GoMage_Slider_Model_Block::EFFECT_WIPE_UP           => $helper->__('Wipe up'),
            GoMage_Slider_Model_Block::EFFECT_WIPE_DOWN         => $helper->__('Wipe down'),
            GoMage_Slider_Model_Block::EFFECT_PAGE_FLIP         => $helper->__('Page Flip'),
            GoMage_Slider_Model_Block::EFFECT_HORIZONTAL_PANELS => $helper->__('Horizontal panels'),
            GoMage_Slider_Model_Block::EFFECT_VERTICAL_PANELS   => $helper->__('Vertical panels')
        );
    }

    public function getSlideTextStyle($slide, $block)
    {
        $style = '';

        if ($slide->getTextWindowLeftIndent() != '') {
            $style .= 'margin-left: ' . (int)$slide->getTextWindowLeftIndent() . 'px;';
            $leftIndent = (int)$slide->getTextWindowLeftIndent();
        }

        if ($slide->getTextWindowTopIndent() != '') {
            $style .= 'margin-top: ' . (int)$slide->getTextWindowTopIndent() . 'px;';
            $topIndent = (int)$slide->getTextWindowTopIndent();
        }

        if ($slide->getTextWindowWidth() != '' && (int)$slide->getTextWindowWidth() > 0) {
            $style .= 'width: ' . (int)$slide->getTextWindowWidth() . 'px;';
        } else {
            if ($block->getShowNavigationBar() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Show::SIDEBAR) {
                if ($block->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
                    &&
                    $block->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM
                ) {
                    $width = intval($block->getBlockWidth()) - intval($block->getSidebarWidth());
                } else {
                    $width = intval($block->getBlockWidth());
                }
            } else {
                $width = intval($block->getBlockWidth());
            }

            $width = $width - $leftIndent;

            $style .= 'width: ' . $width . 'px;';
        }

        if ($slide->getTextWindowHeight() != '' && (int)$slide->getTextWindowHeight() > 0) {
            $style .= 'height: ' . (int)$slide->getTextWindowHeight() . 'px;';
        } else {
            if ($block->getShowNavigationBar() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Show::SIDEBAR) {
                if ($block->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
                    &&
                    $block->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM
                ) {
                    $height = intval($block->getBlockHeight());
                } else {
                    $height = intval($block->getBlockHeight()) - intval($block->getSidebarHeight());
                }
            } else {
                $height = intval($block->getBlockHeight());
            }

            $height = $height - $topIndent;

            $style .= 'height: ' . $height . 'px;';
        }

        if ($slide->getTextWindowAlignment() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Slide_Windowalignment::RIGHT) {
            $style .= 'text-align: right;';
        }

        return $style;
    }

    public function getSlideTextBgStyle($slide, $block)
    {
        $style = '';

        if ($slide->getTextWindowLeftIndent() != '') {
            $style .= 'margin-left: ' . (int)$slide->getTextWindowLeftIndent() . 'px;';
            $leftIndent = (int)$slide->getTextWindowLeftIndent();
        }

        if ($slide->getTextWindowTopIndent() != '') {
            $style .= 'margin-top: ' . (int)$slide->getTextWindowTopIndent() . 'px;';
            $topIndent = (int)$slide->getTextWindowTopIndent();
        }

        if ($slide->getTextWindowWidth() != '' && (int)$slide->getTextWindowWidth() > 0) {
            $style .= 'width: ' . (int)$slide->getTextWindowWidth() . 'px;';
        } else {
            if ($block->getShowNavigationBar() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Show::SIDEBAR) {
                if ($block->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
                    &&
                    $block->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM
                ) {
                    $width = intval($block->getBlockWidth()) - intval($block->getSidebarWidth());
                } else {
                    $width = intval($block->getBlockWidth());
                }
            } else {
                $width = intval($block->getBlockWidth());
            }

            $width = $width - $leftIndent;

            $style .= 'width: ' . $width . 'px;';
        }

        if ($slide->getTextWindowHeight() != '' && (int)$slide->getTextWindowHeight() > 0) {
            $style .= 'height: ' . (int)$slide->getTextWindowHeight() . 'px;';
        } else {
            if ($block->getShowNavigationBar() == GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Show::SIDEBAR) {
                if ($block->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::TOP
                    &&
                    $block->getNavigationBarAlignment() != GoMage_Slider_Model_Adminhtml_System_Config_Source_Navigation_Alignment::BOTTOM
                ) {
                    $height = intval($block->getBlockHeight());
                } else {
                    $height = intval($block->getBlockHeight()) - intval($block->getSidebarHeight());
                }
            } else {
                $height = intval($block->getBlockHeight());
            }

            $height = $height - $topIndent;

            $style .= 'height: ' . $height . 'px;';
        }

        if ($slide->getTextWindowBackground() != '') {
            $style .= 'background-color: ' . $slide->getTextWindowBackground() . ';';

            if ($slide->getBackgroundOpacity() != '') {

                if ($this->_detect_ie()) {
                    $opacity = $slide->getBackgroundOpacity();

                    if ($slide->getBackgroundOpacity() > 0 && $slide->getBackgroundOpacity() < 1) {
                        $opacity = $slide->getBackgroundOpacity() * 100;
                    }

                    $style .= 'filter:alpha(opacity=' . $opacity . ');';
                } else {
                    $style .= 'opacity: ' . $slide->getBackgroundOpacity() . ';';
                }
            }
        }

        return $style;
    }

    private function _detect_ie()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (stristr($user_agent, "msie 7")) {
            return true;
        }

        if (stristr($user_agent, "msie 8")) {
            return true;
        }

        return false;
    }

    public function notify()
    {

        $frequency = intval(Mage::app()->loadCache('gomage_notifications_frequency'));
        if (!$frequency) {
            $frequency = 24;
        }
        $last_update = intval(Mage::app()->loadCache('gomage_notifications_last_update'));

        if (($frequency * 60 * 60 + $last_update) > time()) {
            return false;
        }

        $timestamp = $last_update;
        if (!$timestamp) {
            $timestamp = time();
        }

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, sprintf('https://www.gomage.com/index.php/gomage_notification/index/data'));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'sku=slider_pro&timestamp=' . $timestamp . '&ver=' . urlencode('1.1'));
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            $content = curl_exec($ch);

            $result = Zend_Json::decode($content);

            if ($result && isset($result['frequency']) && ($result['frequency'] != $frequency)) {
                Mage::app()->saveCache($result['frequency'], 'gomage_notifications_frequency');
            }

            if ($result && isset($result['data'])) {
                if (!empty($result['data'])) {
                    Mage::getModel('adminnotification/inbox')->parse($result['data']);
                }
            }
        } catch (Exception $e) {
        }

        Mage::app()->saveCache(time(), 'gomage_notifications_last_update');

    }


    /**
     * @param int $length
     * @return string
     */
    public function generateCode($length = 12)
    {
        $possible = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRESTUVWXYZ_";
        return substr(str_shuffle($possible), 0, $length);

    }
}

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
class GoMage_Slider_Adminhtml_SlidesController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/gomage_slider/gomage_manage_slider_slides');
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('cms/gomage_slider')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Slider Slides'), Mage::helper('adminhtml')->__('Slider Slides'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();

    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {

                $data = $this->_filterPostData($data);

                $id = $this->getRequest()->getParam('id');

                $model = Mage::getModel('gomage_slider/slide');

                $model->setData($data)->setId($id)->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('core')->__('Data successfully saved'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

            } catch (Mage_Core_Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                Mage::getSingleton('core/session')->setSliderData($data);

                if ($model->getId() > 0) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/new');
                }
                return false;

            } catch (Exception $e) {

                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('core')->__('Can\'t save data'));

                Mage::getSingleton('core/session')->setSliderData($data);

                if ($model->getId() > 0) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                } else {
                    $this->_redirect('*/*/new');
                }
                return false;

            }
            $this->_redirect('*/*/');
        }
    }

    public function _filterPostData($data)
    {
        if ($data['start_date']) {
            $data = $this->_filterDates($data, array('start_date'));
        } else {
            $data['start_date'] = null;
        }
        if ($data['end_date']) {
            $data = $this->_filterDates($data, array('end_date'));
        } else {
            $data['end_date'] = null;
        }

        $data['store_ids'] = (isset($data['store_ids']) && is_array($data['store_ids']) ? implode(',', $data['store_ids']) : '');

        if ($filename = $this->_saveImage('image')) {
            $data['image'] = $filename;
            if (isset($data['image_width']) && isset($data['image_height'])) {
                $this->adsResizeImage($data['image'], $data['image_width'], $data['image_height']);
            }
        } elseif (isset($data['image']['delete']) && intval($data['image']['delete'])) {
            $data['image'] = '';
        } elseif (isset($data['image']['value'])) {
            $data['image'] = $data['image']['value'];
            if (isset($data['image_width']) && isset($data['image_height'])) {
                $this->adsResizeImage($data['image'], $data['image_width'], $data['image_height']);
            }
        }

        return $data;
    }

    protected function _saveImage($name)
    {

        if (isset($_FILES[$name]['name']) && $_FILES[$name]['name'] != '') {
            $uploader = new Varien_File_Uploader($name);

            $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(false);

            $path = Mage::getBaseDir('media') . DS . 'slider' . DS;

            if (!file_exists($path)) {
                mkdir($path);
                chmod($path, 0755);
            }

            $uploader->save($path, $_FILES[$name]['name']);

            return $uploader->getUploadedFileName();

        }
        return false;
    }

    public function adsResizeImage($image, $width = null, $height = null, $quality = 100)
    {
        if (!$width && !$height) {
            return false;
        }

        $imageUrl = Mage::getBaseDir('media') . DS . "slider" . DS . $image;
        if (!is_file($imageUrl)) {
            return false;
        }

        $path_info  = pathinfo($image);
        $cache_name = $path_info['filename'] . '_' . $width . '_' . $height . '.' . $path_info['extension'];

        $imageResized = Mage::getBaseDir('media') . DS . "slider" . DS . "cache" . DS . $cache_name;
        if (!file_exists($imageResized) && file_exists($imageUrl) || file_exists($imageUrl) && filemtime($imageUrl) > filemtime($imageResized)) {
            $imageObj = new Varien_Image ($imageUrl);
            $imageObj->constrainOnly(true);
            $imageObj->keepFrame(false);
            $imageObj->keepTransparency(true);
            $imageObj->quality($quality);
            $imageObj->resize(($width ? $width : null), ($height ? $height : null));
            $imageObj->save($imageResized);
        }
    }

    public function deleteAction()
    {

        if ($id = intval($this->getRequest()->getParam('id'))) {

            $this->_deleteItems(array($id));

        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        if ($ids = $this->getRequest()->getParam('id')) {
            if (is_array($ids) && !empty($ids)) {
                $this->_deleteItems($ids);
            }
        }
        $this->_redirect('*/*/');
    }

    protected function _deleteItems($ids)
    {
        if (is_array($ids) && !empty($ids)) {
            foreach ($ids as $id) {
                $item = Mage::getModel('gomage_slider/slide')->load($id);
                $item->delete();
            }
        }
    }

    public function massEnableAction()
    {
        if ($ids = $this->getRequest()->getParam('id')) {
            if (is_array($ids) && !empty($ids)) {
                $this->_setstatusItems($ids, 1);
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDisableAction()
    {
        if ($ids = $this->getRequest()->getParam('id')) {
            if (is_array($ids) && !empty($ids)) {
                $this->_setstatusItems($ids, 0);
            }
        }
        $this->_redirect('*/*/');
    }

    protected function _setstatusItems($ids, $status)
    {
        if (is_array($ids) && !empty($ids)) {
            foreach ($ids as $id) {
                $item = Mage::getModel('gomage_slider/slide')->load($id);
                $item->setData('status', $status);
                $item->save();
            }
        }
    }

    public function newAction()
    {
        $this->_initAction();
        if ($data = Mage::getSingleton('core/session')->getAdspromoData()) {
            Mage::register('gomage_slider', Mage::getModel('gomage_slider/slide')->addData($data));
            Mage::getSingleton('core/session')->setSliderData(null);
        }

        $this->_addContent($this->getLayout()->createBlock('gomage_slider/adminhtml_slides_edit'))
            ->_addLeft($this->getLayout()->createBlock('gomage_slider/adminhtml_slides_edit_tabs'));

        $this->renderLayout();

    }

    public function editAction()
    {

        $this->_initAction();

        if ($id = $this->getRequest()->getParam('id')) {
            Mage::register('gomage_slider', Mage::getModel('gomage_slider/slide')->load($id));
        }

        $this->_addContent($this->getLayout()->createBlock('gomage_slider/adminhtml_slides_edit'))
            ->_addLeft($this->getLayout()->createBlock('gomage_slider/adminhtml_slides_edit_tabs'));

        $this->renderLayout();
    }
}
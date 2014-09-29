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
class GoMage_Slider_Adminhtml_BlocksController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('cms/gomage_slider')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Slider Blocks'), Mage::helper('adminhtml')->__('Slider Blocks'));

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

                $model = Mage::getModel('gomage_slider/block');

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

        $data['slides'] = json_encode(array());

        if (isset($data['field'])) {

            $content_data = array();
            $max          = 0;
            foreach ($data['field'] as $field) {
                if (!isset($content_data[intval($field['order'])])) {
                    $content_data[intval($field['order'])] = $field;
                    $max                                   = intval($field['order']);
                } else {
                    $content_data[$max + 1] = $field;
                    $max                    = $max + 1;
                }

            }

            ksort($content_data);
            $order_array = $content_data;


            $order_array_sorted = array();
            $i                  = 0;
            foreach ($order_array as $value) {
                $value['order']       = $i;
                $order_array_sorted[] = $value;
                $i++;
            }

            $data['slides'] = json_encode($order_array_sorted);

        }

        return $data;
    }

    public function deleteAction()
    {
        if ($id = intval($this->getRequest()->getParam('id'))) {
            $this->_deleteBlocks(array($id));
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        if ($ids = $this->getRequest()->getParam('id')) {
            if (is_array($ids) && !empty($ids)) {
                $this->_deleteBlocks($ids);
            }
        }
        $this->_redirect('*/*/');
    }

    protected function _deleteBlocks($ids)
    {
        if (is_array($ids) && !empty($ids)) {
            foreach ($ids as $id) {
                $block = Mage::getModel('gomage_slider/block')->load($id);
                $block->delete();
            }
        }
    }

    public function massEnableAction()
    {
        if ($ids = $this->getRequest()->getParam('id')) {
            if (is_array($ids) && !empty($ids)) {
                $this->_setstatusBlocks($ids, 1);
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDisableAction()
    {
        if ($ids = $this->getRequest()->getParam('id')) {
            if (is_array($ids) && !empty($ids)) {
                $this->_setstatusBlocks($ids, 0);
            }
        }
        $this->_redirect('*/*/');
    }

    protected function _setstatusBlocks($ids, $status)
    {
        if (is_array($ids) && !empty($ids)) {
            foreach ($ids as $id) {
                $block = Mage::getModel('gomage_slider/block')->load($id);
                $block->setData('status', $status);
                $block->save();
            }
        }
    }

    public function newAction()
    {
        $this->_initAction();
        if ($data = Mage::getSingleton('core/session')->getAdspromoData()) {
            Mage::register('gomage_slider', Mage::getModel('gomage_slider/block')->addData($data));
            Mage::getSingleton('core/session')->setSliderData(null);
        }

        $this->_addContent($this->getLayout()->createBlock('gomage_slider/adminhtml_blocks_edit'))
            ->_addLeft($this->getLayout()->createBlock('gomage_slider/adminhtml_blocks_edit_tabs'));

        $this->renderLayout();

    }

    public function editAction()
    {

        $this->_initAction();

        if ($id = $this->getRequest()->getParam('id')) {
            Mage::register('gomage_slider', Mage::getModel('gomage_slider/block')->load($id));
        }

        $this->_addContent($this->getLayout()->createBlock('gomage_slider/adminhtml_blocks_edit'))
            ->_addLeft($this->getLayout()->createBlock('gomage_slider/adminhtml_blocks_edit_tabs'));

        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('gomage_slider/adminhtml_blocks_edit_tab_slider', 'slider.slider.grid')
                ->toHtml()
        );
    }
}
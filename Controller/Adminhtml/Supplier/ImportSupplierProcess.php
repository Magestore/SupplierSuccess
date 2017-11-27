<?php

/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\SupplierSuccess\Controller\Adminhtml\Supplier;

use Magento\Framework\Controller\ResultFactory;
use \Magestore\SupplierSuccess\Controller\Adminhtml\AbstractSupplier;

/**
 * Class Import
 * @package Magestore\SupplierSuccess\Controller\Adminhtml\Supplier
 */
class ImportSupplierProcess extends AbstractSupplier
{
    public function execute() {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (isset($_FILES['filecsv'])) {
            if (substr($_FILES['filecsv']["name"], -4)!='.csv') {
                $this->messageManager->addError(__('Please choose a CSV file'));
                return $resultRedirect->setPath('*/*/importsupplier');
            }
            try {
                $fileName = $_FILES['filecsv']['tmp_name'];
                $csvObject = $this->_objectManager->create('Magento\Framework\File\Csv');
                $importService = $this->_objectManager->create('Magestore\SupplierSuccess\Service\Supplier\ImportService');
                $data = $csvObject->getData($fileName);
                if ($data) {
                    $result = $importService->importSupplier($data);
                    if($result>0)
                        $this->messageManager->addSuccessMessage(__('%1 supplier(s) have been imported.', $result));
                    else
                        $this->messageManager->addWarningMessage(__('No supplier has been imported'));
                } else {
                    $this->messageManager->addErrorMessage(__('No supplier has been imported'));
                }

            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Invalid file upload attempt'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Invalid file upload attempt'));
        }
        $resultRedirect->setPath('*/*/index');
        return $resultRedirect;
    }
}
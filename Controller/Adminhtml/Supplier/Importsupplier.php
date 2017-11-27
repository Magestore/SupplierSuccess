<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\SupplierSuccess\Controller\Adminhtml\Supplier;

use Magento\Framework\Controller\ResultFactory;
use \Magestore\SupplierSuccess\Controller\Adminhtml\AbstractSupplier;

/**
 * Class DownloadSample
 * @package Magestore\SupplierSuccess\Controller\Adminhtml\Supplier
 */
class Importsupplier extends AbstractSupplier
{
    public function execute() {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Magestore_Storepickup::storepickup')
            ->addBreadcrumb(__('Supplier'), __('Supplier'))
            ->addBreadcrumb(__('Manage Suppliers'), __('Manage Suppliers'));
        $resultPage->getConfig()->getTitle()->prepend(__('Import Supplier'));

        return $resultPage;
    }
}
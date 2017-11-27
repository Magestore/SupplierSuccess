<?php
/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\SupplierSuccess\Controller\Adminhtml\Supplier;

use Magento\Framework\App\Filesystem\DirectoryList;
use \Magestore\SupplierSuccess\Controller\Adminhtml\AbstractSupplier;

/**
 * Class DownloadSample
 * @package Magestore\SupplierSuccess\Controller\Adminhtml\Supplier
 */
class DownloadSampleSupplier extends AbstractSupplier
{
    public function execute() {
        $fileName = 'supplier.csv';

        /** @var \Magento\Framework\App\Response\Http\FileFactory $fileFactory */
        $fileFactory = $this->_objectManager->get('Magento\Framework\App\Response\Http\FileFactory');

        return $fileFactory->create(
            $fileName,
            $this->getSupplierSampleData(),
            DirectoryList::VAR_DIR
        );
    }

    protected function getSupplierSampleData() {
        /** @var \Magento\Framework\Module\Dir $moduleReader */
        $moduleReader = $this->_objectManager->get('Magento\Framework\Module\Dir');
        /** @var \Magento\Framework\Filesystem\DriverPool $drivePool */
        $drivePool = $this->_objectManager->get('Magento\Framework\Filesystem\DriverPool');
        $drive = $drivePool->getDriver(\Magento\Framework\Filesystem\DriverPool::FILE);

        return $drive->fileGetContents($moduleReader->getDir('Magestore_SupplierSuccess')
            . DIRECTORY_SEPARATOR . '_fixtures' . DIRECTORY_SEPARATOR . 'supplier_sample.csv');
    }
}
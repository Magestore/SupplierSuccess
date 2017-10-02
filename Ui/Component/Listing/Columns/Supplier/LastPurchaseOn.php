<?php

/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magestore\SupplierSuccess\Ui\Component\Listing\Columns\Supplier;

use Magento\Framework\Stdlib\BooleanUtils;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\UiComponentInterface;

class LastPurchaseOn extends \Magento\Ui\Component\Listing\Columns\Date
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * LastPurchaseOn constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param TimezoneInterface $timezone
     * @param BooleanUtils $booleanUtils
     * @param array $components
     * @param array $data
     * @param \Magento\Framework\Module\Manager $moduleManager
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        TimezoneInterface $timezone,
        BooleanUtils $booleanUtils,
        array $components = [],
        array $data = [],
        \Magento\Framework\Module\Manager $moduleManager
    ){
        parent::__construct($context, $uiComponentFactory, $timezone, $booleanUtils, $components, $data);
        $this->moduleManager = $moduleManager;
    }

    /**
     * Prepare component configuration
     *
     * @return void
     */
    public function prepare()
    {
        parent::prepare();
        if (!$this->moduleManager->isOutputEnabled('Magestore_PurchaseOrderSuccess'))
            $this->_data['config']['component'] = false;
    }
}

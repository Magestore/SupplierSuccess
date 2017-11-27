<?php

/**
 * Copyright © 2016 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magestore\SupplierSuccess\Service\Supplier;

use Magestore\SupplierSuccess\Service\AbstractService;

class ImportService extends AbstractService
{
    public function importSupplier($data) {
        $total = 0;
        /** @var \Magento\Framework\Message\ManagerInterface $messageManager */
        $messageManager = $this->objectManager->get('Magento\Framework\Message\ManagerInterface');
        try {
            foreach ($data as $col => $row) {
                if ($col == 0) {
                    $index_row = $row;
                } else {
                    for ($i = 0; $i < count($row); $i++) {
                        $supplierData[$index_row[$i]] = $row[$i];
                    }
                    if(!$supplierData['supplier_code']
                        || !$supplierData['supplier_name']
                        || !$supplierData['contact_name']
                        || !$supplierData['contact_email']) {
                        continue;
                    }

                    if($this->supplierRepositoryInterface->getByCode($supplierData['supplier_code'])->getId()) {
                        continue;
                    }

                    $supplierData = $this->validateData($supplierData);
                    try {
                        $this->supplierFactory->create()->setData($supplierData)->save();
                        $total++;
                    }catch (\Exception $e) {

                    }
                }
            }
        } catch (\Exception $e) {
            $messageManager->addError($e->getMessage());
        }
        return $total;
    }

    /**
     * @param $country_id
     * @param $state_name
     * @return int
     */
    public function validateStateCountry($country_id, $state_name){
        /** @var \Magento\Directory\Model\ResourceModel\Region\Collection $collection */
        $collection = $this->regionFactory->create()->getCollection();
        $collection->addCountryFilter($country_id);

        if($state_name == ''){
            return 0;
        }

        if(sizeof($collection) > 0){
            $region_id = 0;
            foreach ($collection as $region){
                if(strcasecmp($state_name,$region->getData('default_name')) == 0){
                    $region_id = $region->getId();
                    break;
                }elseif(strcasecmp($state_name,$region->getData('code')) == 0){
                    $region_id = $region->getId();
                    break;
                }
            }
            return $region_id;
        } else {
            return 0;
        }
    }

    public function validateData(&$data) {
        $country = $this->countryFactory->create()->load($data['country_id']);
        if(!$country->getId()) {
            $data['country_id'] = '';
            $data['region'] = '';
            return $data;
        }
        $data['region_id'] = $this->validateStateCountry($data['country_id'], $data['region']);
        if(!$data['region_id']) {
            $data['country_id'] = '';
            $data['region_id'] = '';
            $data['region'] = '';
            return $data;
        }
        return $data;
    }
}
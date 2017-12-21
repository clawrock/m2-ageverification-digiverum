<?php

namespace ClawRock\Digiverum\Model\Transformer;

use ClawRock\Digiverum\Model\Value\Address as AddressValue;
use Magento\Directory\Model\Region;
use Magento\Framework\DataObject;

class Address
{
    const STREET_FIELD   = 'street';
    const CITY_FIELD     = 'city';
    const REGION_FIELD   = 'region_id';
    const POSTCODE_FIELD = 'postcode';

    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    protected $regionCollectionFactory;

    public function __construct(
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory
    ) {
        $this->regionCollectionFactory = $regionCollectionFactory;
    }

    public function transform(DataObject $request): AddressValue
    {
        $regionId = $request->getData(self::REGION_FIELD);
        /** @var Region $region */
        $region = $this->regionCollectionFactory->create()
            ->addFieldToFilter('main_table.region_id', $regionId)
            ->getFirstItem();

        return new AddressValue(
            $request->getData(self::STREET_FIELD),
            $request->getData(self::CITY_FIELD),
            $region instanceof Region ? $region->getCode() : '',
            $request->getData(self::POSTCODE_FIELD)
        );
    }
}

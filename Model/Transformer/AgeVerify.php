<?php

namespace ClawRock\Digiverum\Model\Transformer;

use ClawRock\Digiverum\Model\Value\AgeVerify as AgeVerifyValue;
use Magento\Framework\DataObject;

class AgeVerify
{
    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var Address
     */
    private $address;
    /**
     * @var Config
     */
    private $config;

    public function __construct(Customer $customer, Address $address, Config $config)
    {
        $this->customer = $customer;
        $this->address = $address;
        $this->config = $config;
    }

    public function transform(DataObject $request)
    {
        return new AgeVerifyValue(
            $this->customer->transform($request),
            $this->address->transform($request),
            $this->config->transform()
        );
    }
}

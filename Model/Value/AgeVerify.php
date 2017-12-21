<?php

namespace ClawRock\Digiverum\Model\Value;

class AgeVerify
{
    const PAYLOAD_KEY = 'chkUser';

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

    public function toArray(): array
    {
        return [
            self::PAYLOAD_KEY => array_merge(
                $this->config->toArray(),
                $this->customer->toArray(),
                $this->address->toArray()
            ),
        ];
    }
}

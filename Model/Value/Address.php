<?php

namespace ClawRock\Digiverum\Model\Value;

class Address
{
    const ADDRESS1_KEY = 'address1';
    const ADDRESS2_KEY = 'address2';
    const STATE_KEY    = 'state';
    const CITY_KEY     = 'city';
    const ZIP_KEY      = 'zip';

    /**
     * @var array
     */
    private $streets;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $postcode;

    /**
     * @var string
     */
    private $region;

    public function __construct($streets, string $city, string $region = null, string $postcode = null)
    {
        $this->streets = (array) $streets;
        $this->city = $city;
        $this->region = (string) $region;
        $this->postcode = (string) $postcode;
    }

    public function toArray(): array
    {
        return [
            self::ADDRESS1_KEY => $this->streets[0] ?? '',
            self::ADDRESS2_KEY => $this->streets[1] ?? '',
            self::STATE_KEY    => $this->region,
            self::CITY_KEY     => $this->city,
            self::ZIP_KEY      => $this->postcode,
        ];
    }
}

<?php

namespace ClawRock\Digiverum\Model\Value;

class Config
{
    const BRAND_KEY = 'brand';
    const ENV_KEY   = 'env';
    const IP_KEY    = 'ip';
    const GUID_KEY  = 'guid';

    /**
     * @var string
     */
    private $brand;
    /**
     * @var string
     */
    private $env;
    /**
     * @var string
     */
    private $ip;
    /**
     * @var string
     */
    private $guid;

    public function __construct(string $brand, string $env, string $ip, string $guid)
    {
        $this->brand = $brand;
        $this->env = $env;
        $this->ip = $ip;
        $this->guid = $guid;
    }

    public function toArray(): array
    {
        return [
            self::BRAND_KEY => $this->brand,
            self::ENV_KEY   => $this->env,
            self::IP_KEY    => $this->ip,
            self::GUID_KEY  => $this->guid,
        ];
    }
}

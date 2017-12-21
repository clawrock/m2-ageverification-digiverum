<?php

namespace ClawRock\Digiverum\Model\Transformer;

use ClawRock\Digiverum\Model\Value\Config as ConfigValue;

class Config
{
    /**
     * @var \ClawRock\Digiverum\Helper\Config
     */
    private $config;

    public function __construct(
        \ClawRock\Digiverum\Helper\Config $config
    ) {
        $this->config = $config;
    }

    public function transform(): ConfigValue
    {
        return new ConfigValue(
            $this->config->getBrand(),
            $this->config->getEnv(),
            $this->config->getIp(),
            $this->config->getGuid()
        );
    }
}

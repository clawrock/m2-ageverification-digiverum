<?php

namespace ClawRock\Digiverum\Helper;

use ClawRock\Digiverum\Model\Config\Source\Env;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const CONFIG_ENABLED = 'clawrock_digiverum/general/active';
    const CONFIG_URL     = 'clawrock_digiverum/general/url';
    const CONFIG_QA_URL  = 'clawrock_digiverum/general/url_qa';
    const CONFIG_BRAND   = 'clawrock_digiverum/general/brand';
    const CONFIG_IP      = 'clawrock_digiverum/general/ip';
    const CONFIG_ENV     = 'clawrock_digiverum/general/env';
    const CONFIG_GUID    = 'clawrock_digiverum/general/guid';

    public function isEnabled($store = null)
    {
        return (bool) $this->scopeConfig->getValue(self::CONFIG_ENABLED, ScopeInterface::SCOPE_STORE, $store);
    }

    public function getEnvUrl($store = null)
    {
        return $this->isProdEnv($store) ? $this->getUrl($store) : $this->getQaUrl($store);
    }

    public function getUrl($store = null)
    {
        return $this->scopeConfig->getValue(self::CONFIG_URL, ScopeInterface::SCOPE_STORE, $store);
    }

    public function getQaUrl($store = null)
    {
        return $this->scopeConfig->getValue(self::CONFIG_QA_URL, ScopeInterface::SCOPE_STORE, $store);
    }

    public function getBrand($store = null)
    {
        return $this->scopeConfig->getValue(self::CONFIG_BRAND, ScopeInterface::SCOPE_STORE, $store);
    }

    public function getIp($store = null)
    {
        return $this->scopeConfig->getValue(self::CONFIG_IP, ScopeInterface::SCOPE_STORE, $store);
    }

    public function getEnv($store = null)
    {
        return $this->scopeConfig->getValue(self::CONFIG_ENV, ScopeInterface::SCOPE_STORE, $store);
    }

    public function isProdEnv($store = null)
    {
        return $this->getEnv($store) === Env::PROD;
    }

    public function getGuid($store = null)
    {
        return $this->scopeConfig->getValue(self::CONFIG_GUID, ScopeInterface::SCOPE_STORE, $store);
    }
}

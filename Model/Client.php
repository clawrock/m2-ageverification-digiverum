<?php

namespace ClawRock\Digiverum\Model;

use ClawRock\AgeVerification\Api\Data\ResultInterface;

class Client
{
    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    private $httpClient;

    /**
     * @var \ClawRock\Digiverum\Helper\Config
     */
    private $config;

    public function __construct(
        \Magento\Framework\HTTP\Client\Curl $httpClient,
        \ClawRock\Digiverum\Helper\Config $config
    ) {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function authenticate(array $request): ResultInterface
    {
        $data = json_encode($request);

        $this->httpClient->addHeader('Content-Type', 'application/json; charset=UTF-8');
        $this->httpClient->addHeader('Content-Length', strlen($data));

        $this->httpClient->post($this->config->getEnvUrl(), $data);

        return new Result($this->httpClient->getBody());
    }
}

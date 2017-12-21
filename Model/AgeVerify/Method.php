<?php

namespace ClawRock\Digiverum\Model\AgeVerify;

use ClawRock\AgeVerification\Api\Data\MethodInterface;
use ClawRock\AgeVerification\Api\Data\PersistableResultInterface;
use ClawRock\AgeVerification\Api\Data\ResultInterface;
use Magento\Customer\Model\Customer;
use Magento\Framework\DataObject;

class Method implements MethodInterface
{
    const METHOD_TITLE = 'Digiverum';

    /**
     * @var \ClawRock\Digiverum\Model\Transformer\AgeVerify
     */
    private $ageVerify;

    /**
     * @var \ClawRock\Digiverum\Model\Client
     */
    private $client;

    /**
     * @var \ClawRock\Digiverum\Helper\Config
     */
    private $config;

    public function __construct(
        \ClawRock\Digiverum\Model\Transformer\AgeVerify $ageVerify,
        \ClawRock\Digiverum\Model\Client $client,
        \ClawRock\Digiverum\Helper\Config $config
    ) {
        $this->ageVerify = $ageVerify;
        $this->client = $client;
        $this->config = $config;
    }

    public function isValid(): bool
    {
        return $this->config->isEnabled();
    }

    public function authenticate(DataObject $request): ResultInterface
    {
        $data = $this->ageVerify->transform($request)->toArray();

        return $this->client->authenticate($data);
    }

    public function isCustomerAuthenticated(Customer $customer): bool
    {
        return $customer->getData(PersistableResultInterface::IS_VERIFIED_FIELD)
            && $customer->getData(PersistableResultInterface::TOKEN_FIELD)
            && $customer->getData(PersistableResultInterface::METHOD_FIELD);
    }

    public function getTitle(): string
    {
        return self::METHOD_TITLE;
    }
}

<?php

namespace ClawRock\Digiverum\Model;

use ClawRock\AgeVerification\Api\Data\PersistableResultInterface;
use ClawRock\AgeVerification\Exception\CustomerAuthenticationException;
use Magento\Customer\Model\Customer;

class Result implements PersistableResultInterface
{
    const VERIFIED_CODE     = 1;
    const NOT_VERIFIED_CODE = 2;
    const UNDER_AGE_CODE    = 3;

    /**
     * @var bool
     */
    private $authorized = false;

    /**
     * @var string
     */
    private $token;

    public function __construct(string $response)
    {
        try {
            $this->parseResponse($response);
        } catch (\Exception $e) {
            throw new CustomerAuthenticationException();
        }

        if (!$this->isAuthorized()) {
            throw new CustomerAuthenticationException();
        }
    }

    public function persistInCustomerData(Customer $customer, string $method)
    {
        if (!$this->isAuthorized()) {
            return;
        }

        $customer->setData(self::IS_VERIFIED_FIELD, true);
        $customer->setData(self::METHOD_FIELD, $method);
        $customer->setData(self::TOKEN_FIELD, $this->token);
    }

    public function isAuthorized(): bool
    {
        return $this->authorized;
    }

    protected function parseResponse(string $response)
    {
        $response = json_decode($response);

        if ($this->authorized = (self::VERIFIED_CODE === $response->VerifyResult->code)) {
            $this->token = $response->VerifyResult->trans_id;
        }
    }
}

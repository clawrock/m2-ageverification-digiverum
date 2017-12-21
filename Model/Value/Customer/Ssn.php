<?php

namespace ClawRock\Digiverum\Model\Value\Customer;

class Ssn
{
    /**
     * @var string
     */
    private $ssn;

    public function __construct(string $ssn = null)
    {
        $this->ssn = (string) $ssn;
    }

    public function getValue(): string
    {
        return $this->ssn;
    }
}

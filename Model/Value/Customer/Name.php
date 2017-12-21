<?php

namespace ClawRock\Digiverum\Model\Value\Customer;

class Name
{
    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $middlename;

    /**
     * @var string
     */
    private $lastname;

    public function __construct(string $firstname, string $middlename = null, string $lastname)
    {
        $this->firstname = $firstname;
        $this->middlename = (string) $middlename;
        $this->lastname = $lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getMiddlename(): string
    {
        return $this->middlename;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }
}

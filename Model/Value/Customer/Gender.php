<?php

namespace ClawRock\Digiverum\Model\Value\Customer;

class Gender
{
    const MALE        = 'Male';
    const FEMALE      = 'Female';
    const UNSPECIFIED = 'Unspecified';

    /**
     * @var string
     */
    private $gender;

    /**
     * @var array
     */
    private $types = [self::MALE, self::FEMALE, self::UNSPECIFIED];

    public function __construct(string $gender = null)
    {
        if (!empty($gender) && !in_array($gender, $this->types)) {
            throw new \RangeException('Wrong gender type.');
        }

        $this->gender = (string) $gender;
    }

    public function getValue(): string
    {
        return $this->gender;
    }
}

<?php

namespace ClawRock\Digiverum\Model\Value;

use ClawRock\AgeVerification\Model\Values\Dob;
use ClawRock\Digiverum\Model\Value\Customer\Gender;
use ClawRock\Digiverum\Model\Value\Customer\Name;
use ClawRock\Digiverum\Model\Value\Customer\Ssn;

class Customer
{
    const FIRSTNAME_KEY  = 'first_name';
    const MIDDLENAME_KEY = 'mid_name';
    const LASTNAME_KEY   = 'last_name';
    const GENDER_KEY     = 'gender';
    const DOB_KEY        = 'birth_date';
    const SSN_KEY        = 'ssn';

    /**
     * @var Name
     */
    private $name;

    /**
     * @var Gender
     */
    private $gender;

    /**
     * @var Ssn
     */
    private $ssn;

    /**
     * @var Dob
     */
    private $dob;

    public function __construct(Name $name, Gender $gender, Ssn $ssn, Dob $dob)
    {
        $this->gender = $gender;
        $this->ssn = $ssn;
        $this->dob = $dob;
        $this->name = $name;
    }

    public function toArray(): array
    {
        $data = [
            self::FIRSTNAME_KEY  => $this->name->getFirstname(),
            self::MIDDLENAME_KEY => $this->name->getMiddlename(),
            self::LASTNAME_KEY   => $this->name->getLastname(),
            self::GENDER_KEY     => $this->gender->getValue(),
            self::DOB_KEY        => $this->dob->getFullDate('m/d/Y'),
        ];

        if (!empty($this->ssn->getValue())) {
            $data[self::SSN_KEY] = $this->ssn->getValue();
        }

        return $data;
    }
}

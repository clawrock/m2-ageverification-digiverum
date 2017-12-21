<?php

namespace ClawRock\Digiverum\Model\Transformer;

use ClawRock\AgeVerification\Model\Transformers\Dob;
use ClawRock\Digiverum\Model\Transformer\Customer\Gender;
use ClawRock\Digiverum\Model\Transformer\Customer\Name;
use ClawRock\Digiverum\Model\Transformer\Customer\Ssn;
use ClawRock\Digiverum\Model\Value\Customer as CustomerValue;
use Magento\Framework\DataObject;

class Customer
{
    /**
     * @var Name
     */
    private $name;

    /**
     * @var Dob
     */
    private $dob;
    /**
     * @var Gender
     */
    private $gender;
    /**
     * @var Ssn
     */
    private $ssn;

    public function __construct(Name $name, Gender $gender, Ssn $ssn, Dob $dob)
    {
        $this->name = $name;
        $this->gender = $gender;
        $this->ssn = $ssn;
        $this->dob = $dob;
    }

    public function transform(DataObject $request): CustomerValue
    {
        return new CustomerValue(
            $this->name->transform($request),
            $this->gender->transform($request),
            $this->ssn->transform($request),
            $this->dob->transform($request)
        );
    }
}

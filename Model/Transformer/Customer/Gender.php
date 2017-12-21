<?php

namespace ClawRock\Digiverum\Model\Transformer\Customer;

use ClawRock\Digiverum\Model\Value\Customer\Gender as GenderValue;
use Magento\Framework\DataObject;

class Gender
{
    const GENDER_FIELD = 'gender';

    const MALE        = '1';
    const FEMALE      = '2';
    const UNSPECIFIED = '3';

    public function transform(DataObject $request): GenderValue
    {
        $genderValues = [
            self::MALE        => GenderValue::MALE,
            self::FEMALE      => GenderValue::FEMALE,
            self::UNSPECIFIED => GenderValue::UNSPECIFIED,
        ];

        $gender = $genderValues[$request->getData(self::GENDER_FIELD)] ?? '';

        return new GenderValue($gender);
    }
}


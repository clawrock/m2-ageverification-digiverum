<?php

namespace ClawRock\Digiverum\Model\Transformer\Customer;

use ClawRock\Digiverum\Model\Value\Customer\Name as NameValue;
use Magento\Framework\DataObject;

class Name
{
    const FIRSTNAME_FIELD  = 'firstname';
    const MIDDLENAME_FIELD = 'middlename';
    const LASTNAME_FIELD   = 'lastname';

    public function transform(DataObject $request): NameValue
    {
        return new NameValue(
            $request->getData(self::FIRSTNAME_FIELD),
            $request->getData(self::MIDDLENAME_FIELD),
            $request->getData(self::LASTNAME_FIELD)
        );
    }
}

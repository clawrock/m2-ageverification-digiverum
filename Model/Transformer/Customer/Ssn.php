<?php

namespace ClawRock\Digiverum\Model\Transformer\Customer;

use ClawRock\Digiverum\Model\Value\Customer\Ssn as SsnValue;
use Magento\Framework\DataObject;

class Ssn
{
    const SSN_FIELD = 'ssn';

    public function transform(DataObject $request)
    {
        return new SsnValue($request->getData(self::SSN_FIELD));
    }
}

<?php

namespace ClawRock\Digiverum\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Env implements ArrayInterface
{
    const PROD = 'PROD';
    const QA   = 'QA';

    public function toOptionArray()
    {
        return [
            ['value' => self::QA, 'label' => self::QA],
            ['value' => self::PROD, 'label' => self::PROD],
        ];
    }
}

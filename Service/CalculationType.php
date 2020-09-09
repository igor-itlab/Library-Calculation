<?php

namespace Calculation\Service;

use Calculation\Payment;
use Calculation\Payout;
use stdClass;

/**
 * Class CalculationType
 * @package Calculation\Service
 */
class CalculationType
{
    /**
     * @return stdClass
     */
    public static function getType(): stdClass
    {
        $list = new stdClass();

        $list->payment = new Payment();
        $list->payout = new Payout();

        return $list;
    }
}
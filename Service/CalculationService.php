<?php

namespace Calculation\Service;


use Calculation\Service\States\Payment;
use Calculation\Service\States\Payout;
use stdClass;

/**
 * Class CalculationService
 * @package Calculation\Service
 */
class CalculationService
{
    /**
     * @param string $type
     * @return mixed
     */
    public static function calculate(string $type)
    {
        $type = strtolower($type);

        return self::getType()->$type;
    }

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
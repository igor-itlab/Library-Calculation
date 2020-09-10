<?php


namespace Calculation\Service;

use Calculation\Utils\Calculation\CalculationInterface;

/**
 * Class Exchange
 * @package Calculation\Service
 */
class Exchange
{
    /**
     * @param string $type
     * @return mixed
     */
    public static function calculation(string $type): CalculationInterface
    {
        $type = strtolower($type);

        return CalculationType::getType()->$type;
    }
}
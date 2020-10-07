<?php


namespace Calculation\Utils\Calculation;


use Calculation\Utils\Exchange\PairInterface;

/**
 * Interface RatesInterface
 * @package Calculation\Utils\Calculation
 */
interface RatesInterface
{
    /**
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateRates(PairInterface $pair): float;
}

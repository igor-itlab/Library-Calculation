<?php


namespace Calculation\Utils\Calculation;


use Calculation\Utils\Exchange\PairInterface;

/**
 * Interface RatesInterface
 * @package Calculation\Utils\Calculation
 */
interface RateInterface
{
    /**
     * @param PairInterface $pair
     * @param string $direction
     * @return float
     */
    public static function calculate(PairInterface $pair, string $direction): float;
}

<?php

namespace Calculation\Utils\Calculation;

use Calculation\Utils\Exchange\PairInterface;

/**
 * Interface LimitsInterface
 * @package Calculation\Utils\Calculation
 */
interface LimitsInterface
{
    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void;

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void;

    /**
     * @param float $amount
     * @param float $percent
     * @return float
     */
    public static function calculatePercent(float $amount, float $percent): float;
}

<?php

namespace Calculation\Utils\Calculation;

use Calculation\Utlis\Exchange\PairInterface;

/**
 * Interface CalculationInterface
 * @package Calculation\Utils\Calculation
 */
interface CalculationInterface
{
    /**
     * @param float $amount
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateAmount(float $amount, PairInterface $pair): float;

    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void;

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void;
}
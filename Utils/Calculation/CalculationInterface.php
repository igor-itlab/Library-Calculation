<?php

namespace Calculation\Utils\Calculation;

use Calculation\Utils\Exchange\PairInterface;

/**
 * Interface CalculationInterface
 * @package Calculation\Utils\Calculation
 */
interface CalculationInterface
{
    /**
     * @param PairInterface $pair
     * @param float|null $amount
     */
    public static function calculateAmount(PairInterface $pair, float $amount = null): void;

    /**
     * @param PairInterface $pair
     */
    public static function calculateMin(PairInterface $pair): void;

    /**
     * @param PairInterface $pair
     */
    public static function calculateMax(PairInterface $pair): void;
}
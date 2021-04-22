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
     * @param float|null $percent
     */
    public static function calculateAmount(PairInterface $pair, float $amount = null, float $percent = null): void;
}

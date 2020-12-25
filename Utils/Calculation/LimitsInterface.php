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
}

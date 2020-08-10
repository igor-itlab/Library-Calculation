<?php


namespace Calculation;


use Calculation\Entity\PairInterface;


/**
 * Interface CalculationInterface
 * @package Calculation
 */
interface CalculationInterface
{
    /**
     * @param float $count
     * @param PairInterface $pair
     * @return float
     */
    public static function calculateOnChangeValue(float $count, PairInterface $pair): float;

    /**
     * @param PairInterface $pair
     */
    public static function calculateMinValue(PairInterface $pair);

    /**
     * @param PairInterface $pair
     */
    public static function calculateMaxValue(PairInterface $pair);
}
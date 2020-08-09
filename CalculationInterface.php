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
    static public function calculateOnChangeValue(float $count, PairInterface $pair): float;

    /**
     * @param PairInterface $pair
     * @return float
     */
    static public function calculateMinValue(PairInterface $pair);

    /**
     * @param PairInterface $pair
     * @return float
     */
    static public function calculateMaxValue(PairInterface $pair);
}
<?php


namespace Calculation;


use Calculation\Entity\PairInterface;


/**
 * Class Payin
 * @package Calculation
 */
class Payin implements CalculationInterface
{
    /**
     * @param float $count
     * @param PairInterface $pair
     * @return float
     */
    static public function calculateOnChangeValue(float $count, PairInterface $pair): float
    {
//        $course = Course::calculateCourse();
//
//        $countWithCommission = $count - ($count * $paymentPercent) / 100 - $paymentConstant;
//        $countReceivedByCourse = $countWithCommission / $course;
//
//        $countWithSystemCommission = $countReceivedByCourse * (1 - $exchangePercent / 100) - $exchangeConstant;
    }

    /**
     * @param PairInterface $pair
     * @return float|void
     */
    static public function calculateMinValue(PairInterface $pair)
    {
        // TODO: Implement calculateMinValue() method.
    }

    /**
     * @param PairInterface $pair
     * @return float|void
     */
    static public function calculateMaxValue(PairInterface $pair)
    {
        // TODO: Implement calculateMaxValue() method.
    }
}
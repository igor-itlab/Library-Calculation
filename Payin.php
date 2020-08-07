<?php


namespace Calculation;


use Calculation\Entity\PairUnitInterface;

class Payin implements CalculationInterface
{
    public function calculateOnChangeValue(float $count, PairUnitInterface $payin, PairUnitInterface $payout): float
    {
//        $course = Course::calculateCourse();
//
//        $countWithCommission = $count - ($count * $paymentPercent) / 100 - $paymentConstant;
//        $countReceivedByCourse = $countWithCommission / $course;
//
//        $countWithSystemCommission = $countReceivedByCourse * (1 - $exchangePercent / 100) - $exchangeConstant;
    }

    public function calculateMinValue(PairUnitInterface $payin, PairUnitInterface $payout): float
    {
        // TODO: Implement calculateMinValue() method.
    }

    public function calculateMaxValue(PairUnitInterface $payin, PairUnitInterface $payout): float
    {
        // TODO: Implement calculateMaxValue() method.
    }
}
<?php


namespace Calculation;


use Calculation\Entity\PairUnitInterface;

class Payin implements CalculationInterface
{

    public function calculateOnChangeValue(float $count, PairUnitInterface $payin, PairUnitInterface $payout): float
    {
        // TODO: Implement calculateOnChangeValue() method.
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
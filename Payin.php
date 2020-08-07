<?php


namespace Calculation;


use Calculation\Entity\PairUnitInterface;

class Payin implements CalculationInterface
{

    public function calculateOnChangeValue(float $count, PairUnitInterface $payin, PairUnitInterface $payout): float
    {
        // TODO: Implement calculateOnChangeValue() method.
    }

    public function calculateMinValue(): float
    {
        // TODO: Implement calculateMinValue() method.
    }

    public function calculateMaxValue(): float
    {
        // TODO: Implement calculateMaxValue() method.
    }
}
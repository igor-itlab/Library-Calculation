<?php


namespace Calculation;



class Payout implements CalculationInterface
{
    public function calculateOnChangeValue(
        float $count,
        ChangeConfigInterface $payin,
        ChangeConfigInterface $payout
    ): float {
        return ($count + $payout->getConstant())
    }

    public function calculateMinValue(ChangeConfigInterface $payin, ChangeConfigInterface $payout): float
    {
        // TODO: Implement calculateMinValue() method.
    }

    public function calculateMaxValue(ChangeConfigInterface $payin, ChangeConfigInterface $payout): float
    {
        // TODO: Implement calculateMaxValue() method.
    }
}
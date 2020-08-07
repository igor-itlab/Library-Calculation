<?php


namespace Calculation;


use Calculation\Entity\PairUnitInterface;

interface CalculationInterface
{
    public function calculateOnChangeValue(float $count, PairUnitInterface $payin, PairUnitInterface $payout): float;

    public function calculateMinValue(PairUnitInterface $payin, PairUnitInterface $payout): float;

    public function calculateMaxValue(PairUnitInterface $payin, PairUnitInterface $payout): float;
}
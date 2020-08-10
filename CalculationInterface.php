<?php


namespace Calculation;


interface CalculationInterface
{
    public function calculateOnChangeValue(float $count, ChangeConfigInterface $payin, ChangeConfigInterface $payout): float;

    public function calculateMinValue(ChangeConfigInterface $payin, ChangeConfigInterface $payout): array;

    public function calculateMaxValue(ChangeConfigInterface $payin, ChangeConfigInterface $payout): array;
}
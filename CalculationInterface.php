<?php


namespace Calculation;


interface CalculationInterface
{
    public function calculateOnChangeValue(): float;

    public function calculateMinValue(): float;

    public function calculateMaxValue(): float;
}
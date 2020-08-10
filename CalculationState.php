<?php


namespace Calculation;


/**
 * Class CalculationState
 * @package Calculation
 */
abstract class CalculationState
{
    /**
     * @var CalculationContext
     */
    protected CalculationContext $context;

    public function setContext(CalculationContext $context): void
    {
        $this->context = $context;
    }
}
<?php


namespace Calculation;


use Calculation\Entity\PairInterface;

/**
 * Class CalculationState
 * @package Calculation
 */
abstract class CalculationState implements CalculationInterface
{
    /**
     * @var CalculationContext
     */
    protected CalculationContext $context;

    public function setContext(CalculationContext $context): void
    {
        $this->context = $context;
    }

    abstract public static function calculateOnChangeValue(float $count, PairInterface $pair): float;

    abstract public static function calculateMinValue(PairInterface $pair);

    abstract public static function calculateMaxValue(PairInterface $pair);
}
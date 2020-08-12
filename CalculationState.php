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

    /**
     * @param CalculationContext $context
     */
    public function setContext(CalculationContext $context): void
    {
        $this->context = $context;
    }

    /**
     * @param float $count
     * @param PairInterface $pair
     * @return float
     */
    abstract public static function calculateOnChangeValue(float $count, PairInterface $pair): float;

    /**
     * @param PairInterface $pair
     * @return mixed
     */
    abstract public static function calculateMinValue(PairInterface $pair);

    /**
     * @param PairInterface $pair
     * @return mixed
     */
    abstract public static function calculateMaxValue(PairInterface $pair);
}
<?php


namespace Calculation;


use Calculation\Entity\PairInterface;

/**
 * Class CalculationContext
 * @package Calculation
 */
class CalculationContext
{
    /**
     * @var CalculationState
     */
    private CalculationState $state;

    /**
     * CalculationContext constructor.
     * @param CalculationState $state
     */
    public function __construct(CalculationState $state)
    {
        $this->setState($state);
    }

    /**
     * @param CalculationState $state
     */
    public function setState(CalculationState $state): void
    {
        $this->state = $state;
        $this->state->setContext($this);
    }

    /**
     * @param float $count
     * @param PairInterface $pair
     * @return float
     */
    public function calculateOnChangeValue(float $count, PairInterface $pair): float
    {
        return $this->state::calculateOnChangeValue($count, $pair);
    }

    /**
     * @param PairInterface $pair
     */
    public function calculateMinContribution(PairInterface $pair): void
    {
        $this->state::calculateMinValue($pair);
    }

    /**
     * @param PairInterface $pair
     */
    public function calculateMaxContribution(PairInterface $pair): void
    {
        $this->state::calculateMaxValue($pair);
    }
}
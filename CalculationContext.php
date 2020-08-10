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

    public function __construct(CalculationState $state)
    {
        $this->setState($state);
    }

    public function setState(CalculationState $state): void
    {
        $this->state = $state;
        $this->state->setContext($this);
    }

    /**
     * @param float $count
     * @param PairInterface $pair
     */
    public function calculateOnChangeValue(float $count, PairInterface $pair): void
    {
        $this->state::calculateOnChangeValue($count, $pair);
    }

    public function calculateMinContribution(PairInterface $pair): void
    {
        $this->state::calculateMinValue($pair);
    }

    public function calculateMaxContribution(PairInterface $pair): void
    {
        $this->state::calculateMaxValue($pair);
    }
}
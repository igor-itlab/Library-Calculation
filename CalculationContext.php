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
     * @return float
     */
    public function calculateOnChangeValue(float $count, PairInterface $pair): float
    {
        return $this->state::calculateOnChangeValue($count, $pair);
    }

    /**
     * @param PairInterface $pair
     * @return mixed
     */
    public function calculateMinContribution(PairInterface $pair)
    {
        return $this->state::calculateMinValue($pair);
    }

    /**
     * @param PairInterface $pair
     * @return mixed
     */
    public function calculateMaxContribution(PairInterface $pair)
    {
        return $this->state::calculateMaxValue($pair);
    }
}
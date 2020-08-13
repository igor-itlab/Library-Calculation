<?php


namespace Calculation;


use Calculation\Entity\PairInterface;
use Calculation\Service\Converter;

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
     * @param PairInterface $pair
     */
    public function __construct(PairInterface $pair)
    {
        $this->setState($pair);
    }

    /**
     * @param PairInterface $pair
     */
    public function setState(PairInterface $pair): void
    {
        $this->state = Converter::toObject($pair->getState());
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
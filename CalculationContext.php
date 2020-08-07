<?php


namespace Calculation;


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
}
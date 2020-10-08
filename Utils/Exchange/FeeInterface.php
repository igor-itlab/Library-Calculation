<?php


namespace Calculation\Utils\Exchange;


interface FeeInterface
{
    /**
     * @return float
     */
    public function getPercent(): float;

    /**
     * @return float
     */
    public function getConstant(): float;

    /**
     * @return float
     */
    public function getMax(): float;

    /**
     * @return float
     */
    public function getMin(): float;
}

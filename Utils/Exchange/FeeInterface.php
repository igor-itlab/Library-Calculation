<?php


namespace Calculation\Utils\Exchange;

/**
 * Interface FeeInterface
 * @package Calculation\Utils\Exchange
 */
interface FeeInterface
{
    /**
     * @return float|null
     */
    public function getPercent(): ?float;

    /**
     * @return float|null
     */
    public function getConstant(): ?float;

    /**
     * @return float|null
     */
    public function getMax(): ?float;

    /**
     * @return float|null
     */
    public function getMin(): ?float;
}

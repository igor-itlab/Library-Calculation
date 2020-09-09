<?php

namespace Calculation\Utlis\Exchange;

/**
 * Interface CurrencyInterface
 * @package Calculation\Utlis\Exchange
 */
interface CurrencyInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return float
     */
    public function getRate(): float;

    /**
     * @return float
     */
    public function getInRate(): float;

    /**
     * @return float
     */
    public function getOutRate(): float;
}
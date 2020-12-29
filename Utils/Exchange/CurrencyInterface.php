<?php

namespace Calculation\Utils\Exchange;

/**
 * Interface CurrencyInterface
 * @package Calculation\Utils\Exchange
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
     * @return string
     */
    public function getTag(): string;

    /**
     * @return float
     */
    public function getPaymentRate(): float;

    /**
     * @return float
     */
    public function getPayoutRate(): float;

    /**
     * @return float
     */
    public function getPaymentRateForCalc(): float;

    /**
     * @return float
     */
    public function getPayoutRateForCalc(): float;

}

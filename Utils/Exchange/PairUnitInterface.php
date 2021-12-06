<?php

namespace Calculation\Utils\Exchange;


/**
 * Interface PairUnitInterface
 * @package Calculation\Utils\Exchange
 */
interface PairUnitInterface
{
    /**
     * @return CurrencyInterface
     */
    public function getCurrency(): CurrencyInterface;

    /**
     * @return PaymentSystemInterface
     */
    public function getPaymentSystem(): PaymentSystemInterface;

    /**
     * @return FeeInterface
     */
    public function getFee(): FeeInterface;

    /**
     * @return string
     */
    public function getDirection(): string;

    /**
     * @return float
     */
    public function getPrice(): float;

    /**
     * @return float
     */
    public function getAmount(): float;

    /**
     * @param float $amount
     * @return PairUnitInterface
     */
    public function setAmount(float $amount): PairUnitInterface;

    /**
     * @return float
     */
    public function getMin(): float;

    /**
     * @param float $min
     * @return PairUnitInterface
     */
    public function setMin(float $min): PairUnitInterface;

    /**
     * @return float
     */
    public function getMax(): float;

    /**
     * @param float $max
     * @return PairUnitInterface
     */
    public function setMax(float $max): PairUnitInterface;
}

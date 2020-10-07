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
     * @return ServiceInterface
     */
    public function getService(): ServiceInterface;

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
     * @return FeeInterface
     */
    public function getPrimeFee(): FeeInterface;

    /**
     * @return FeeInterface
     */
    public function getMarkupFee(): FeeInterface;

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

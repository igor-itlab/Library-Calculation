<?php

namespace Calculation\Utils\Exchange;


/**
 * Interface PairComponentInterface
 * @package Calculation\Utils\Exchange
 */
interface PairComponentInterface
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
     * @return PairComponentInterface
     */
    public function setAmount(float $amount): PairComponentInterface;

    /**
     * @return array
     */
    public function inFee(): array;

    /**
     * @return array
     */
    public function outFee(): array;

    /**
     * @return float
     */
    public function getMin(): float;

    /**
     * @param float $min
     * @return PairComponentInterface
     */
    public function setMin(float $min): PairComponentInterface;

    /**
     * @return float
     */
    public function getMax(): float;

    /**
     * @param float $max
     * @return PairComponentInterface
     */
    public function setMax(float $max): PairComponentInterface;
}
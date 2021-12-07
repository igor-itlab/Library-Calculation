<?php

namespace Calculation\Utils\Exchange;


/**
 * Interface PairUnitInterface
 * @package Calculation\Utils\Exchange
 */
interface PairUnitInterface
{
    /**
     * @return CurrencyInterface|null
     */
    public function getCurrency(): ?CurrencyInterface;

    /**
     * @return PaymentSystemInterface|null
     */
    public function getPaymentSystem(): ?PaymentSystemInterface;

    /**
     * @return FeeInterface|null
     */
    public function getFee(): ?FeeInterface;

    /**
     * @return string|null
     */
    public function getDirection(): ?string;

    /**
     * @return float|null
     */
    public function getPrice(): ?float;

    /**
     * @return float|null
     */
    public function getAmount(): ?float;

    /**
     * @param float $amount
     * @return PairUnitInterface|null
     */
    public function setAmount(float $amount): ?PairUnitInterface;

    /**
     * @return float|null
     */
    public function getMin(): ?float;

    /**
     * @param float $min
     * @return PairUnitInterface|null
     */
    public function setMin(float $min): ?PairUnitInterface;

    /**
     * @return float|null
     */
    public function getMax(): ?float;

    /**
     * @param float $max
     * @return PairUnitInterface|null
     */
    public function setMax(float $max): ?PairUnitInterface;
}

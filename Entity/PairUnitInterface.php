<?php


namespace Calculation\Entity;


/**
 * Interface PairUnitInterface
 * @package Calculation\Entity
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
     * @return ProviderInterface
     */
    public function getProvider(): ProviderInterface;

    /**
     * @return float
     */
    public function getOnChangeValue(): float;

    /**
     * @param float $onChangeValue
     * @return PairUnitInterface
     */
    public function setOnChangeValue(float $onChangeValue): PairUnitInterface;

    /**
     * @return float
     */
    public function getMinExchangeLimit(): float;

    /**
     * @param float $minExchangeLimit
     * @return PairUnitInterface
     */
    public function setMinExchangeLimit(float $minExchangeLimit): PairUnitInterface;

    /**
     * @return float
     */
    public function getMaxExchangeLimit(): float;

    /**
     * @param float $maxExchangeLimit
     * @return PairUnitInterface
     */
    public function setMaxExchangeLimit(float $maxExchangeLimit): PairUnitInterface;
}
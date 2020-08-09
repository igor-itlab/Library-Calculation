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
}
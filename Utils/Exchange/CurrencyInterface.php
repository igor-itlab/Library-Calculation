<?php

namespace Calculation\Utils\Exchange;

/**
 * Interface CurrencyInterface
 * @package Calculation\Utils\Exchange
 */
interface CurrencyInterface
{
    /**
     * @const CURRENCY
     */
    public const CURRENCY = 'CURRENCY';

    /**
     * @const CRYPTO
     */
    public const CRYPTO = 'CRYPTO';

    /**
     * @return string
     */
    public function getAsset(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getTag(): string;

    /**
     * @return float
     */
    public function getBasePurchaseRate(): float;

    /**
     * @return float
     */
    public function getBaseSellingRate(): float;

    /**
     * @return float
     */
    public function getPurchaseRate(): float;

    /**
     * @return float
     */
    public function getSellingRate(): float;

    /**
     * @return ServiceInterface
     */
    public function getService(): ServiceInterface;
}

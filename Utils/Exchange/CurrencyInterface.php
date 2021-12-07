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
     * @return string|null
     */
    public function getAsset(): ?string;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @return string|null
     */
    public function getTag(): ?string;

    /**
     * @return float|null
     */
    public function getBasePurchaseRate(): ?float;

    /**
     * @return float|null
     */
    public function getBaseSellingRate(): ?float;

    /**
     * @return float|null
     */
    public function getPurchaseRate(): ?float;

    /**
     * @return float|null
     */
    public function getSellingRate(): ?float;

    /**
     * @return ServiceInterface|null
     */
    public function getService(): ?ServiceInterface;
}

<?php

namespace Calculation\Utlis\Exchange;

/**
 * Interface PaymentSystemInterface
 * @package Calculation\Utlis\Exchange
 */
interface PaymentSystemInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getTag(): string;

    /**
     * @return string
     */
    public function getSubName(): string;

    /**
     * @return float
     */
    public function getCostPrice(): float;
}